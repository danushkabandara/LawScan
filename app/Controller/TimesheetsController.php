<?php
App::uses('AppController', 'Controller');
/**
 * Home Controller
 *
 * @property WorkOrder $WorkOrder
 * @property PaginatorComponent $Paginator
 */

class TimesheetsController extends AppController {
    var $uses = array('Scan', 'WorkOrder', 'Technician', 'Activity', 'User');
    public $components = array('Paginator');
    public function index() {

        $conditions = array('Scan.end_time !='=>'0000-00-00 00:00:00');

        if ($this->request->is('POST')) {
            if (!empty($this->request->data['clientName'])) {
                $conditions['WorkOrder.client_name'] = $this->request->data['clientName'];
            }
        }

        $this->Paginator->settings = array(
            'conditions'=>$conditions,
            'sort' => 'Scan.start_time',
            'direction' => 'asc'
        );

        //$scans = $this->Scan->find('all', array('conditions'=>array('Scan.end_time !='=>'0000-00-00 00:00:00'), 'order'=>array('Scan.start_time'=>'ASC')));
        $this->set('scans', $this->Paginator->paginate());

        $clients = $this->WorkOrder->find('list', array('order'=>array('WorkOrder.client_last_name'=>'asc')));
        $users = $this->User->find('list', array('order'=>array('User.username'=>'asc')));
        $this->set('clients', $clients);
        $this->set('users', $users);
    }

    public function current_billing() {
        $user = $this->Auth->user('username');
        $date = new DateTime('NOW', new DateTimeZone('America/New_York'));
        $day = $date->format('d');
        if (intval($day) <= 15) {
            $start = $date->format('Y-m').'-01 00:00:00';
            $end = $date->format('Y-m').'-15 23:59:59';
        } else {
            $start = $date->format('Y-m').'-16 00:00:00';
            $end = $date->format('Y-m-t').' 23:59:59';
        }

        $conditions = array('Scan.technician_id'=>$user, 'Scan.start_time >=' => $start, 'Scan.end_time <='=>$end, 'Scan.end_time !='=>'0000-00-00 00:00:00');

        $this->Paginator->settings = array(
            'conditions'=>$conditions,
            'sort' => 'WorkOrder.client_name',
            'direction' => 'asc'
        );

        //$scans = $this->Scan->findCurrentBillingPeriod($user);
        $this->set('scans', $this->Paginator->paginate());
    }

