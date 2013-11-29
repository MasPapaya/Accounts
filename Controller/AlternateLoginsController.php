<?php

App::uses('AppController', 'Controller');

/**
 * AlternateLogins Controller
 *
 * @property AlternateLogin $AlternateLogin
 */
class AlternateLoginsController extends AccountsAppController {

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
		$this->AlternateLogin->recursive = 0;
		$this->set('alternateLogins', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->AlternateLogin->exists($id)) {
			throw new NotFoundException(__('Invalid alternate login'), 'flash/warning');
		}
		$options = array('conditions' => array('AlternateLogin.' . $this->AlternateLogin->primaryKey => $id));
		$this->set('alternateLogin', $this->AlternateLogin->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->AlternateLogin->create();
			if ($this->AlternateLogin->save($this->request->data)) {
				$this->Session->setFlash(__('The alternate login has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The alternate login could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$users = $this->AlternateLogin->User->find('list');
		$socialNetworks = $this->AlternateLogin->SocialNetwork->find('list');
		$this->set(compact('users', 'socialNetworks'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (!$this->AlternateLogin->exists($id)) {
			throw new NotFoundException(__('Invalid alternate login'), 'flash/warning');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->AlternateLogin->save($this->request->data)) {
				$this->Session->setFlash(__('The alternate login has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The alternate login could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('AlternateLogin.' . $this->AlternateLogin->primaryKey => $id));
			$this->request->data = $this->AlternateLogin->find('first', $options);
		}
		$users = $this->AlternateLogin->User->find('list');
		$socialNetworks = $this->AlternateLogin->SocialNetwork->find('list');
		$this->set(compact('users', 'socialNetworks'));
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->AlternateLogin->id = $id;
		if (!$this->AlternateLogin->exists()) {
			throw new NotFoundException(__('Invalid alternate login'), 'flash/warning');
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->AlternateLogin->delete()) {
			$this->Session->setFlash(__('Alternate login deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Alternate login was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

}
