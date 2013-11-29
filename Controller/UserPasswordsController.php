<?php

App::uses('AppController', 'Controller');

/**
 * UserPasswords Controller
 *
 * @property UserPassword $UserPassword
 */
class UserPasswordsController extends AccountsAppController {

	public function beforeFilter() {
		parent::beforeFilter();
	}

// 	public function isAuthorized() {

// //		parent::isAuthorized();
// 		switch ($this->Auth->user('group_id')) {
// 			case 1:
// 			case 2:
// 				return true;
// 				break;
// 			case 3:
// 				return false;
// 				break;
// 			case 4:
// 				return false;
// 				break;
// 			default :
// 				return false;
// 				break;
// 		}
// 	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->UserPassword->recursive = 0;
		$this->set('userPasswords', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->UserPassword->exists($id)) {
			throw new NotFoundException(__('Invalid user password'), 'flash/warning');
		}
		$options = array('conditions' => array('UserPassword.' . $this->UserPassword->primaryKey => $id));
		$this->set('userPassword', $this->UserPassword->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->UserPassword->create();
			if ($this->UserPassword->save($this->request->data)) {
				$this->Session->setFlash(__('The user password has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user password could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$users = $this->UserPassword->User->find('list');
		$this->set(compact('users'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (!$this->UserPassword->exists($id)) {
			throw new NotFoundException(__('Invalid user password'), 'flash/warning');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->UserPassword->save($this->request->data)) {
				$this->Session->setFlash(__('The user password has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user password could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('UserPassword.' . $this->UserPassword->primaryKey => $id));
			$this->request->data = $this->UserPassword->find('first', $options);
		}
		$users = $this->UserPassword->User->find('list');
		$this->set(compact('users'));
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->UserPassword->id = $id;
		if (!$this->UserPassword->exists()) {
			throw new NotFoundException(__('Invalid user password'), 'flash/warning');
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->UserPassword->delete()) {
			$this->Session->setFlash(__('User password deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User password was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

}
