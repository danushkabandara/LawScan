<?php
App::uses('AppController', 'Controller');
/**
 * WorkOrders Controller
 *
 * @property WorkOrder $WorkOrder
 * @property PaginatorComponent $Paginator
 */
class ScansController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');
    var $uses = array('Scan', 'WorkOrder');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add');
    }
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Scan->recursive = 0;
        $this->set('scans', $this->Paginator->paginate());
    }

    public function add_manual($id = null) {
        if ($this->request->is('POST')) {
            $data = $this->request->data;
            $workOrder = $this->WorkOrder->findByFileNo($data['Scan']['work_order_id']);
            $id = $workOrder['WorkOrder']['id'];
            $data['Scan']['technician_id'] = $this->Auth->user('username');
            $data['Scan']['activity']++;
            if($this->Scan->save($data)) {
                $this->Session->setFlash(__('The Scan has been saved.'));
                return $this->redirect(array('controller'=>'work_orders','action' => 'viewSummary', $id));
            } else {
                $this->Session->setFlash(__('The scan could not be saved. Please, try again.'));
            }
        } else {
            $workOrder = $this->WorkOrder->find('first', array('conditions'=>array('WorkOrder.id'=>$id)));
            if (!$workOrder) {
                return $this->redirect(array('controller'=>'home','action' => 'index'));
            }

            $work_order_id = $workOrder['WorkOrder']['file_no'];
            $customerName = $workOrder['WorkOrder']['client_last_name'];
            $activities = array("Review documents", "Client contact", "Travel", "Phone/correspondence", "Legal drafting", "Legal research", "Investigation","Depositions","Out of Court", "Initial appearance", "Pre-trial hearing", "Fact-finding", "Disposition", "In Court - all other", "Expenses", "Mileage");
            $billing_rate = $workOrder['WorkOrder']['billing_rate'];

            $this->set('work_order_id',$work_order_id);
            $this->set('client_name',$customerName);
            $this->set('activities',$activities);
            $this->set('billing_rate',$billing_rate);
        }

    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Scan->exists($id)) {
            throw new NotFoundException(__('Invalid Scan'));
        }
        $options = array('conditions' => array('Scan.' . $this->Scan->primaryKey => $id));
        $this->set('scan', $this->Scan->find('first', $options));
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
        if ($this->request->is('post')) {
            //if the workorder number doesnt exist in db, create a new entry, other wise update the existing status to closed and update end time.
            //also calculate the workorder
            $workOrderId=  $this->request->data["qr_code"];
            $workOrderEntry= $this->WorkOrder->find('first', array('conditions'=>array('WorkOrder.file_no'=>$workOrderId)));
            $appTime = $this->request->data["time"];
            $appRate = $this->request->data["rate"];
            if (array_key_exists("techDetail", $this->request->data)) {
            	$techDetail = $this->request->data["techDetail"];
            }
            $appUsername = $this->request->data["username"];
            $scanEntry= $this->Scan->find('first', array('conditions'=>array(array('Scan.work_order_id'=>$workOrderId),array('Scan.technician_id'=>$appUsername)), 'order'=>array('Scan.id'=>'DESC')));

            $time = new DateTime($appTime);
            if(count($workOrderEntry)==0)
            {   $this->response->header('Content-type: text');
                $this->response->body("Case Number does not exist: ".$workOrderId);
                $this->response->send();//sends success response to device


            }
            else if(sizeof($scanEntry)>0 && $scanEntry['Scan']['end_time']=='0000-00-00 00:00:00')//check is previous scan available for that work order
            {
                $startTime = new DateTime($scanEntry['Scan']['start_time']);
                $diff = $time->diff($startTime);
                $completedHours = number_format(($diff->h + $diff->i/60),2,'.', ',') ;

                $prevCompletedHours = $workOrderEntry['WorkOrder']['completed_hours'];
                $completedHours = $completedHours+$prevCompletedHours;
                $this->Scan->updateAll(//update scan
                    array('Scan.end_time' => "'".($time->format('Y-m-d H:i:s'))."'",
                    			'Scan.description'=>"'".$techDetail."'"),
                    // array('Scan.scan_status' =>1),
                    array('Scan.id'=>$scanEntry['Scan']['id'] )

                );
                $this->WorkOrder->updateAll(
                    array('WorkOrder.completed_hours' => $completedHours),
                    array('WorkOrder.file_no'=>$workOrderId )
                );
               $this->response->header('Content-type: text');
               $this->response->body($this->request->data["activity"].",".$workOrderId.",".$appTime.","."Scanned out of ".Scan::activities($this->request->data["activity"])." | Case Number ".$workOrderId);
               $this->response->send();//sends success response to device
            }
            else
            {
                $activity = $this->request->data["activity"];
                $this->Scan->create();
                $this->Scan->data['Scan']['work_order_id']= $workOrderId;//reads tid from post data

                $this->Scan->data['Scan']['scan_status']=0;
                $this->Scan->data['Scan']['start_time']= $time->format('Y-m-d H:i:s');
                $this->Scan->data['Scan']['activity']= $activity;
                 if($appRate== 0)//if app sends zero it means rate hasnt been selected. Therefore use work order default rate
                    $appRate= $workOrderEntry['WorkOrder']['billing_rate'];
                $this->Scan->data['Scan']['billing_rate']= $appRate;
                $this->Scan->data['Scan']['technician_id']= $appUsername;
                $this->Scan->save();
                if(sizeof($scanEntry)==0)//.only update start time if this is the first ever scan
                {
                    $this->WorkOrder->updateAll(//update starttime of workorder
                        array('WorkOrder.start_time' => "'".($time->format('Y-m-d H:i:s'))."'"),
                        array('WorkOrder.file_no'=>$workOrderId)
                    );
                }

                $this->response->header('Content-type: text');
                $this->response->body($this->request->data["activity"].",".$workOrderId.",".$appTime.","."Scanned in to ".Scan::activities($this->request->data["activity"])." | Case Number ".$workOrderId);
                $this->response->send();//sends success response to device
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
    public function edit($id = null, $wid=null) {
        if (!$this->Scan->exists($id)) {
            throw new NotFoundException(__('Invalid Scan'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Scan->save($this->request->data)) {
               $this->Session->setFlash(__('The Scan has been saved.'));
                return $this->redirect(array('controller'=>'work_orders','action' => 'viewSummary', $wid));
            } else {
                $this->Session->setFlash(__('The scan could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Scan.' . $this->Scan->primaryKey => $id));
            $this->request->data = $this->Scan->find('first', $options);
        }

    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null,$wid=null) {
        $this->Scan->id = $id;
        if (!$this->Scan->exists()) {
            throw new NotFoundException(__('Invalid timeslip'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Scan->delete()) {
            $this->Session->setFlash(__('The timeslip has been deleted.'));
        } else {
            $this->Session->setFlash(__('The timeslip could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('controller'=>'work_orders','action' => 'viewSummary', $wid));
    }



}
