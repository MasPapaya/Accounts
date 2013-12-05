<?php
App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property Group $Group
 * @property AlternateLogin $AlternateLogin
 * @property Profile $Profile
 * @property UserPassword $UserPassword
 */
class User extends AccountsAppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'username';
	public $sequence = "use_sq";

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'group_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'username already exists',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'username_validate' => array(
				'rule' => 'username_validate',
				'message' => 'username incorrect',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'compare_password' => array(
				'rule' => array('compare_password'),
				'message' => 'Passwords not equal',
				'allowEmpty' => TRUE,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			// 'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'not_used_pass' => array(
				'rule' => array('not_used_pass'),
				'message' => 'Password used in past',
				'on' => 'update'
			),
		),
		// 'password_2' => array(
		// 	// 'notempty' => array(
		// 	// 	'rule' => array('notempty'),
		// 	// 	//'message' => 'Your custom message here',
		// 	// 	//'allowEmpty' => false,
		// 	// 	'required' => true,
		// 	// 	//'last' => false, // Stop validation after this rule
		// 	// 	'on' => 'create', // Limit validation to 'create' or 'update' operations
		// 	// ),
		// 	'compare_password' => array(
		// 		'rule' => array('compare_password'),
		// 		'message' => 'Passwords not equal',
		// 		'allowEmpty' => TRUE,
		// 	//'required' => false,
		// 	//'last' => false, // Stop validation after this rule
		// 		// 'on' => 'create', // Limit validation to 'create' or 'update' operations
		// 	),
		// ),
		'email' => array(
			'unique' => array(
				'rule' => 'IsUnique',
				'message' => 'email already exists',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			// 'email'=>'email'
			'email' => array(
				'rule' => array('email', TRUE, '/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/'),
				'message' => 'Email is required',
			//'allowEmpty' => false,
			//'required' => true,
			//'last' => false, // Stop validation after this rule
			// 'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		// 'activated' => array(
		// 	// 'rule' => array('datetime', 'ymd'),
		// 	'datetime' => array(
		// 		'rule' => array('datetime', 'ymd'),
		// 		'message' => 'Activated datetime is required',
		// 		// 'allowEmpty' => false,
		// 		// 'required' => false,
		// 		// 'last' => false, // Stop validation after this rule
		// 		// 'on' => 'create', // Limit validation to 'create' or 'update' operations
		// 	),
		// ),
		// 'banned' => array(
		// 	'datetime' => array(
		// 		'rule' => array('datetime', 'ymd'),
		// 		'message' => 'Banned datetime is required',
		// 		//'allowEmpty' => false,
		// 		//'required' => false,
		// 		//'last' => false, // Stop validation after this rule
		// 		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		// 	),
		// ),
		// 'deleted' => array(
		// 	'datetime' => array(
		// 		'rule' => array('datetime', 'Y-m-d H:i:s'),
		// 		'message' => 'Deleted datetime is required',
		// 		//'allowEmpty' => false,
		// 		//'required' => false,
		// 		//'last' => false, // Stop validation after this rule
		// 		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		// 	),
		// ),
		'accept_terms' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must accept the terms and conditions',
				//			'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'AlternateLogin' => array(
			'className' => 'AlternateLogin',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'UserPassword' => array(
			'className' => 'UserPassword',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	public $hasOne = array(
		'Profile' => array(
			'className' => 'Profile',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

	public function beforeSave($options = array()) {

		if (isset($this->data['User']['password']) && $this->data['User']['password'] == '') {
			unset($this->data['User']['password']);
			unset($this->data['User']['password_2']);
		} else {
			
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}
		return TRUE;
	}

	public function afterSave($created, $options = array()) {
		if (isset($this->data['User']['password']) && $this->data['User']['password'] != '') {
			App::import('Model', 'Accounts.UserPassword');
			$userpass = new UserPassword();
			$obj = array(
				'user_id' => $this->data['User']['id'],
				'password' => $this->data['User']['password'],
				'created' => date('Y-m-d H:i:s')
			);
			$userpass->save($obj);
		}
		return TRUE;
	}

	public function not_used_pass() {
		if (isset($this->data['User']['id'])) {
			App::import('Model', 'Accounts.UserPassword');
			$userpass = new UserPassword();
			if ($userpass->find('count', array(
					'conditions' => array(
						'user_id' => $this->data['User']['id'],
						'UserPassword.password' => AuthComponent::password($this->data['User']['password'])
					)
				)) > 0) {
				return FALSE;
			}
		}
		return TRUE;
	}

	public function accept_terms() {
		if (isset($this->data['User']['accept_terms'])) {
			if ($this->data['User']['accept_terms'] == 1) {
				return TRUE;
			}
		}
		return FALSE;
	}

	public function compare_password() {
		if (isset($this->data['User']['password']) && isset($this->data['User']['password_2'])) {
			if ($this->data['User']['password'] === $this->data['User']['password_2']) {
				return TRUE;
			}
		}
		return FALSE;
	}

	public function username_validate() {
		if (isset($this->data['User']['username'])) {
			$correct_user = $this->Group->find('count', array(
				'conditions' => array('Group.name' => trim($this->data['User']['username'], ' ')),
				));
			if ($correct_user > 0) {
				return false;
			} else {
				return true;
			}
		}

		return false;
	}

}
