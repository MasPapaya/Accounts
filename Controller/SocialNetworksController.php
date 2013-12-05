<?php

App::uses('AppController', 'Controller');

/**
 * SocialNetworks Controller
 *
 * @property SocialNetwork $SocialNetwork
 */
class SocialNetworksController extends AccountsAppController {

	public function beforeFilter() {
		parent::beforeFilter();
	}

	// public function isAuthorized() {
	// 	parent::isAuthorized();
	// 	switch ($this->Auth->user('group_id')) {
	// 		case 1:
	// 		case 2:
	// 			return true;
	// 			break;
	// 		case 3:
	// 			return false;
	// 			break;
	// 		case 4:
	// 			return false;
	// 			break;
	// 		default :
	// 			return false;
	// 			break;
	// 	}
	// }

	/**
	 * index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->SocialNetwork->recursive = 0;
		$this->set('socialNetworks', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->SocialNetwork->exists($id)) {
			throw new NotFoundException(__('Invalid social network'), 'flash/warning');
		}
		$options = array('conditions' => array('SocialNetwork.' . $this->SocialNetwork->primaryKey => $id));
		$this->set('socialNetwork', $this->SocialNetwork->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->SocialNetwork->create();
			if ($this->SocialNetwork->save($this->request->data)) {
				$this->Session->setFlash(__('The social network has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The social network could not be saved. Please, try again.'), 'flash/error');
			}
		}
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (!$this->SocialNetwork->exists($id)) {
			throw new NotFoundException(__('Invalid social network'), 'flash/warning');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->SocialNetwork->save($this->request->data)) {
				$this->Session->setFlash(__('The social network has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The social network could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('SocialNetwork.' . $this->SocialNetwork->primaryKey => $id));
			$this->request->data = $this->SocialNetwork->find('first', $options);
		}
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->SocialNetwork->id = $id;
		if (!$this->SocialNetwork->exists()) {
			throw new NotFoundException(__('Invalid social network'), 'flash/warning');
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->SocialNetwork->delete()) {
			$this->Session->setFlash(__('Social network deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Social network was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

}
