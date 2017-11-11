<?php

class TechOrdersController extends AppController {
    public $uses = array('Scan', 'WorkOrder', 'Technician');

    public function scan($order = null, $activity = null, $rate = null, $offset = null) {
        if ($this->request->is('post')) {
            $this->set('data',$this->request->data);
            $data = $this->request->data['TechOrder'];

            $offset = $data['offset'];
            $order = $data['work_order_id'];
            $activity = $data['activity'];
            $rate = $data['rate'];
            $techName = $this->Auth->user('username');

            $time = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
            $time->sub(new DateInterval('PT'.$offset.'M'));

            $workOrderEntry= $this->WorkOrder->find('first', array('conditions'=>array('WorkOrder.id'=>$order)));

            $orderNumber = $workOrderEntry['WorkOrder']['file_no'];

            $scanEntry= $this->Scan->find('first', array('conditions'=>array(array('Scan.work_order_id'=>$orderNumber),array('Scan.technician_id'=>$techName)), 'order'=>array('Scan.id'=>'DESC')));

            if(count($workOrderEntry)==0) {
                $this->Session->setFlash(__('Unable to process Scan for Workorder ID: ' . $order));
            } else if(sizeof($scanEntry)>0 && ($scanEntry['Scan']['end_time']=='' || $scanEntry['Scan']['end_time']=='0000-00-00 00:00:00')) {
                $this->Scan->updateAll(//update scan

                    array('Scan.end_time' => "'".($time->format('Y-m-d H:i:s'))."'"),
               // array('Scan.scan_status' =>1),
                    array('Scan.id'=>$scanEntry['Scan']['id'] )
                );
                $startTime = new DateTime($scanEntry['Scan']['start_time']);
                $diff = $startTime->diff($time);
                $completedHours = number_format(($diff->h + $diff->i/60),2,'.', ',') ;
                $prevCompletedHours = $workOrderEntry['WorkOrder']['completed_hours'];
                $completedHours = $completedHours+$prevCompletedHours;
                $this->WorkOrder->updateAll(
                    array('WorkOrder.completed_hours' => $completedHours),
                    array('WorkOrder.file_no'=>$orderNumber )
                );
                $this->Session->setFlash(__(($time->format('Y-m-d H:i:s')).", ".$orderNumber.', Signed out of client: '.$workOrderEntry['WorkOrder']['client_last_name']));

            } else {

                $this->Scan->create();
                $this->Scan->set('work_order_id', $orderNumber);
                $this->Scan->set('technician_id', $techName);
                $this->Scan->set('start_time', $time->format('Y-m-d H:i:s'));
                //$this->Scan->set('end_time', '0000-00-00 00:00:00');
                $this->Scan->set('scan_status', 0);
                $this->Scan->set('hours_worked',0);
                $this->Scan->set('bill',0);
                //$this->Scan->set('other',' ');
                $this->Scan->set('activity',($activity+1));
                $this->Scan->set('billing_rate',$rate);
                $this->Scan->save();

                if(sizeof($scanEntry)==0) {
                    $this->WorkOrder->updateAll(//update starttime of workorder
                        array('WorkOrder.start_time' => "'".($time->format('Y-m-d H:i:s'))."'"),
                        array('WorkOrder.file_no'=>$orderNumber)
                    );
                }

                $this->Session->setFlash(__(($time->format('Y-m-d H:i:s')).', '.$orderNumber.', Signed in to client: '.$workOrderEntry['WorkOrder']['client_last_name']));
                return $this->redirect(array('controller' => 'home', 'action' => 'index', 'sort' => 'id', 'direction' => 'desc'));


            }

            return $this->redirect(array('controller' => 'home', 'action' => 'index', 'sort' => 'id', 'direction' => 'desc'));
        } else {
            $customerOrder = $this->WorkOrder->find('first', array('conditions'=>array('WorkOrder.id'=>$order)));
            $case_no = $customerOrder['WorkOrder']['case_no'];
            $customerName = $customerOrder['WorkOrder']['client_last_name'];
            $activities = array("Review documents", "Client contact", "Travel", "Phone/correspondence", "Legal drafting", "Legal research", "Investigation","Depositions","Out of Court", "Initial appearance", "Pre-trial hearing", "Fact-finding", "Disposition", "In Court - all other", "Expenses", "Mileage");
            $billing_rate = $customerOrder['WorkOrder']['billing_rate'];

            $this->set('case_no',$case_no);
            $this->set('work_order_id',$order);
            $this->set('client_name',$customerName);
            $this->set('activities',$activities);
            $this->set('billing_rate',$billing_rate);
        }
    }

    public function scanOut($id = null, $offset = null) {
        if ($this->request->is('post')) {
            $time = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
            $time->sub(new DateInterval('PT'.$offset.'M'));
            //$time = new DateTime('NOW', new DateTimeZone('America/New_York'));
            $scanEntry= $this->Scan->find('first', array('conditions'=>array('Scan.id'=>$id)));
            $workOrderEntry= $this->WorkOrder->find('first', array('conditions'=>array('WorkOrder.file_no'=>$scanEntry['Scan']['work_order_id'])));
            if (count($workOrderEntry)==0) {
                $this->Session->setFlash(__('NO WORKORDER FOUND'));
            } else if ($scanEntry['Scan']['end_time']==''||$scanEntry['Scan']['end_time']=='0000-00-00 00:00:00') {
                $orderNumber = $workOrderEntry['WorkOrder']['file_no'];
                $this->Scan->updateAll(//update scan
                    array('Scan.end_time' => "'".($time->format('Y-m-d H:i:s'))."'"),
                    array('Scan.id'=>$scanEntry['Scan']['id'] )
                );
                $format = 'Y-m-d H:i:s';
                $startTime = DateTime::createFromFormat($format, $scanEntry['Scan']['start_time']);

                $diff = $startTime->diff($time);
                $completedHours = number_format(($diff->h + $diff->i/60 + $diff->s/3600),2,'.', ',') ;
                $prevCompletedHours = $workOrderEntry['WorkOrder']['completed_hours'];
                if ($prevCompletedHours==null) {
                    $prevCompletedHours = 0;
                }

                $completedHours = $completedHours+$prevCompletedHours;
                $this->WorkOrder->updateAll(
                    array('WorkOrder.completed_hours' => $completedHours),
                    array('WorkOrder.file_no'=>$orderNumber )
                );
                $this->Session->setFlash(__(($time->format('Y-m-d H:i:s')).", ".$scanEntry['Scan']['technician_id'].', Signed out of client: '.$workOrderEntry['WorkOrder']['client_last_name']));
            }
        }
        return $this->redirect(array('controller'=>'home','action'=>'index','sort'=>'id','direction'=>'desc'));
    }
}


?>