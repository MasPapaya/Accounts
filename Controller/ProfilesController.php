<?php

App::uses('AppController', 'Controller');

/**
 * Profiles Controller
 *
 * @property Profile $Profile
 */
class ProfilesController extends AccountsAppController {

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
		$this->Profile->recursive = 0;
		$this->set('profiles', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->Profile->exists($id)) {
			throw new NotFoundException(__('Invalid profile'), 'flash/warning');
		}
		$options = array('conditions' => array('Profile.' . $this->Profile->primaryKey => $id));
		$this->set('profile', $this->Profile->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Profile->create();
			if ($this->Profile->save($this->request->data)) {
				$this->Session->setFlash(__('The profile has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The profile could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$users = $this->Profile->User->find('list');
		$locations = $this->Profile->Location->find('list');
		$this->set(compact('users', 'locations'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (!$this->Profile->exists($id)) {
			throw new NotFoundException(__('Invalid profile'), 'flash/warning');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Profile->save($this->request->data)) {
				$this->Session->setFlash(__('The profile has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The profile could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('Profile.' . $this->Profile->primaryKey => $id));
			$this->request->data = $this->Profile->find('first', $options);
		}
		$users = $this->Profile->User->find('list');
		$locations = $this->Profile->Location->find('list');
		$this->set(compact('users', 'locations'));
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->Profile->id = $id;
		if (!$this->Profile->exists()) {
			throw new NotFoundException(__('Invalid profile'), 'flash/warning');
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Profile->delete()) {
			$this->Session->setFlash(__('Profile deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Profile was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

}