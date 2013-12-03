<?php

App::uses('AppController', 'Controller');

/**
 * UserLogs Controller
 *
 * @property UserLog $UserLog
 */
class UserLogsController extends AccountsAppController {

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
		$this->UserLog->recursive = 0;
		$this->set('userLogs', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->UserLog->exists($id)) {
			throw new NotFoundException(__('Invalid user log'), 'flash/warning');
		}
		$options = array('conditions' => array('UserLog.' . $this->UserLog->primaryKey => $id));
		$this->set('userLog', $this->UserLog->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->UserLog->create();
			if ($this->UserLog->save($this->request->data)) {
				$this->Session->setFlash(__('The user log has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user log could not be saved. Please, try again.'), 'flash/error');
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
		if (!$this->UserLog->exists($id)) {
			throw new NotFoundException(__('Invalid user log'), 'flash/warning');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->UserLog->save($this->request->data)) {
				$this->Session->setFlash(__('The user log has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user log could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('UserLog.' . $this->UserLog->primaryKey => $id));
			$this->request->data = $this->UserLog->find('first', $options);
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
		$this->UserLog->id = $id;
		if (!$this->UserLog->exists()) {
			throw new NotFoundException(__('Invalid user log'), 'flash/warning');
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->UserLog->delete()) {
			$this->Session->setFlash(__('User log deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User log was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_search($page = NULL) {

		$conditions = array();
		if (isset($this->request->data['UserLog']['search_log']) and $this->request->data['UserLog']['search_log'] != " " and strlen($this->request->data['UserLog']['search_log']) > 2) {
			$fields = trim($this->request->data['UserLog']['search_log'], " ");
			$search = explode(" ", $fields);
			for ($i = 0; $i < count($search); $i++) {
				if (strlen($search[$i]) > 2) {
					$conditions[] = "UserLog.username like '%" . $search[$i] . "%'";
				}
			}
			$logs_search = $this->paginate('UserLog', array(
				'OR' => $conditions,
				));
			$this->Session->write('conditions', $conditions);
			if (count($logs_search) == 0) {
				$this->Session->setFlash('No se encontraron Registros!.', 'flash/warning');
			}
			$this->set('logs_search', $logs_search);
		} else {

			if (!empty($this->request->params['named']['page'])) {

				$this->paginate = array(
					'UserLog' => array(
						'page' => $this->request->params['named']['page'],
					)
				);
				if ($this->Session->read('conditions')) {
					$logs_search = $this->paginate('UserLog', array('OR' => $this->Session->read('conditions')));
				} else {
					$logs_search = $this->paginate('UserLog');
				}

				$this->set('logs_search', $logs_search);
			} else {
				$this->Session->setFlash('No se encontraron Registros!.', 'flash/warning');
				$this->redirect(array('action' => 'index'));
			}
		}
	}

}
