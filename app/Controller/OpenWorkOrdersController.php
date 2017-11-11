<?php
App::uses('AppController', 'Controller');
/**
 * WorkOrders Controller
 *
 * @property WorkOrder $WorkOrder
 * @property PaginatorComponent $Paginator
 */
class OpenWorkOrdersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
    public $helpers = array('QrCode');
    var $uses = array( 'WorkOrder','Scan');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->WorkOrder->recursive = 0;
		$this->set('workOrders', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->WorkOrder->exists($id)) {
			throw new NotFoundException(__('Invalid work order'));
		}
		$options = array('conditions' => array('WorkOrder.' . $this->WorkOrder->primaryKey => $id));
        $workOrder = $this->WorkOrder->find('first', $options);
		$this->set('workOrder', $workOrder);

	}

/**
 * add method
 *
 * @return void
 * 	public function add() {
if ($this->request->is('post')) {
$this->WorkOrder->create();
if ($this->WorkOrder->save($this->request->data)) {
$this->Session->setFlash(__('The work order has been saved.'));
return $this->redirect(array('action' => 'index'));
} else {
$this->Session->setFlash(__('The work order could not be saved. Please, try again.'));
}
}
$technicians = $this->WorkOrder->Technician->find('list');
$this->set(compact('technicians'));
}
 */
	public function add() {
        $random = 0;
		if ($this->request->is('post')) {
			$this->WorkOrder->create();
            $this->WorkOrder->data['WorkOrder']['vin']= $this->request->data['tid'];//reads tid from post data
            $random = substr(number_format(time() * rand(),0,'',''),0,10);
            $this->WorkOrder->data['WorkOrder']['order_no'] = $random;
          //  $this->WorkOrder->data['WorkOrder']['description'] =$this->request->data['answers']['297648'];//reads answer to question id provided
            $this->WorkOrder->save();
		}
		$technicians = $this->WorkOrder->Technician->find('list');
		$this->set(compact('technicians'));
        $this->response->header('Content-type: text/xml');
        $this->response->body('<?xml version="1.0" encoding="UTF-8"?><xml> <message> <status>1</status><text>Work order created successfully. Work order number is'.$random.'</text></message></xml>');
	    $this->response->send();//sends success response to device
    }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->WorkOrder->exists($id)) {
			throw new NotFoundException(__('Invalid work order'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->WorkOrder->save($this->request->data)) {
				$this->Session->setFlash(__('The work order has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The work order could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('WorkOrder.' . $this->WorkOrder->primaryKey => $id));
			$this->request->data = $this->WorkOrder->find('first', $options);
		}
		$technicians = $this->WorkOrder->Technician->find('list');
		$this->set(compact('technicians'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->WorkOrder->id = $id;
		if (!$this->WorkOrder->exists()) {
			throw new NotFoundException(__('Invalid work order'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->WorkOrder->delete()) {
			$this->Session->setFlash(__('The work order has been deleted.'));
		} else {
			$this->Session->setFlash(__('The work order could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
