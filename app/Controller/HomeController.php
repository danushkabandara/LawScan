<?php
App::uses('AppController', 'Controller');
/**
 * Home Controller
 *
 * @property WorkOrder $WorkOrder
 * @property PaginatorComponent $Paginator
 */

class HomeController extends AppController {
    var $uses = array( 'WorkOrder', 'Technician', 'Scan');
    public $components = array('Paginator');
    public function index() {
        $this->Paginator->settings = array(
            'limit' => 1000,
            'sort' => 'client_last_name',
            'direction' => 'asc'
        );
        $this->WorkOrder->recursive = 0;
        $this->set('workOrders', $this->Paginator->paginate());
        $allTechs = $this->Technician->find('all');
        $technicianArray = array(0);
        $percentageArray = array(0);
        $hoursEstimatedArray = array(0);
        $hoursTakenArray =array(0);
        $i=0;
        $workOrdersTechId = array(0);
        $workOrdersTechName = array(0);
        $workOrdersTechLastName = array(0);
        foreach ($allTechs as $tech)
        {
           $technicianArray[$i] =$tech['Technician']['first_name'];
            $j=0;
            //$hoursEstimated=0;
            $hoursTaken=0;

            foreach  ($tech['WorkOrder'] as $workOrder)
            {

                if ($workOrder['completion_time']==NULL)
                {
                    $j++;

                    $hoursTaken=$hoursTaken + $workOrder['completed_hours'];
                    $workOrdersTechId[$workOrder['id']] = $workOrder['WorkOrdersTechnician']['technician_id'];
                    $workOrdersTechName[$workOrder['id']] = $tech['Technician']['first_name'];
                    $workOrdersTechLastName[$workOrder['id']] = $tech['Technician']['last_name'];
                }
            }
            $percentageArray[$i] =$j;
            $hoursTakenArray[$i] = $hoursTaken;
            $i++;
        }
        $this->Set('technicianArray', $technicianArray);
        $this->Set('percentageArray', $percentageArray);
        $this->Set('hoursTakenArray', $hoursTakenArray);
        $this->set('workOrdersTechId',$workOrdersTechId);
        $this->set('workOrdersTechName',$workOrdersTechName);
        $this->set('workOrdersTechLastName',$workOrdersTechLastName);



        $openScans = $this->Scan->find('all', array('conditions'=>array('AND'=>array('Scan.technician_id'=>$this->Auth->user('username'),'OR'=>array('end_time'=>'', 'end_time'=>'0000-00-00 00:00:00')))));
        $scanInTechs = array();
        $customerNames = array();
        foreach ($openScans as $openScan) {
            $scanWorkOrder = $this->WorkOrder->find('first', array('conditions'=>array('WorkOrder.file_no'=>$openScan['Scan']['work_order_id'])));
            if (!empty($scanWorkOrder)) {
                $customerNames[$openScan['Scan']['work_order_id']] = $scanWorkOrder['WorkOrder']['client_last_name'];
            } else {
                $customerNames[$openScan['Scan']['work_order_id']] = "";
            }
            array_push($scanInTechs, $openScan['Scan']['technician_id']);
        }
        $this->set('openScans',$openScans);
        $this->set('customerNames',$customerNames);
      }


}
