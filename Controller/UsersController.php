<?php

App::uses('AppController', 'Controller');
App::uses('CakeTime', 'Utility');
/* * *Fin** */
//require_once ROOT . DS . 'app' . DS . 'Plugin' . DS . 'Accounts' . DS . 'Vendor' . DS . 'Recaptcha' . DS . 'recaptchalib.php';
App::import('Accounts.Vendor', 'Recaptcha/recaptchalib');


/* * * Integracion con facebook** */
App::import(ROOT . DS . 'app' . DS . 'Plugin' . DS . 'Accounts' . DS . 'Vendor' . DS . 'Facebook' . DS . 'facebook.php');
require_once ROOT . DS . 'app' . DS . 'Plugin' . DS . 'Accounts' . DS . 'Vendor' . DS . 'Facebook' . DS . 'facebook.php';
/* * *Fin** */

/* * *Integracion con Twitter** */
require_once ROOT . DS . 'app' . DS . 'Plugin' . DS . 'Accounts' . DS . 'Vendor' . DS . 'Twitter' . DS . 'twitteroauth.php';

/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AccountsAppController {

	public $helpers = array();
//	public $uses = array('Accounts.User');
	var $components = array();
	public $facebook;
	public $fbuid = '';
	public $uses = array();
	public $google = '';
	public $plus_service;
	public $oauth2service;
	private $accessToken = '';

	public function beforeFilter() {
		parent::beforeFilter();
		if (CakePlugin::loaded('Gamification')) {
			$this->components = array('Resources.Resources');
		}

		$this->facebook = new Facebook(array(
				'appId' => Configure::read('Accounts.facebook.appId'),
				'secret' => Configure::read('Accounts.facebook.secret'),
				'cookie' => true
			));
		if ($this->Session->check('accessToken')) {
			$this->accessToken = $this->Session->read('accessToken');
		}
		if (Configure::read('debug') > 1) {
			$this->Auth->allow();
		} else {
			$this->Auth->allow(array('welcome', 'login', 'register', 'logout', 'goodbye', 'admin_logout', 'remember'));
		}
		$this->loadModel('Accounts.User');
	}

	public function admin_index() {
		$this->User->recursive = 1;
		if ($this->authuser['Group']['name'] == 'superadmin') {
			$this->paginate = array(
				'order' => array('User.id' => 'desc'),
				'conditions' => array('User.deleted ' => Configure::read('zero_datetime')),
				'limit' => 20
			);
		} else {
			$this->paginate = array(
				'order' => array('User.id' => 'desc'),
				'conditions' => array('User.deleted' => Configure::read('zero_datetime'), 'Group.name !=' => 'superadmin'),
				'limit' => 10
			);
		}
		$this->set('users', $this->paginate());
	}

	public function admin_view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

	public function admin_add() {
		$this->loadModel('Configurations.Location');
		if ($this->request->is('post')) {
			/* ====== LOCATION ========= */
			if (Configure::read('Configuration.location.tree')) {
				$array_locations = array_filter($this->request->data['Profile']['location_id']);
				$locations = $this->Location->sections($this->request->data['Profile']['location_id']);
				$locations_post = $this->request->data['Profile']['location_id'];
				$this->request->data['Profile']['location_id'] = end($array_locations);
				$location_id = $array_locations[0];
			} else {
				$location_id = $this->request->data['Profile']['location_id'];
			}


			if (empty($this->request->data['Profile']['location_id'])) {
				unset($this->request->data['Profile']['location_id']);
			}
			/* ====== LOCATION ========= */
			$this->User->create();

			$this->User->set($this->request->data);
			$this->User->Profile->set($this->request->data);
			$this->User->validator()->remove('accept_terms');
			if ($this->User->validates() && $this->User->Profile->validates()) {
				$this->request->data['User']['banned'] = Configure::read('zero_datetime');
				$this->request->data['User']['deleted'] = Configure::read('zero_datetime');
				if ($this->User->save($this->request->data, false)) {

					$this->request->data['Profile']['user_id'] = $this->User->id;
					$this->User->Profile->save($this->request->data);

					if (Configure::read('Accounts.register.aros') && CakePlugin::loaded('Acl')) {
						$this->loadModel('Acl.ManagedAro');
						$parent = $this->ManagedAro->find('first', array(
							'conditions' => array('ManagedAro.model' => 'Group', 'ManagedAro.foreign_key' => $this->request->data['User']['group_id'])
							));
						if (!empty($parent)) {
							$this->ManagedAro->create(array(
								'parent_id' => $parent['ManagedAro']['id'],
								'model' => 'User',
								'foreign_key' => $this->User->id,
								'alias' => $this->request->data['User']['username'],
							));

							$this->ManagedAro->save();
						} else {
							$this->Session->setFlash(__d('accounts', 'Please ask the administrator to fix ACL, user groups'), 'flash/error');
							return true;
						}
					}

					if (Configure::read('Accounts.add.send.email')) {
						$this->__send_email($this->request->data['User']['username'], $this->request->data['User']['password'], $this->request->data['User']['email']);
					}

					$this->Session->setFlash(__d('accounts', 'The user has been saved'), 'flash/success');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__d('accounts', 'The user could not be saved. Please, try again.'), 'flash/error');
				}
			} else {
				$this->Session->setFlash(__d('accounts', 'The user could not be saved. Please, try again.'), 'flash/warning');
			}

			$this->request->data['User']['password'] = '';
			if (Configure::read('Configuration.location.tree')) {
				$this->request->data['Profile']['location_id'] = $locations_post;
			}
		} else {
			if (Configure::read('Configuration.location.tree')) {
				$locations = $this->Location->sections(array(0 => null));
			} else {
				$locations = $this->Location->find('list');
			}
		}
		if ($this->authuser['Group']['name'] == 'superadmin') {
			$groups = $this->User->Group->find('list');
		} else {
			$groups = $this->User->Group->find('list', array('conditions' => array('Group.name !=' => 'superadmin')));
		}
		$doctypes = $this->User->Profile->DocidType->find('list', array('fields' => array('id', 'name')));
		$this->set(compact('groups', 'locations', 'doctypes'));
	}

	public function admin_edit($id = null) {

		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {


			$this->User->set($this->request->data);

			if ($this->User->validates()) {
				if (!empty($this->request->data['User']['password'])) {

					$attempts = $this->User->UserPassword->find('count', array(
						'conditions' => array(
							'UserPassword.password' => $this->request->data['User']['password'],
							'UserPassword.user_id' => $this->request->data['User']['id'],
						)
						));
					if ($attempts > 0) {
						$this->Session->setFlash(__d('accounts', 'For safety reasons not to repeat the password'), 'flash/warning');
						$this->redirect(array('action' => 'edit', 'admin' => true, $this->request->data['User']['id']));
					}
				} else {
					unset($this->request->data['User']['password']);
				}
				$this->User->validator()->remove('password', 'regexp');
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__d('accounts', 'The user has been saved'), 'flash/success');
					$this->redirect(array('action' => 'index', 'admin' => true));
				} else {
					$this->Session->setFlash(__d('accounts', 'The user could not be saved. Please, try again.'), 'flash/error');
				}
			} else {
				$this->request->data['User']['password'] = '';
//				pr($this->User->validationErrors);
			}
		} else {
			
		}
		$this->request->data = $this->User->find('first', array('conditions' => array('User.' . $this->User->primaryKey => $id)));
		$this->request->data = array_merge($this->User->find('first', array('conditions' => array('User.' . $this->User->primaryKey => $id))), $this->request->data);

		unset($this->request->data['User']['password']);
		if ($this->authuser['Group']['name'] == 'superadmin') {
			$groups = $this->User->Group->find('list');
		} else {
			$groups = $this->User->Group->find('list', array('conditions' => array('Group.name !=' => 'superadmin')));
		}
		$this->set(compact('groups'));
	}

	public function admin_delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}

		$this->User->updateAll(
			array('User.deleted' => "'" . date('Y-m-d H:i:s') . "'"), array('User.id' => $id)
		);
		$this->Session->setFlash(__d('accounts', 'User was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));


		$query = $this->User->updateAll(
			array('User.deleted' => "'" . date('Y-m-d H:i:s') . "'"), array('User.id' => $id)
		);
	}

	public function login() {
		$this->loadModel('Accounts.UserLog');
		if ($this->Session->read('Auth.User')) {
			$this->redirect(array('plugin' => 'dashboard', 'controller' => 'Dashboard'));
		}
		$this->loadModel('UserLog');

		if ($this->request->is('post')) {
			$attempts = $this->UserLog->find('count', array(
				'conditions' => array(
					'UserLog.username' => $this->request->data['User']['username'],
					'UserLog.ip' => $this->request->clientIp(),
					'UserLog.created >=' => date('Y-m-d H:i:s', strtotime('-10 minutes')),
					'UserLog.is_correct' => 0
				)
				));

			if ($attempts < 10) {

				$this->User->recursive = 1;
				if ($this->Auth->login()) {
					$authuser = $this->Auth->user();
					if (CakePlugin::loaded('Gamification')) {
						$this->Gamification->saveActivity('login', $authuser['id']);
					}
					if (CakePlugin::loaded('MenuManager')) {
						if ($this->Session->check('set_menu')) {
							$this->Session->delete('set_menu');
							$this->Session->delete('menu_options');
						}
					}

					$this->UserLog->create(array(
						'username' => $this->request->data['User']['username'],
						'ip' => $this->request->clientIp(),
						'user_agent' => $_SERVER['HTTP_USER_AGENT'],
						'is_correct' => 1
						)
					);
					$this->UserLog->save();

					if (CakePlugin::loaded('Resources') && Configure::read('Accounts.profile.picture') == TRUE) {
						$this->loadModel('Resources.ViewResource');
						$this->ViewResource->recursive = -1;
						$picture = $this->ViewResource->find('first', array(
							'conditions' => array(
								'parent_entityid' => $authuser['id'],
								'group_type_alias' => 'picture',
								'entity_alias' => 'user',
								'deleted' => Configure::read('zero_datetime')
							),
							'fields' => array('filename', 'name', 'entity_folder'),
							'order' => 'created DESC'
							));

						if (!empty($picture)) {
							$this->Session->write('picture', $picture['ViewResource']);
						}
					}

					$this->redirect($this->Auth->redirectUrl());
				} else {
					$this->UserLog->create(array(
						'username' => $this->request->data['User']['username'],
						'ip' => $this->request->clientIp(),
						'user_agent' => $_SERVER['HTTP_USER_AGENT'],
						'is_correct' => 0
						)
					);
					$this->UserLog->save();
					$this->request->data['User']['password'] = '';
					$this->Session->setFlash(__d('accounts', 'Invalid username or password, try again'), 'flash/error');
				}
			} else {
				$this->Session->setFlash(__d('accounts', 'User restricted!'), 'flash/error');
			}
		} else {
			if (CakePlugin::loaded('MenuManager')) {
				$this->Session->delete('set_menu');
				$this->Session->delete('menu_options');
			}
		}
//		pr($this->Auth->password('superadmin'));
	}

	public function logout() {
		$this->Session->destroy();
		$this->Auth->logout();
		$this->redirect(array('action' => 'goodbye', 'admin' => FALSE));
	}

	public function admin_logout() {
		$this->Session->destroy();
		$this->Auth->logout();
		$this->redirect(array('action' => 'goodbye', 'admin' => FALSE));
	}

	public function goodbye() {
		
	}

	public function welcome() {
		
	}

	public function admin_welcome() {
		
	}

	public function register() {

		$this->loadModel('Accounts.Profile');
		$this->loadModel('Configurations.Location');


		if (Configure::read('Accounts.register.data') == 'attributes' || Configure::read('Accounts.register.data') == 'both') {
			$attr = $this->Attribute->getTypes('user');
			$this->set('attrs', $attr);
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			/* ====== LOCATION ========= */
			if (Configure::read('Configuration.location.tree')) {
				$array_locations = array_filter($this->request->data['Profile']['location_id']);
				$locations = $this->Location->sections($this->request->data['Profile']['location_id']);
				$locations_post = $this->request->data['Profile']['location_id'];
				$this->request->data['Profile']['location_id'] = end($array_locations);
			}

			if (empty($this->request->data['Profile']['location_id'])) {
				unset($this->request->data['Profile']['location_id']);
			}
			/* ====== LOCATION ========= */

			if (Configure::check('Accounts.register.captcha') && Configure::read('Accounts.register.captcha') == TRUE) {

				$recaptcha = recaptcha_check_answer(
					Configure::read('Accounts.recaptcha.PrivateKey'), $_SERVER["REMOTE_ADDR"], $this->request->data["recaptcha_challenge_field"], $this->request->data["recaptcha_response_field"]
				);
			}

			$user = array();
			$user['User'] = $this->request->data['User'];
			$user['User']['password'] = $user['User']['password'];
			$user['User']['password_2'] = $user['User']['password_2'];
			// $user['User']['password'] = $this->Auth->password($user['User']['password']);
			// $user['User']['password_2'] = $this->Auth->password($user['User']['password_2']);
			$user['User']['banned'] = (string) Configure::read('zero_datetime');
			$user['User']['deleted'] = (string) Configure::read('zero_datetime');

			if (Configure::check('Accounts.register.default.active') && Configure::read('Accounts.register.default.active') == TRUE) {
				$user['User']['activated'] = date('Y-m-d H:i:s');
			} else {
				$user['User']['activated'] = (string) Configure::read('zero_datetime');
			}

			if (Configure::check('Accounts.register.default.group.id')) {
				$user['User']['group_id'] = Configure::read('Accounts.register.default.group.id');
			} else {
				$user['User']['group_id'] = 3;
			}

			$valid = FALSE;
			if (Configure::check('Accounts.register.data')) {
				switch (Configure::read('Accounts.register.data')) {
					case 'profile':
						$this->Profile->set($this->request->data);
						if ($this->Profile->validates()) {
							$valid = TRUE;
						} else {
							$this->Session->setFlash(__d('accounts', 'User Profile is not valid.'), 'flash/error');
						}
						break;
					case 'attributes':

						if ($this->Attribute->validate($attr, $this->request->data)) {
							$valid = TRUE;
						} else {
							$this->Session->setFlash(__d('accounts', 'User Attributes are not valid.'), 'flash/error');
						}
						break;
					case 'both':
						$this->Profile->set($this->request->data);

						if ($this->Profile->validates() && $this->Attribute->validate($attr, $this->request->data)) {
							$valid = TRUE;
						} else {
							$this->Session->setFlash(__d('accounts', 'User Profile / Attributes are not valid.'), 'flash/error');
						}
						break;
					case 'none':
						$valid = TRUE;
						break;
				}
			} else {
				$valid = TRUE;
			}

			if ($this->User->validates(array('fieldList' => array('username', 'email', 'password')))) {
				if ($valid) {
					if (Configure::read('Accounts.register.captcha') == FALSE || (Configure::read('Accounts.register.captcha') == TRUE && $recaptcha->is_valid)) {
						if (isset($this->request->data['User']['accept_terms']) && $this->request->data['User']['accept_terms'] == 1) {
							$this->Session->setFlash(__d('accounts', 'All valid.'), 'flash/success');

							if ($this->User->save($user)) {

								if (Configure::read('Accounts.register.aros') && CakePlugin::loaded('Acl')) {
									$this->loadModel('Acl.ManagedAro');
									$parent = $this->ManagedAro->find('first', array(
										'conditions' => array('ManagedAro.model' => 'Group', 'ManagedAro.foreign_key' => $this->request->data['User']['group_id'])
										));
									if (!empty($parent)) {
										$this->ManagedAro->create(array(
											'parent_id' => $parent['ManagedAro']['id'],
											'model' => 'User',
											'foreign_key' => $this->User->id,
											'alias' => $this->request->data['User']['username'],
										));

										$this->ManagedAro->save();
									} else {
										$this->Session->setFlash(__d('accounts', 'Please ask the administrator to fix ACL, user groups'), 'flash/error');
										return true;
									}
								}
								if (Configure::read('Accounts.register.data') == 'attributes' || Configure::read('Accounts.register.data') == 'both') {
									$this->Attribute->saveAll($this->request->data['AttributeType'], $this->User->id);
								}
								if (Configure::read('Accounts.register.data') == 'profile' || Configure::read('Accounts.register.data') == 'both') {
									$this->request->data['Profile']['user_id'] = $this->User->id;

									$this->User->Profile->save($this->request->data);
//									pr($this->User->Profile->validationErrors);
								}
								if (Configure::check('Accounts.register.default.active') && Configure::read('Accounts.register.default.active') == TRUE) {
									$this->Session->setFlash(__d('accounts', 'User created successfully, please login.'), 'flash/success');
									$this->redirect(array('action' => 'login'));
								} else {
									$vcode = md5($this->User->id . '' . $this->User->created . '' . $this->User->email);
									$email = new CakeEmail('smtp'); // Definirlo con variable de configuracion
									$email->viewVars(array('code' => $vcode, 'id' => $this->User->id));
									$email->template('register', 'default')->subject(__('Account activation'))->emailFormat('html')->to($this->request->data['User']['email'])->send();
									$this->Session->setFlash(__d('accounts', 'User created successfully, please check your inbox for an activation email.'), 'flash/success');
									$this->redirect('/');
								}
							} else {
								$this->Session->setFlash(__d('accounts', 'User not save.'), 'flash/error');
							}
						} else {
							$this->Session->setFlash(__d('accounts', 'Must accept terms.'), 'flash/error');
						}
					} else {
						$this->Session->setFlash(__d('accounts', 'Captcha is not valid.'), 'flash/error');
					}
				}
			} else {
				$this->Session->setFlash(__d('accounts', 'User Data is not valid.'), 'flash/error');
			}
			if (Configure::read('Configuration.location.tree')) {
				$this->request->data['Profile']['location_id'] = $locations_post;
			}
		} else {
			if (Configure::read('Configuration.location.tree')) {
				$locations = $this->Location->sections(array(0 => null));
			} else {
				$locations = $this->Location->find('list');
			}
		}
		$doctypes = $this->Profile->DocidType->find('list', array('fields' => array('id', 'name')));
		$this->set(compact('locations', 'doctypes'));

		if (!empty($this->request->data)) {
			
		}
	}

	public function activate() {
		if (!empty($this->request->query) && isset($this->request->query['id']) && isset($this->request->query['code'])) {
			if (!$this->User->exists($this->request->query['id'])) {
				throw new MethodNotAllowedException();
			} else {
				$this->User->recursive = -1;
				$user = $this->User->read(null, $this->request->query['id']);
				if ($this->request->query['code'] === md5($this->User->id . $this->User->created . $this->User->email)) {
					if ($user['User']['activated'] == Configure::read('zero_datetime')) {
						if ($this->User->updateAll(array('User.activated' => "'" . date('Y-m-d H:i:s') . "'"), array('User.id' => $this->request->query['id']))) {
							$this->set('status', 1);
						} else {
							$this->set('status', 2);
						}
					} else {
						$this->set('status', 3);
					}
				} else {
					$this->set('status', 4);
				}
			}
		} else {
			throw new MethodNotAllowedException();
		}
	}

	public function remember() {
		$this->set('title_for_layout', __('Remember Password', true));

		$this->loadModel('User');
		$this->User->recursive = -1;
		if ($this->request->is('post')) {

			$user = $this->User->find('first', array(
				'conditions' => array(
					'username' => $this->request->data['User']['username'],
					'email' => $this->request->data['User']['email'],
				)
				));

			if (!empty($user)) {

				if (Configure::read('Accounts.user.password.encrypted')) {
					$password = '';
					$chars = "1234567890abcdABCDEFGHIJKLNMOPQRSTUVWXYZefghijklmnopqrstuvwxyz";
					for ($i = 0; $i < 10; $i++) {
						$password .= $chars{rand(0, 35)};
					}
					$crypted_password = $this->Auth->password($password);
				} else {
					$this->loadModel('Accounts.UserPassword');
					$password_old = $this->UserPassword->find('first', array(
//						'fields' => array('UserPassword.*'),
						'order' => array('UserPassword.created' => 'desc'),
						'conditions' => array('user_id' => $user['User']['id'])
						));
					if (empty($password_old)) {
						throw new MethodNotAllowedException('Error UserPassword');
					}
					$crypted_password = $this->Auth->password($password_old['UserPassword']['password']);
					$password = $password_old['UserPassword']['password'];
				}

				if ($this->User->updateAll(array('User.password' => "'" . $crypted_password . "'"), array('User.id' => $user['User']['id']))) {

					$email = new CakeEmail('smtp'); // Definirlo con variable de configuracion
					$email->viewVars(array('id' => $user['User']['id'], 'username' => $user['User']['username'], 'password' => $password));
					$email->template('remember', 'default')->subject(__('Restore password'))->emailFormat('html')->to($user['User']['email'])->send();

					$this->Session->setFlash(__d('accounts', 'A new password has been sent to your email.'), 'flash/success');
					$this->redirect('/');
				} else {
					$this->Session->setFlash(__d('accounts', 'Error restore password.'), 'flash/error');
				}
			} else {
				$this->Session->setFlash(__d('accounts', 'The username or email not exists'), 'flash/error');
			}
		}
	}

	public function myprofile() {
		$user = array();
		$profile = array();
		$attributes = array();

		if (!empty($this->authuser)) {
			if (!$this->User->exists($this->authuser['id'])) {
				throw new MethodNotAllowedException();
			}

			$this->User->unbindModel(array('hasOne' => array('Profile'), 'hasMany' => array('AlternateLogin', 'UserPassword')));
			$user = $this->User->read(null, $this->authuser['id']);

			if (Configure::read('Accounts.register.data') == 'profiles' || Configure::read('Accounts.register.data') == 'both') {
				$this->loadModel('Accounts.Profile');
				$this->Profile->unbindModel(array('belongsTo' => array('User')));
				$profile = $this->Profile->find('first', array('conditions' => array('user_id' => $this->authuser['id'])));
			}

			if (Configure::read('Accounts.register.data') == 'attributes' || Configure::read('Accounts.register.data') == 'both') {
				$this->loadModel('Attributes.ViewAttribute');

				$attributes = $this->ViewAttribute->find('all', array('conditions' => array('parent_entityid' => $this->authuser['id'], 'entity_alias' => 'user')));
			}

			if (CakePlugin::loaded('Resources')) {
				$this->helpers[] = 'Resources.Frame';
			}
		}
		$this->set(compact('user', 'profile', 'attributes'));
		$this->set('user_id', $this->authuser['id']);
	}

	public function mydataedit() {

		if (!empty($this->authuser)) {
			$this->loadModel('CocteleriaUser');

			if ($this->request->is('post') || $this->request->is('put')) {
				if (!$this->User->exists($this->authuser['id'])) {
					throw new MethodNotAllowedException();
				}
				unset($this->request->data['User']['username']);
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__d('accounts', 'The user has been saved'), 'flash/success');
					$this->redirect(array('action' => 'myprofile'));
				} else {
					$this->Session->setFlash(__d('accounts', 'The user could not be saved. Please, try again.'), 'flash/error');
				}
				unset($this->request->data['User']['password']);
				unset($this->request->data['User']['password_2']);
			} else {
				$this->User->unbindModel(array('hasOne' => array('Profile'), 'hasMany' => array('AlternateLogin', 'UserPassword')));
				$user = $this->User->read(null, $this->authuser['id']);
				unset($user['User']['password']);
				$this->request->data = $user;
//				$this->request->data = array_merge(
//					$user, $this->Attribute->getSaved($this->authuser['id'], 'user')
//				);
			}
		} else {
			$this->Session->setFlash(__d('accounts', 'No user session.'), 'flash/warning');
			$this->redirect('/');
		}
	}

	public function myprofileedit() {
		if (!empty($this->authuser)) {
			$this->loadModel('Accounts.Profile');
			$this->loadModel('Configurations.Location');

			$profile = $this->Profile->find('first', array('conditions' => array('user_id' => $this->authuser['id'])));


			if (empty($profile)) {
				throw new MethodNotAllowedException();
			}

			if ($this->request->is('post') || $this->request->is('put')) {

				/* ====== LOCATION ========= */
				if (Configure::read('Configuration.location.tree')) {
					$locations = $this->Location->sections($this->request->data['Profile']['location_id']);
					$locations_post = $this->request->data['Profile']['location_id'];
					$this->request->data['Profile']['location_id'] = end($this->request->data['Profile']['location_id']);
				}
				/* ====== LOCATION ========= */

				if ($this->Profile->save($this->request->data)) {

					$this->Session->setFlash(__d('accounts', 'The profile has been saved.'), 'flash/success');
					$this->redirect(array('action' => 'myprofile'));
				} else {
					$this->Session->setFlash(__d('accounts', 'The profile could not be saved. Please, try again.'), 'flash/error');
				}
				if (Configure::read('Configuration.location.tree')) {
					$this->request->data['Profile']['location_id'] = $locations_post;
				}
			} else {
				$this->request->data = $profile;
			}
			if (Configure::read('Configuration.location.tree')) {
				if (!empty($this->request->data['Profile']['location_id'])) {
					$this->request->data['Profile']['location_id'] = array_reverse($this->Location->load_parent($this->request->data['Profile']['location_id']));
					$locations = $this->Location->sections($this->request->data['Profile']['location_id']);
				} else {
					$locations = $this->Location->sections(array(0 => null));
				}
			} else {
				$locations = $this->Location->find('list');
			}
			$doctypes = $this->Profile->DocidType->find('list', array('fields' => array('id', 'name')));
			$this->set(compact('locations', 'doctypes'));
		} else {
			$this->Session->setFlash(__d('accounts', 'No user session.'), 'flash/warning');
			$this->redirect('/');
		}
	}

	public function myattributesedit() {
		
	}

	public function editall() {
		if (!empty($this->authuser)) {
			$this->loadModel('Accounts.Profile');
			$this->loadModel('Configurations.Location');

			$profile = $this->Profile->find('first', array('conditions' => array('user_id' => $this->authuser['id'])));
			if (empty($profile)) {
				throw new MethodNotAllowedException();
			}
			$attr = $this->Attribute->getTypes('user', 'create');
			$this->set('attrs', $attr);
			if ($this->request->is('post') || $this->request->is('put')) {

				$this->User->set($this->request->data);
				$this->Profile->set($this->request->data);

				if ($this->Attribute->validate($attr, $this->request->data)) {
					/* ====== LOCATION ========= */
					if (Configure::read('Configuration.location.tree')) {
						$locations = $this->Location->sections($this->request->data['Profile']['location_id']);
						$locations_post = $this->request->data['Profile']['location_id'];
						$this->request->data['Profile']['location_id'] = end($this->request->data['Profile']['location_id']);
					}
					/* ====== LOCATION ========= */

					if ($this->Profile->save($this->request->data)) {
						/* ===CODE APP CONCTELERIA== */
						$this->loadModel('CocteleriaProfile');
						$profile_cocteleria['CocteleriaProfile']['id'] = $profile['Profile']['id'];
						$profile_cocteleria['CocteleriaProfile']['name'] = $this->request->data['Profile']['first_name'];
						$profile_cocteleria['CocteleriaProfile']['lastname'] = $this->request->data['Profile']['last_name'];
						$profile_cocteleria['CocteleriaProfile']['country_id'] = $this->request->data['Profile']['location_id'];
						$this->CocteleriaProfile->save($profile_cocteleria);
						/* ===CODE APP CONCTELERIA== */
						unset($this->request->data['User']['username']);
						unset($this->request->data['User']['email']);
						if ($this->User->save($this->request->data)) {
							/* ===CODE APP CONCTELERIA== */
							$this->loadModel('CocteleriaUser');
							$user['CocteleriaUser']['id'] = $this->authuser['id'];
							if (!empty($this->request->data['User']['password_2'])) {
								$user['CocteleriaUser']['password'] = $this->Auth->password($this->request->data['User']['password_2']);
							}
							$this->CocteleriaUser->save($user);
							/* ===CODE APP CONCTELERIA== */
							if ($this->Attribute->validate($attr, $this->request->data)) {
								$this->Attribute->edit($this->request->data['AttributeType'], $this->authuser['id'], 'user');
							} else {
								$this->Session->setFlash(__d('accounts', 'The user has been saved'), 'flash/success');
							}
							$this->Session->setFlash(__d('accounts', 'The user has been saved'), 'flash/success');
						} else {
							$this->Session->setFlash(__d('accounts', 'The user could not be saved. Please, try again.'), 'flash/error');
						}
						unset($this->request->data['User']['password']);
						unset($this->request->data['User']['password_2']);
						$this->Session->setFlash(__d('accounts', 'The profile has been saved.'), 'flash/success');
						//$this->redirect(array('action' => 'myprofile'));
					} else {
						$this->Session->setFlash(__d('accounts', 'The profile could not be saved. Please, try again.'), 'flash/error');
					}
					if (Configure::read('Configuration.location.tree')) {
						$this->request->data['Profile']['location_id'] = $locations_post;
					}
				} else {
					$this->Session->setFlash(__d('accounts', 'The form is no complet'), 'flash/warning');
				}
			} else {

				$this->request->data = $profile;
				unset($this->request->data ['User']['password']);
				$this->request->data = array_merge($this->request->data, $this->Attribute->getSaved($this->authuser['id'], 'user', 'create'));
			}
			if (Configure::read('Configuration.location.tree')) {
				if (!empty($this->request->data['Profile']['location_id'])) {
					$this->request->data['Profile']['location_id'] = array_reverse($this->Location->load_parent($this->request->data['Profile']['location_id']));
					$locations = $this->Location->sections($this->request->data['Profile']['location_id']);
				} else {
					$locations = $this->Location->sections(array(0 => null));
				}
			} else {
				$locations = $this->Location->find('list');
			}
			$doctypes = $this->Profile->DocidType->find('list', array('fields' => array('id', 'name')));
			$this->set(compact('locations', 'doctypes'));
			if (CakePlugin::loaded('Resources')) {
				$this->helpers[] = 'Resources.Frame';
			}
		} else {
			$this->Session->setFlash(__d('accounts', 'No user session.'), 'flash/warning');
			$this->redirect('/');
		}
	}

	public function changepicture($session = NULL, $group_type = 'picture') {
		$this->layout = false;
		$this->loadModel('ViewResource');
		$picture = $this->ViewResource->find('first', array(
			'order' => array('created' => 'desc'),
			'conditions' => array(
				'entity_alias' => 'user',
				'group_type_alias' => $group_type,
				'parent_entityid' => $this->authuser['id'],
				'deleted' => Configure::read('zero_datetime'),
			),
			'fields' => array('filename', 'entity_folder', 'name')
			)
		);
		if ($session == 'picture') {
			if (!empty($picture)) {
				$this->Session->write($session, $picture['ViewResource']);
			} else {
				$this->Session->delete($session);
			}
		} else {
			$this->set(compact('picture'));
		}
		$this->set(compact('session'));
	}

	public function admin_search($page = NULL) {
		$conditions = array();
		if (isset($this->request->data['User']['search']) and $this->request->data['User']['search'] != " ") {
			if (strlen($this->request->data['User']['search']) > 2) {
				$this->Session->delete('conditions_search');
				$fields = trim($this->request->data['User']['search'], " ");
				$search = explode(" ", $fields);
				for ($i = 0; $i < count($search); $i++) {
					if (strlen($search[$i]) > 2) {
						$conditions[] = "User.username like '%" . $search[$i] . "%'";
						$conditions[] = "User.email like '%" . $search[$i] . "%'";
					}
				}
				$results = $this->paginate('User', array(
					'OR' => $conditions,
					));
				$this->Session->write('conditions_search', $conditions);
				if (count($results) == 0) {
					$this->Session->setFlash('No se encontraron Registros!.', 'flash/warning');
				}
				$this->set('users', $results);
			} else {
				$this->Session->setFlash('No se encontraron Registros!.', 'flash/warning');
				$this->redirect(array('action' => 'index'));
			}
		} else {
			$settings = array();
			if ($this->Session->check('conditions_search')) {
				if (!empty($this->request->params['named']['page'])) {
					$settings['page'] = $this->request->params['named']['page'];
				} else {
					$settings['page'] = 1;
				}
				$settings['conditions']['OR'] = $this->Session->read('conditions_search');
				$this->paginate = $settings;
				$this->set('users', $this->paginate());
			} else {
				$this->Session->setFlash('No se encontraron Registros!.', 'flash/warning');
				$this->redirect(array('action' => 'index'));
			}
		}
	}

	public function loginAuto($user_id, $group_id, $username_login, $password_login, $created, $activated, $modified, $banned, $deleted) {

		if (CakePlugin::loaded('MenuManager')) {
			if ($this->Session->check('set_menu')) {
				$this->Session->delete('set_menu');
				$this->Session->delete('menu_options');
			}
		}

		$data = array(
			'id' => $user_id,
			'group_id' => $group_id,
			'username' => $username_login,
			'password' => $password_login,
			'created' => $created,
			'activated' => $activated,
			'modified' => $modified,
			'banned' => $banned,
			'deleted' => $deleted
		);


		if ($this->Session->check('Auth.User')) {
			$this->redirect($this->Auth->redirectUrl());
		}

		if ($this->Auth->login($data)) {
			$this->redirect($this->Auth->redirectUrl());
		} else {
			$this->UserLog->create(array(
				'username' => $this->request->data['User']['username'],
				'ip' => $this->request->clientIp(),
				)
			);
			$this->UserLog->save();
		}
	}

	public function complete_information() {
		$this->loadModel('Accounts.Profile');
		$this->loadModel('Accounts.User');
		$this->loadModel('UserPassword');
		$this->loadModel('AlternateLogin');
		$this->loadModel('Configurations.Location');

		if ($this->request->is('post') || $this->request->is('put')) {

			$locations = $this->Location->sections($this->request->data['Profile']['location_id']);
			$locations_post = $this->request->data['Profile']['location_id'];
			$this->request->data['Profile']['location_id'] = end($this->request->data['Profile']['location_id']);

			$info_complete = $this->request->data;
			$this->request->data['User']['activated'] = date('Y-m-d H:i:s');
			$this->request->data['User']['banned'] = Configure::read('zero_datetime');
			$this->request->data['User']['deleted'] = Configure::read('zero_datetime');
			$this->request->data['User']['created'] = date('Y-m-d H:i:s');
			$this->request->data['User']['modified'] = Configure::read('zero_datetime');
			$this->request->data['User']['username'] = $info_complete['User']['username'];
			$this->request->data['User']['password'] = $this->Auth->password($info_complete['User']['password']);
			$this->request->data['User']['password_2'] = $this->Auth->password($info_complete['User']['password_2']);
			$this->request->data['User']['email'] = $info_complete['User']['email'];
			$this->request->data['User']['group_id'] = Configure::read('Accounts.social_groupid_default');

			$recaptcha = recaptcha_check_answer(Configure::read('Accounts.recaptcha.PrivateKey'), $_SERVER["REMOTE_ADDR"], $this->request->data["recaptcha_challenge_field"], $this->request->data["recaptcha_response_field"]);
			$this->User->set($info_complete);
			$this->Profile->set($info_complete);

			$user_location = $this->request->data['Profile']['location_id'];

			$this->User->Profile->validator()->add('accept_terms', array('rule' => 'notempty', 'message' => 'You must accept the terms and conditions'));
			$this->User->Profile->validator()->add('location_id', array('rule' => 'notempty', 'message' => 'Please select a location'));
			$this->User->Profile->Validator()->add('docid', 'regexp', array('rule' => '/^([0-9]){7,}$/', 'message' => 'Please enter a correct identification number'));
			$this->User->Profile->Validator()->add('mobile', 'regexp', array('rule' => '/^([0-9]){10,}$/', 'message' => 'Please enter a correct mobile numbers'));
			if ($this->User->validates() && $this->User->Profile->validates() && $recaptcha->is_valid & isset($this->request->data['User']['accept_terms']) & $this->request->data['User']['accept_terms'] == 1) {

				$this->User->create();
				if ($this->User->save($this->request->data)) {
					if (CakePlugin::loaded('Gamification') && $this->request->data['Resource']['filename']) {
						$this->Resources->saveFromUrl($this->User->id, 'user', $this->request->data['Resource']['filename'], 'image', 'picture');
					}
					switch ($info_complete['Profile']['gender']) {
						case 'male':
							$gender = 'M';
							break;
						case 'female':
							$gender = 'F';
							break;
						default:
							break;
					}

					$profile_data = array(
						'first_name' => $info_complete['Profile']['first_name'],
						'last_name' => $info_complete['Profile']['last_name'],
						'docid' => $info_complete['Profile']['docid'],
						'gender' => $gender,
						'birthday' => $info_complete['Profile']['birthday'],
						'address' => $info_complete['Profile']['address'],
						'mobile' => $info_complete['Profile']['mobile'],
						'phone' => $info_complete['Profile']['phone'],
						'location_id' => $user_location,
						'user_id' => $this->User->id
					);

					$this->AlternateLogin->create();

					$this->request->data['AlternateLogin']['uid'] = $info_complete['AlternateLogin']['uid'];
					$this->request->data['AlternateLogin']['user_id'] = $this->User->id;
					$this->request->data['AlternateLogin']['social_network_id'] = $info_complete['AlternateLogin']['social_network_id'];

					if ($this->Profile->save($profile_data) && $this->AlternateLogin->save($this->request->data)) {

						/**
						 * inicio codigo email
						 */
						$username = $info_complete['User']['username'];
						$password_user = $info_complete['User']['password'];
						$code_validated = md5($this->User->id . $this->User->created . $this->User->email);

						$this->set('code', $code_validated);
						$this->set('user_id', $this->User->id);
						$this->set('username', $username);
						$this->set('password', $password_user);

						$this->Email->from = 'info@maspapaya.net';

						$this->Email->to = $info_complete['User']['email'];
						$this->Email->delivery = 'smtp';
						$this->Email->subject = __('Account Activation');
						$this->Email->template = 'Accounts.social_register';
						$this->Email->sendAs = 'html';
						$this->Email->send();

//						debug($this->Email->smtpError);
						/**
						 * fin codigo email
						 */
						$user_id = $this->User->id;
						$group_id = $this->request->data['User']['group_id'];
						$username_login = $this->request->data['User']['username'];
						$password_login = $info_complete['User']['password'];
						$created = $this->request->data['User']['created'];
						$activated = $this->request->data['User']['activated'];
						$modified = $this->request->data['User']['modified'];
						$banned = $this->request->data['User']['banned'];
						$deleted = $this->request->data['User']['deleted'];

						$this->loginAuto($user_id, $group_id, $username_login, $password_login, $created, $activated, $modified, $banned, $deleted);
					} else {
						$this->request->data['Profile']['location_id'] = $locations_post;
						$this->Session->setFlash(__('User Profile not saved'), 'flash/error');
					}
				} else {
					$this->request->data['Profile']['location_id'] = $locations_post;
					$this->Session->setFlash(__('User not saved'), 'flash/error');
				}
			} else {
				if (!isset($this->request->data['User']['accept_terms'])) {

					$this->User->validationErrors = array_merge($this->User->validationErrors, array('accept_terms' => array(
							0 => __('You must accept the terms and conditions')
						)));
				} else {
					if (isset($this->request->data['User']['accept_terms']) && $this->request->data['User']['accept_terms'] == 0) {

						$this->User->validationErrors = array_merge($this->User->validationErrors, array('accept_terms' => array(
								0 => __('You must accept the terms and conditions')
							)));
					}
				}

				$this->request->data['Profile']['location_id'] = $locations_post;
				$this->request->data['User']['password'] = '';
				$this->request->data['User']['password_2'] = '';
				$this->set('error_captcha', $recaptcha->error);
				$this->Session->setFlash(__('The form is not completely filled.'), 'flash/error');
			}
		} else {
			$locations = $this->Location->sections(array(0 => null));
			if ($this->Session->check('DataRegister') && $this->Session->check('DataRegister.AlternateLogin')) {
				$this->request->data = $this->Session->read('DataRegister');
				$AlternateLogin = $this->Session->read('DataRegister.AlternateLogin');

				$user_exist = $this->AlternateLogin->find('first', array(
					'fields' => array('User.*'),
					'conditions' => array('uid' => $AlternateLogin['uid'], 'SocialNetwork.id' => $AlternateLogin['social_network_id'], 'User.deleted' => Configure::read('zero_datetime'), 'User.banned' => Configure::read('zero_datetime'))
					));

				if (!empty($user_exist)) {
					$this->loginAuto($user_exist['User']['id'], $user_exist['User']['group_id'], $user_exist['User']['username'], $user_exist['User']['password'], $user_exist['User']['created'], $user_exist['User']['activated'], $user_exist['User']['modified'], $user_exist['User']['banned'], $user_exist['User']['deleted']);
				}
			} else {
				$this->Session->setFlash(__('No data are obtained session, refresh the page'), 'flash/warning');
			}
		}
		$this->set(compact('locations'));
	}

	public function login_twitter() {
		define('CONSUMER_KEY', Configure::read('Accounts.twitter.CONSUMER_KEY'));
		define('CONSUMER_SECRET', Configure::read('Accounts.twitter.CONSUMER_SECRET'));
		define('OAUTH_CALLBACK', Configure::read('Accounts.twitter.OAUTH_CALLBACK'));

		if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
			$_SESSION['oauth_status'] = 'oldtoken';
		}

		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

		$_SESSION['access_token'] = $access_token;

		if (200 == $connection->http_code) {

			if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
				
			}
			$access_token = $_SESSION['access_token'];
			$this->Session->write('token_twitter', $access_token);

			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
			$content = $connection->get('account/verify_credentials');

			if (!empty($content->profile_image_url)) {
				$filename = implode('_', array_slice(explode('_', $content->profile_image_url), 0, 2)) . '.' . implode('.', array_slice(explode('.', $content->profile_image_url), -1));
			} else {
				$filename = '';
			}

			$data_register = array(
				'User' => $user_data = array(
				'banned' => $this->request->data['User']['banned'] = '1800-01-01 00:00:00',
				'deleted' => $this->request->data['User']['deleted'] = '1800-01-01 00:00:00',
				'created' => $this->request->data['User']['created'] = date('Y-m-d H:i:s'),
				'modified' => $this->request->data['User']['modified'] = date('Y-m-d H:i:s'),
				'username' => $this->request->data['User']['username'] = $content->screen_name,
				'password' => '',
				'email' => $this->request->data['User']['email'] = '',
				'group_id' => $this->request->data['User']['group_id'] = 3
				),
				'Profile' => array(
					'first_name' => $content->name,
					'last_name' => '',
					'birthday' => '',
					'gender' => '',
					'address' => '',
					'docid' => '',
					'mobile' => '',
					'phone' => '',
					'user_id' => $this->User->id,
//				'location_id' => 
				),
				'AlternateLogin' => array(
					'uid' => $this->request->data['AlternateLogin']['uid'] = $content->id,
					'user_id' => $this->request->data['AlternateLogin']['user_id'] = $this->User->id,
					'social_network_id' => $this->request->data['AlternateLogin']['social_network_id'] = 3
				),
				'Resource' => array(
					'filename' => $filename
				)
			);


			$alternate_login = array(
				'uid' => $this->request->data['AlternateLogin']['uid'] = $content->id,
				'user_id' => $this->request->data['AlternateLogin']['user_id'] = $this->User->id,
				'social_network_id' => $this->request->data['AlternateLogin']['social_network_id'] = 1
			);


			if ($data_register['Profile']['address'] == '' && $data_register['Profile']['docid'] == '' && $data_register['Profile']['mobile'] == '' && $data_register['Profile']['phone'] == '') {

				$this->request->data = $data_register;

				$this->Session->write('DataRegister', $data_register);
				$this->Session->write('AlternateLogin', $alternate_login);

				$this->redirect(array('plugin' => 'accounts', 'controller' => 'users', 'action' => 'complete_information'));
			}
		} else {
			$this->redirect(array('plugin' => 'accounts', 'controller' => 'users', 'action' => 'welcome'));
			$this->Session->setFlash(__('An error has occurred check their credentials'), 'flash/warning');
		}
	}

	public function login_fb() {

		$this->loadModel('Profile');
		$this->loadModel('User');
		$this->loadModel('AlternateLogin');
		$this->loadModel('UserPassword');

		if (isset($this->request->data['User']['at'])) {

			$this->facebook->setAccessToken($this->request->data['User']['at']);
			$this->fbuid = $this->facebook->getUser();
			$this->accessToken = $this->Session->write('accessToken', $this->request->data['User']['at']);

			$fbuser = $this->facebook->api('/me');

			$this->Session->write('token_socialNetwork', $this->request->data['User']['at']);

			if (isset($fbuser['birthday'])) {
				$birthday = date('Y-m-d', CakeTime::fromString($fbuser['birthday']));
			} else {
				$birthday = '0001-01-01';
			}
			$filename = 'http://graph.facebook.com/' . $fbuser['id'] . '/picture?width=240&height=240';
			$data_register = array(
				'User' => $user_data = array(
				'banned' => $this->request->data['User']['banned'] = Configure::read('zero_datetime'),
				'deleted' => $this->request->data['User']['deleted'] = Configure::read('zero_datetime'),
				'created' => $this->request->data['User']['created'] = date('Y-m-d H:i:s'),
				'modified' => $this->request->data['User']['modified'] = date('Y-m-d H:i:s'),
				'username' => $this->request->data['User']['username'] = $fbuser['email'],
				'password' => '',
				'email' => $this->request->data['User']['email'] = $fbuser['email'],
				'group_id' => $this->request->data['User']['group_id'] = 3
				),
				'Profile' => array(
					'first_name' => $fbuser['first_name'],
					'last_name' => $fbuser['last_name'],
					'birthday' => $birthday,
					'gender' => $fbuser['gender'],
//				'address' => isset($fbuser['hometown']['name']) ? $fbuser['hometown']['name'] : 'No definido',
					'address' => '',
					'docid' => '',
					'mobile' => '',
					'phone' => '',
					'user_id' => $this->User->id,
//				'location_id' => 
				),
				'AlternateLogin' => array(
					'uid' => $this->request->data['AlternateLogin']['uid'] = $fbuser['id'],
					'user_id' => $this->request->data['AlternateLogin']['user_id'] = $this->User->id,
					'social_network_id' => $this->request->data['AlternateLogin']['social_network_id'] = 1
				),
				'Resource' => array(
					'filename' => $filename
				)
			);


			$alternate_login = array(
				'uid' => $this->request->data['AlternateLogin']['uid'] = $fbuser['id'],
				'user_id' => $this->request->data['AlternateLogin']['user_id'] = $this->User->id,
				'social_network_id' => $this->request->data['AlternateLogin']['social_network_id'] = 1
			);


			if ($data_register['Profile']['address'] == '' && $data_register['Profile']['docid'] == '' && $data_register['Profile']['mobile'] == '' && $data_register['Profile']['phone'] == '') {

				$this->request->data = $data_register;

				$this->Session->write('DataRegister', $data_register);
				$this->Session->write('AlternateLogin', $alternate_login);

				$this->redirect(array('plugin' => 'accounts', 'controller' => 'users', 'action' => 'complete_information'));
			}
		}
	}

	public function conect_twitter() {

		define('CONSUMER_KEY', Configure::read('Accounts.twitter.CONSUMER_KEY'));
		define('CONSUMER_SECRET', Configure::read('Accounts.twitter.CONSUMER_SECRET'));
		define('OAUTH_CALLBACK', Configure::read('Accounts.twitter.OAUTH_CALLBACK'));

		Configure::read('Accounts.twitter.CONSUMER_KEY');
		Configure::read('Accounts.twitter.CONSUMER_SECRET');
		Configure::read('Accounts.twitter.OAUTH_CALLBACK');


		if (CONSUMER_KEY === '' || CONSUMER_SECRET === '' || CONSUMER_KEY === 'CONSUMER_KEY_HERE' || CONSUMER_SECRET === 'CONSUMER_SECRET_HERE') {

			$this->Session->setFlash(__('You need a consumer key and secret to test the sample code. Get one from <a href="https://dev.twitter.com/apps">dev.twitter.com/apps</a>'), 'flash/error');
		}

		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

		$request_token = $connection->getRequestToken(OAUTH_CALLBACK);

		$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

		//pr($connection->http_code);
		switch ($connection->http_code) {
			case 200:
				/* Build authorize URL and redirect user to Twitter. */
				$url = $connection->getAuthorizeURL($token);
				$this->redirect($url);
				//header('Location: ' . $url);
				break;
			default:
				/* Show notification if something went wrong. */
				echo 'Could not connect to Twitter. Refresh the page or try again later.';
		}
	}

	public function __send_email($user = null, $password = null, $to = null) {
		$email = new CakeEmail('smtp'); // Definirlo con variable de configuracion
		$email->viewVars(array('user' => $user, 'password' => $password));
		$email->template('access', 'default')->subject(__('Data login'))->emailFormat('html')->to($to)->send();
	}

}