    public function result() {

        $conditions = array('Scan.end_time !='=>'0000-00-00 00:00:00');

        if ($this->request->is('POST')) {
            if (empty($this->request->data['date'])) {
                $this->Session->setFlash(__('Date Not Specified. Please, try again.'));
                return $this->redirect(array('controller'=>'timesheets','action' => 'index'));
            }
            if (!empty($this->request->data['clients'])) {
                $conditions['WorkOrder.id'] = $this->request->data['clients'];
            }

            if (!empty($this->request->data['users'])) {
                $techs = array();
                foreach($this->request->data['users'] as $user_id) {
                    $user = $this->User->findById($user_id);
                    array_push($techs, $user['User']['username']);
                }
                $conditions['Scan.technician_id'] = $techs;
            }

            if (!empty($this->request->data['dateOptions'])) {
                if ($this->request->data['dateOptions'] == 'day') {
                    $date = $this->request->data['date'];
                    $date_time = DateTime::createFromFormat('n/j/Y', $date);

                    $start = $date_time->format('Y-m-d').' 00:00:00';
                    $end = $date_time->format('Y-m-d').' 23:59:59';

                    $conditions['Scan.start_time >='] = $start;
                    $conditions['Scan.start_time <='] = $end;
                } elseif ($this->request->data['dateOptions'] == 'week') {
                    $date = $this->request->data['date'];

                    $date_time = DateTime::createFromFormat('n/j/Y', $date);
                    $end_date_time = DateTime::createFromFormat('n/j/Y', $date);
                    $end_date_time->add(new DateInterval('P6D'));

                    $start = $date_time->format('Y-m-d').' 00:00:00';
                    $end = $end_date_time->format('Y-m-d').' 23:59:59';

                    $conditions['Scan.start_time >='] = $start;
                    $conditions['Scan.start_time <='] = $end;
                } elseif ($this->request->data['dateOptions'] == 'month') {
                    $date = $this->request->data['date'];
                    $date_time = DateTime::createFromFormat('n/Y', $date);

                    $start = $date_time->format('Y-m').'-01 00:00:00';
                    $end = $date_time->format('Y-m-t').' 23:59:59';

                    $conditions['Scan.start_time >='] = $start;
                    $conditions['Scan.start_time <='] = $end;
                } elseif ($this->request->data['dateOptions'] == 'year') {
                    $date = $this->request->data['date'];
                    $date_time = DateTime::createFromFormat('Y', $date);

                    $start = $date_time->format('Y').'-01-01 00:00:00';
                    $end = $date_time->format('Y').'-12-31 23:59:59';

                    $conditions['Scan.start_time >='] = $start;
                    $conditions['Scan.start_time <='] = $end;
                }
            }

            $this->Paginator->settings = array(
                'conditions'=>$conditions,
                'sort' => 'Scan.start_time',
                'direction' => 'asc'
            );

            //$scans = $this->Paginator->paginate();
            $scans = $this->Scan->find('all', array('conditions'=>$conditions, 'order'=>array('WorkOrder.full_name'=>'asc')));

            $client_totals = array();
            $attorney_totals = array();
            $format = 'Y-m-d H:i:s';

            foreach ($scans as $scan) {
            	$file_no = $scan['WorkOrder']['file_no'];
            	$username = $scan['Scan']['technician_id'];
            	if (!isset($client_totals[$file_no])) {
            		$client_totals[$file_no] = array();
            		$client_totals[$file_no]['hours'] = 0;
            		$client_totals[$file_no]['client'] = $scan['WorkOrder']['full_name'];
            	}
            	if (!isset($attorney_totals[$username])) {
            		$attorney_totals[$username] = array();
            		$attorney_totals[$username]['hours'] = 0;
            	}
            	$date1 = DateTime::createFromFormat($format, h($scan['Scan']['start_time']));
					$date2 = DateTime::createFromFormat($format, h($scan['Scan']['end_time']));

					$timelapse = $date1->diff($date2);

					if($scan['WorkOrder']['billing_method']==1)//realtime rule
					{
						$hours = number_format(($timelapse->format('%i'))/60+$timelapse->format('%h'),3);
						//echo ceil((($timelapse->format('%i'))/60+$timelapse->format('%h'))*100)/100;
						//$bill = ($timelapse->format('%i')/60+$timelapse->format('%h'))*$scan['Scan']['billing_rate'];
					}
					else if($scan['WorkOrder']['billing_method']==2)//tenths rule
					{
						$hours = number_format(ceil((($timelapse->format('%i'))/60+$timelapse->format('%h'))*10)/10,1);
						//echo number_format(($timelapse->format('%i'))/60+$timelapse->format('%h'),1);
						//$bill=+ceil(($timelapse->format('%i')/60+$timelapse->format('%h'))*10)*($scan['Scan']['billing_rate']/10);
					} else if($scan['WorkOrder']['billing_method']==3) {
						$hours = number_format(ceil((($timelapse->format('%i'))/60+$timelapse->format('%h'))*4)/4,2);
						//echo number_format(($timelapse->format('%i'))/60+$timelapse->format('%h'),1);
						//$bill=+ceil(($timelapse->format('%i')/60+$timelapse->format('%h'))*4)*($scan['Scan']['billing_rate']/4);
					}
					$client_totals[$file_no]['hours'] += $hours;
					$attorney_totals[$username]['hours'] += $hours;

            }

            $this->set('client_totals', $client_totals);
            $this->set('attorney_totals', $attorney_totals);

            $this->set('scans', $scans);
        } else {
            return $this->redirect(array('controller'=>'timesheets','action' => 'index'));
        }

    }

}