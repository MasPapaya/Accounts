<?php

/**
 * DocidTypes Controller
 *
 * @property DocidType $DocidType
 * @property PaginatorComponent $Paginator
 */
class DocidTypesController extends AccountsAppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator');
	public $uses = array('Accounts.DocidType');

	function beforeFilter() {
		parent::beforeFilter();
		if (Configure::read('debug') > 1) {
			$this->Auth->allow();
		}
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->DocidType->recursive = 0;
		$this->set('docidTypes', $this->Paginator->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->DocidType->exists($id)) {
			throw new NotFoundException(__('Invalid docid type'));
		}
		$options = array('conditions' => array('DocidType.' . $this->DocidType->primaryKey => $id));
		$this->set('docidType', $this->DocidType->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->DocidType->create();
			if ($this->DocidType->save($this->request->data)) {
				$this->Session->setFlash(__('The docid type has been saved.'),'flash/success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The docid type could not be saved. Please, try again.'),'flash/warning');
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
		if (!$this->DocidType->exists($id)) {
			throw new NotFoundException(__('Invalid docid type'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->DocidType->save($this->request->data)) {
				$this->Session->setFlash(__('The docid type has been saved.'),'flash/success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The docid type could not be saved. Please, try again.'),'flash/warnig');
			}
		} else {
			$options = array('conditions' => array('DocidType.' . $this->DocidType->primaryKey => $id));
			$this->request->data = $this->DocidType->find('first', $options);
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
		$this->DocidType->id = $id;
		if (!$this->DocidType->exists()) {
			throw new NotFoundException(__('Invalid docid type'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DocidType->delete()) {
			$this->Session->setFlash(__('The docid type has been deleted.'),'flash/success');
		} else {
			$this->Session->setFlash(__('The docid type could not be deleted. Please, try again.'),'flash/warning');
		}
		return $this->redirect(array('action' => 'index'));
	}

}
