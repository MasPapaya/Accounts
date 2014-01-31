<?php

App::uses('AppController', 'Controller');
App::uses('CakeTime', 'Utility');
/* * *Fin** */
//require_once ROOT . DS . 'app' . DS . 'Plugin' . DS . 'Accounts' . DS . 'Vendor' . DS . 'Recaptcha' . DS . 'recaptchalib.php';
App::import('Accounts.Vendor', 'Recaptcha/recaptchalib');

/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AccountsAppController {

	public $helpers = array();
//	public $uses = array('Accounts.User');
	var $components = array();

	public function beforeFilter() {
		parent::beforeFilter();
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

					$this->Session->setFlash(__d('accounts','The user has been saved'), 'flash/success');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__d('accounts','The user could not be saved. Please, try again.'), 'flash/error');
				}
			} else {
				$this->Session->setFlash(__d('accounts','The user could not be saved. Please, try again.'), 'flash/warning');
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

//		pr($this->request->data);
		if ($this->request->is('post') || $this->request->is('put')) {
//			if (empty($this->request->data['User']['password'])) {
//				unset($this->request->data['User']['password']);
//			}

			$this->User->set($this->request->data);
//			$this->User->validator()->remove('birthday', 'adult');
			if ($this->User->validates()) {
				if (!empty($this->request->data['User']['password'])) {
					// $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);
					$attempts = $this->User->UserPassword->find('count', array(
						'conditions' => array(
							'UserPassword.password' => $this->request->data['User']['password'],
							'UserPassword.user_id' => $this->request->data['User']['id'],
						)
						));
					if ($attempts > 0) {
						$this->Session->setFlash(__d('accounts','For safety reasons not to repeat the password'), 'flash/warning');
						$this->redirect(array('action' => 'edit', 'admin' => true, $this->request->data['User']['id']));
					}
				} else {
					unset($this->request->data['User']['password']);
				}
				$this->User->validator()->remove('password', 'regexp');
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__d('accounts','The user has been saved'), 'flash/success');
					$this->redirect(array('action' => 'index', 'admin' => true));
				} else {
					$this->Session->setFlash(__d('accounts','The user could not be saved. Please, try again.'), 'flash/error');
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
		$this->Session->setFlash(__d('accounts','User was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));


		$query = $this->User->updateAll(
			array('User.deleted' => "'" . date('Y-m-d H:i:s') . "'"), array('User.id' => $id)
		);
	}

	public function login() {
		$this->loadModel('UserLog');
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
						$authuser = $this->Auth->user();

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
					$this->Session->setFlash(__d('accounts','Invalid username or password, try again'), 'flash/error');
				}
			} else {
				$this->Session->setFlash(__d('accounts','User restricted!'), 'flash/error');
			}
		} else {
			if (CakePlugin::loaded('MenuManager')) {
				$this->Session->delete('set_menu');
				$this->Session->delete('menu_options');
			}
		}
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
							$this->Session->setFlash(__d('accounts','User Profile is not valid.'), 'flash/error');
						}
						break;
					case 'attributes':

						if ($this->Attribute->validate($attr, $this->request->data)) {
							$valid = TRUE;
						} else {
							$this->Session->setFlash(__d('accounts','User Attributes are not valid.'), 'flash/error');
						}
						break;
					case 'both':
						$this->Profile->set($this->request->data);

						if ($this->Profile->validates() && $this->Attribute->validate($attr, $this->request->data)) {
							$valid = TRUE;
						} else {
							$this->Session->setFlash(__d('accounts','User Profile / Attributes are not valid.'), 'flash/error');
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
							$this->Session->setFlash(__d('accounts','All valid.'), 'flash/success');

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
										$this->Session->setFlash(__d('accounts','Please ask the administrator to fix ACL, user groups'), 'flash/error');
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
									$this->Session->setFlash(__d('accounts','User created successfully, please login.'), 'flash/success');
									$this->redirect(array('action' => 'login'));
								} else {
									$vcode = md5($this->User->id . '' . $this->User->created . '' . $this->User->email);
									$email = new CakeEmail('smtp'); // Definirlo con variable de configuracion
									$email->viewVars(array('code' => $vcode, 'id' => $this->User->id));
									$email->template('register', 'default')->subject(__('Account activation'))->emailFormat('html')->to($this->request->data['User']['email'])->send();
									$this->Session->setFlash(__d('accounts','User created successfully, please check your inbox for an activation email.'), 'flash/success');
									$this->redirect('/');
								}
							} else {
								$this->Session->setFlash(__d('accounts','User not save.'), 'flash/error');
								// debug($this->User->validationErrors);
							}
						} else {
							$this->Session->setFlash(__d('accounts','Must accept terms.'), 'flash/error');
						}
					} else {
						$this->Session->setFlash(__d('accounts','Captcha is not valid.'), 'flash/error');
					}
				}
			} else {

				$this->Session->setFlash(__d('accounts','User Data is not valid.'), 'flash/error');
				// debug($this->User->validationErrors);
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
			// $this->request->data['User']['password'] = '';
			// $this->request->data['User']['password_2'] = '';
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

					$this->Session->setFlash(__d('accounts','A new password has been sent to your email.'), 'flash/success');
					$this->redirect('/');
				} else {
					$this->Session->setFlash(__d('accounts','Error restore password.'), 'flash/error');
				}
			} else {
				$this->Session->setFlash(__d('accounts','The username or email not exists'), 'flash/error');
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
					$this->Session->setFlash(__d('accounts','The user has been saved'), 'flash/success');
					$this->redirect(array('action' => 'myprofile'));
				} else {
					$this->Session->setFlash(__d('accounts','The user could not be saved. Please, try again.'), 'flash/error');
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
			$this->Session->setFlash(__d('accounts','No user session.'), 'flash/warning');
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

					$this->Session->setFlash(__d('accounts','The profile has been saved.'), 'flash/success');
					$this->redirect(array('action' => 'myprofile'));
				} else {
					$this->Session->setFlash(__d('accounts','The profile could not be saved. Please, try again.'), 'flash/error');
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
			$this->Session->setFlash(__d('accounts','No user session.'), 'flash/warning');
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
								$this->Session->setFlash(__d('accounts','The user has been saved'), 'flash/success');
							}
							$this->Session->setFlash(__d('accounts','The user has been saved'), 'flash/success');
						} else {
							$this->Session->setFlash(__d('accounts','The user could not be saved. Please, try again.'), 'flash/error');
						}
						unset($this->request->data['User']['password']);
						unset($this->request->data['User']['password_2']);
						$this->Session->setFlash(__d('accounts','The profile has been saved.'), 'flash/success');
						//$this->redirect(array('action' => 'myprofile'));
					} else {
						$this->Session->setFlash(__d('accounts','The profile could not be saved. Please, try again.'), 'flash/error');
					}
					if (Configure::read('Configuration.location.tree')) {
						$this->request->data['Profile']['location_id'] = $locations_post;
					}
				} else {
					$this->Session->setFlash(__d('accounts','The form is no complet'), 'flash/warning');
				}
			} else {

				$this->request->data = $profile;
				unset($this->request->data ['User']['password']);
				$this->request->data = array_merge($this->request->data, $this->Attribute->getSaved($this->authuser['id'], 'user', 'create')
				);
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
			$this->Session->setFlash(__d('accounts','No user session.'), 'flash/warning');
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

	public function __send_email($user = null, $password = null, $to = null) {
		$email = new CakeEmail('smtp'); // Definirlo con variable de configuracion
		$email->viewVars(array('user' => $user, 'password' => $password));
		$email->template('access', 'default')->subject(__('Data login'))->emailFormat('html')->to($to)->send();
	}

}
