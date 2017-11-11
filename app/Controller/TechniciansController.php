<?php
App::uses('AppController', 'Controller');
/**
 * Technicians Controller
 *
 * @property Technician $Technician
 * @property PaginatorComponent $Paginator
 */
class TechniciansController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
    public $uses = array(
        'Technician',
        'Scan'
    );
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Technician->recursive = 0;
		$this->set('technicians', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Technician->exists($id)) {
			throw new NotFoundException(__('Invalid technician'));
		}
		$options = array('conditions' => array('Technician.' . $this->Technician->primaryKey => $id));

        $technician =$this->Technician->find('first', $options);
        $this->set('technician', $technician);
        $hoursEstimated=0;

        $hoursTaken=0;
        $count =0;
        foreach ($technician['WorkOrder'] as $workOrder)
        {
            if ($workOrder['completion_time']!=NULL)//completed work orders
            {
                $count++;
                $hoursEstimated = $hoursEstimated +$workOrder['estimated_hours'];
                $hoursTaken=$hoursTaken + $workOrder['completed_hours'];

            }

        }
        $this->set('hoursEstimated', $hoursEstimated);

        $this->set('hoursTaken', $hoursTaken);
        $this->set('workOrdersCompleted', $count);

    //   $this->set('scans', $this->Scan->findByTechnicianId($id));
        $options1 = array('conditions' => array('Scan.' . 'technician_id' => $id));
        $this->set('scans', $this->Scan->find('all',$options1 ));

	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Technician->create();
			if ($this->Technician->save($this->request->data)) {
				$this->Session->setFlash(__('The client has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client could not be saved. Please, try again.'));
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
	public function edit($id = null) {
		if (!$this->Technician->exists($id)) {
			throw new NotFoundException(__('Invalid technician'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Technician->save($this->request->data)) {
				$this->Session->setFlash(__('The client has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Technician.' . $this->Technician->primaryKey => $id));
			$this->request->data = $this->Technician->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Technician->id = $id;
		if (!$this->Technician->exists()) {
			throw new NotFoundException(__('Invalid client'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Technician->delete()) {
			$this->Session->setFlash(__('The client has been deleted.'));
		} else {
			$this->Session->setFlash(__('The client could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
