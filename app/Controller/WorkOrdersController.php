<?php
App::uses('AppController', 'Controller');
App::uses('ConnectionManager', 'Model');
/**
 * WorkOrders Controller
 *
 * @property WorkOrder $WorkOrder
 * @property PaginatorComponent $Paginator
 */
class WorkOrdersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
    public $helpers = array('QrCode');
    var $uses = array( 'WorkOrder','Technician','Scan');

/**
 * index method
 *
 * @return void
 */
    public $paginate = array(
        'limit' => 200
    );
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
			throw new NotFoundException(__('Invalid case'));
		}
		$options = array('conditions' => array('WorkOrder.' . $this->WorkOrder->primaryKey => $id));
        $workOrder = $this->WorkOrder->find('first', $options);
		$this->set('workOrder', $workOrder);
        $scans = $this->Scan->find('all',array('conditions' => array('Scan.work_order_id' =>$workOrder['WorkOrder']['file_no'] )));
        $this->set('scans',$scans);
	}
    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function viewSummary($id = null) {

        if (!$this->WorkOrder->exists($id)) {
            throw new NotFoundException(__('Invalid case'));
        }
        if(!isset($this->params['url']['date1'])||!(isset($this->params['url']['date2'])))
        {

            $options = array('conditions' => array('WorkOrder.' . $this->WorkOrder->primaryKey => $id));
            $workOrder = $this->WorkOrder->find('first', $options);


            $firstScan = $this->Scan->find('first', array(
                'conditions' => array('Scan.work_order_id' => $workOrder['WorkOrder']['file_no']),
                'order' => array('Scan.start_time' => 'asc'),
                'limit' => 1
            ));

            $lastScan = $this->Scan->find('first', array(
                'conditions' => array('Scan.work_order_id' => $workOrder['WorkOrder']['file_no']),
                'order' => array('Scan.start_time' => 'desc'),
                'limit' => 1
            ));

            if (empty($firstScan)||empty($lastScan)) {
                $date1= new DateTime("NOW");
                $date2= new DateTime("NOW");

                $date1 = $date1->format('Y-m-d H:i:s');
                $date2 = $date2->format('Y-m-d H:i:s');
            } else {
                $date1 = $firstScan['Scan']['start_time'];
                $date2 = $lastScan['Scan']['start_time'];
            }

            $date1 = explode("-", $date1);
            $year1 = (string)$date1[0];
            $month1= (string)$date1[1];

            $day = split(' ',(string)$date1[2]);
            $day1= $day[0];

            $date2 = explode("-", $date2);
            $year2 = (string)$date2[0];
            $month2= (string)$date2[1];

            $day = split(' ',(string)$date2[2]);
            $day2= $day[0];

            $this->set('chosenDate1',$month1.'/'.$day1.'/'.$year1);

            $this->set('chosenDate2',$month2.'/'.$day2.'/'.$year2);

        }
        else
        {
            $date1=$this->params['url']['date1'];
            $date2=$this->params['url']['date2'];

            $this->set('chosenDate1',$date1);

            $this->set('chosenDate2',$date2);

            $date1 = explode("/", $date1);
            $month1 = (string)$date1[0];
            $day1= (string)$date1[1];
            $year1 = (string)$date1[2];

            $date2 = explode("/", $date2);
            $month2 = (string)$date2[0];
            $day2= (string)$date2[1];
            $year2 = (string)$date2[2];
        }

        //$this->set('chosenDate1',$date1);

        //$this->set('chosenDate2',$date2);

        $options = array('conditions' => array('WorkOrder.' . $this->WorkOrder->primaryKey => $id));
        $workOrder = $this->WorkOrder->find('first', $options);
        $this->set('workOrder', $workOrder);
        $scans = $this->Scan->find('all',array('conditions' => array('Scan.work_order_id' =>$workOrder['WorkOrder']['file_no'],'Scan.start_time >=' => $year1."-".$month1."-".$day1.' 00:00:00',
                                            'Scan.start_time <='  => $year2."-".$month2."-".$day2.' 23:59:59' ),'order'=>'Scan.id ASC',));
        $this->set('scans',$scans);

        $startDate= "0000-00-00 00:00:00";
        $endDate= "0000-00-00 00:00:00";


        $remainingHours = 0;
        $activityArray =array();
        $count=0;
        $hours=0;
        $totalBill=0;
        $totalHours=0;
        $remainingDisbursement=0;
        $remainingRetainer=0;

        foreach ($scans as $scan)
        {

            if($scan['Scan']['start_time']!='0000-00-00 00:00:00' && $count==0 ){
               $startDate=$scan['Scan']['start_time'];
            }
            if($scan['Scan']['end_time']!='0000-00-00 00:00:00'){
               $endDate=$scan['Scan']['end_time'];
            }
            //calculate hours for each activity and put into array indexed by activity number
            if($scan['Scan']['start_time']!='0000-00-00 00:00:00' && $scan['Scan']['end_time']!='0000-00-00 00:00:00'){
                $format = 'Y-m-d H:i:s';
                $date1 = DateTime::createFromFormat($format, h($scan['Scan']['start_time']));
                $date2 = DateTime::createFromFormat($format, h($scan['Scan']['end_time']));
                $timeLapse = $date1->diff($date2);
                if ($workOrder['WorkOrder']['billing_method'] == 1) {
                    //$hours = ceil((($timeLapse->format('%i'))/60+$timeLapse->format('%h'))*100)/100;
                    $hours = ($timeLapse->format('%i'))/60+$timeLapse->format('%h');
                } else if($workOrder['WorkOrder']['billing_method'] == 2){
                    $hours = ceil((($timeLapse->format('%i'))/60+$timeLapse->format('%h'))*10)/10;
                } else if($workOrder['WorkOrder']['billing_method'] == 3) {
                    $hours = ceil((($timeLapse->format('%i'))/60+$timeLapse->format('%h'))*4)/4;
                }

            }
            else{$hours =0; }

            if(!isset($activityArray[$scan['Scan']['activity']]))//count the scan hours for each activity (for pie chart)
                $activityArray[$scan['Scan']['activity']]= $hours;
            else
                $activityArray[$scan['Scan']['activity']]=$activityArray[$scan['Scan']['activity']]+$hours;
            //total bill is calculated based on tenths rule or normal rule
            if($workOrder['WorkOrder']['billing_method']==1)//realtime rule
            {
                $totalBill=$totalBill+$hours*$scan['Scan']['billing_rate'];
                //$totalBill=$totalBill+ceil($hours*100)*($scan['Scan']['billing_rate']/100);
            }
            else if($workOrder['WorkOrder']['billing_method']==2)//tenths rule
            {


                    $totalBill=$totalBill+ceil($hours*10)*($scan['Scan']['billing_rate']/10);

            } else if($workOrder['WorkOrder']['billing_method']==3) {
                $totalBill=$totalBill+ceil($hours*4)*($scan['Scan']['billing_rate']/4);
            }
            $totalHours=$totalHours+$hours;
            $count++;


        }

        $keys= array_keys($activityArray);//get the keys of freq array

        $this->set('expense_reimbursements',unserialize($workOrder['WorkOrder']['serialized_expense_reimbursements']));
        $this->set('expense_reimbursement_dates',unserialize($workOrder['WorkOrder']['serialized_expense_reimbursement_dates']));
        $this->set('expense_reimbursement_types',unserialize($workOrder['WorkOrder']['serialized_expense_reimbursement_types']));
        $this->set('additional_retainers',unserialize($workOrder['WorkOrder']['serialized_additional_retainers']));
        $this->set('additional_retainers_dates',unserialize($workOrder['WorkOrder']['serialized_additional_retainers_dates']));

        $typesArray=array();
        foreach ($keys as $key)
        {
            $typesArray[$key]= Scan::activities($key);
        }
        if($workOrder['WorkOrder']['serialized_expense_reimbursements'])
            $expenseReimbursementsSum=array_sum(unserialize($workOrder['WorkOrder']['serialized_expense_reimbursements']));
        else
            $expenseReimbursementsSum=0;



        if($workOrder['WorkOrder']['serialized_additional_retainers'] && $workOrder['WorkOrder']['serialized_additional_retainers']!="N;")
            $additionalRetainerSum=array_sum(unserialize($workOrder['WorkOrder']['serialized_additional_retainers']));
        else
            $additionalRetainerSum=0;
        $remainingDisbursement=$workOrder['WorkOrder']['disbursement']-$expenseReimbursementsSum;//disbursement calculation
        $remainingRetainer=$workOrder['WorkOrder']['retainer']+$additionalRetainerSum-$totalBill;//retainer calculation
        $this->set('remainingDisbursement', $remainingDisbursement);
        $this->set('remainingRetainer', $remainingRetainer);

        $this->set('totalBill', $totalBill);
        $this->set('totalHours', $totalHours);
        $this->set('typesArray',$typesArray);
        $this->set('percentagesArray',$activityArray);
        $this->set('startDate',$startDate);
        $this->set('endDate',$endDate);

        $this->set('remainingHours',$remainingHours);


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
	public function addFromReader() {
        $random = 0;
		if ($this->request->is('post')) {
			$this->WorkOrder->create();
            $barcodeString=$this->request->data['bar_code'];
            $strippedString = substr($barcodeString, -17);
            $this->WorkOrder->data['WorkOrder']['vin']= $strippedString;//reads tid from post data

            $random = substr(number_format(time() * rand(),0,'',''),0,10);
            $this->WorkOrder->data['WorkOrder']['order_no'] = $random;
            $time = new DateTime('NOW');
            $time->modify('-60 minutes');
            $this->WorkOrder->data['WorkOrder']['created_time']=$time->format('Y-m-d H:i:s');


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
			throw new NotFoundException(__('Invalid case'));
		}

		if ($this->request->is(array('post', 'put'))) {

			if ($this->WorkOrder->save($this->request->data)) {

				$this->Session->setFlash(__('The case has been saved.'));
				return $this->redirect(array('controller'=>'home','action' => 'index','sort'=>'client_last_name','direction'=>'asc'));
			} else {
				$this->Session->setFlash(__('The case could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('WorkOrder.' . $this->WorkOrder->primaryKey => $id));
			$this->request->data = $this->WorkOrder->find('first', $options);
            $this->set('expense_reimbursements',unserialize($this->request->data['WorkOrder']['serialized_expense_reimbursements']));
            $this->set('expense_reimbursement_dates',unserialize($this->request->data['WorkOrder']['serialized_expense_reimbursement_dates']));
            $this->set('expense_reimbursement_types',unserialize($this->request->data['WorkOrder']['serialized_expense_reimbursement_types']));
            $this->set('additional_retainers',unserialize($this->request->data['WorkOrder']['serialized_additional_retainers']));
            $this->set('additional_retainers_dates',unserialize($this->request->data['WorkOrder']['serialized_additional_retainers_dates']));
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
			throw new NotFoundException(__('Invalid case'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->WorkOrder->delete()) {
			$this->Session->setFlash(__('The case has been deleted.'));
		} else {
			$this->Session->setFlash(__('The case could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('controller'=>'home','action' => 'index','sort'=>'client_last_name','direction'=>'asc'));
	}


/**
 * close method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
public function close($id = null) {
    $this->WorkOrder->id = $id;
    if (!$this->WorkOrder->exists()) {
        throw new NotFoundException(__('Invalid case'));
    }
    $now = new DateTime();
    $now->modify('-60 minutes');

   $this->WorkOrder->set('completion_time', $now->format('Y-m-d H:i:s'));    // MySQL datetime format
    if ($this->WorkOrder->save()) {
        $this->Session->setFlash(__('The case has been closed.'));
    } else {
        $this->Session->setFlash(__('The case could not be closed. Please, try again.'));
    }
    return $this->redirect(array('controller'=>'home','action' => 'index','sort'=>'client_last_name','direction'=>'asc'));
}






/*to add work order using form*/

public function add() {
    if ($this->request->is('post')) {
        $this->WorkOrder->create();
        if ($this->WorkOrder->save($this->data)) {
            $this->Session->setFlash(__('The case has been saved', true));
            return $this->redirect(array('controller'=>'home','action' => 'index','sort'=>'client_last_name','direction'=>'asc'));
        } else {
            $this->Session->setFlash(__('The case could not be saved. Please, try again.'));
        }
    }
    /*  $groups = $this->User->Group->find('list');
      $this->set(compact('groups'));*/
    $technicians = $this->WorkOrder->Technician->find('list');
    $this->set(compact('technicians'));
    $time = new DateTime('NOW');
    $time->modify('-60 minutes');
    $created_time = $time->format('Y-m-d H:i:s');
    $this->set(compact('created_time'));
    $order_no = substr(number_format(time() * rand(),0,'',''),0,10);
    $this->set(compact('order_no'));
}

    public function test(){
        $db = ConnectionManager::getDataSource('default');

        if ($this->request->is('post')) {

            $db->rawQuery('INSERT INTO test VALUES ("'.$this->request->data['bar_code'].'")');


        }


    }


}