<?php

App::uses('AppController', 'Controller');

class AccountsAppController extends AppController {

	public $helpers = array(
		'Html',
		'Form',
		'Session',
		'Js' => array('Jquery'),
		'Paginator',
		'Accounts.Ajs',
		'Text',
	);
	public $components = array('Email',
		'Paginator',
		'RequestHandler',
		'Session',
		'Auth',
//		'Security',
//		'Cookie',
	);

	public function beforeFilter() {
		parent::beforeFilter();
		if (Configure::read('debug') > 1) {
			$this->Auth->allow();
		}


//		echo $this->networks();
// 		$this->Auth->authorize = 'Controller';
// 		if ($this->Session->check('Auth.User')) {
// //			$user = $this->Session->read('Auth.User');
// 			switch ($this->Auth->user('group_id')) {
// 				case 3:
// 				case 4:
// 					break;
// 			}
// 		}
		/* $this->Auth->authenticate = array(
		  'Form' => array(
		  'scope' => array(
		  //						'User.is_active' => true,
		  'User.activated >' => '1800-01-01 00:00:00',
		  'User.banned' => '1800-01-01 00:00:00',
		  'User.deleted' => '1800-01-01 00:00:00',
		  'User.group_id' => array(1, 2, 3, 4, 5, 6),
		  )
		  ),
		  ); */
		/* 		$this->Auth->loginAction = Router::url(array('plugin' => 'accounts', 'controller' => 'users', 'action' => 'login'), true);
		  $this->Auth->loginRedirect = Router::url(array('plugin' => 'accounts', 'controller' => 'users', 'action' => 'welcome'), true);
		  $this->Auth->logoutRedirect = Router::url(array('plugin' => 'accounts', 'controller' => 'pages', 'action' => 'home'), true);
		 */

		/** Configuracion del email* */
		// $this->Email->smtpOptions = array(
		// 	'port' => '465',
		// 	'timeout' => '30',
		// 	'host' => 'ssl://maspapaya.net',
		// 	'username' => 'william.alarcon@maspapaya.net',
		// 	'password' => 'w1094917102#A',
		// );	
	}

// 	public function isAuthorized() {
// //		return true;
// 	}
}
