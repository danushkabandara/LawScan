<?php
/**
 * Created by JetBrains PhpStorm.
 * User: danushka
 * Date: 8/21/13
 * Time: 11:45 PM
 * To change this template use File | Settings | File Templates.
 */
class DownloadDataController extends AppController{
    var $helpers = array('Form','Csv');
    public $uses = array('Technician','WorkOrder','DownloadData');
    public function index(){
        if(isset($_GET['date1'])){//if the date is set, create the csv file
            $this->set('building', $this->params['url']['building']);
            $this->set('chosenDate1',$this->params['url']['date1']);
            $this->set('chosenDate2',$this->params['url']['date2']);

            $this->set('chosenDate1',$this->params['url']['date1']);
            $date1 = explode("/", $this->params['url']['date1']);
            $month1 = (string)$date1[0];
            $day1= (string)$date1[1];
            $year1= (string)$date1[2];

            $this->set('chosenDate2',$this->params['url']['date2']);
            $date2 = explode("/", $this->params['url']['date2']);
            $month2 = (string)$date2[0];
            $day2= (string)$date2[1];
            $year2 = (string)$date2[2];
        //    $technician = $this->Technician->find('first',array('conditions'=> array( "Technician.id"=>$this->params['url']['building'])));

            $fieldNameArray=array('vin', 'order_no', 'description', 'estimated_hours','start_time', 'completion_time','completed_hours');

            $readings = $this->WorkOrder->find('all',
                array('conditions' => array
                (
                    'WorkOrder.completion_time >=' => $year1."-".$month1."-".$day1." 00:00:00",
                    'WorkOrder.completion_time <='  => $year2."-".$month2."-".$day2." 00:00:00",
                ),
                    'order'=>array('WorkOrder.completion_time'=>'DESC')));
$result=array(0);
$count =0;
            foreach ($readings as $reading)
            {
                    if($reading['Technician']['0']['id']==$this->params['url']['building'])
                    {
                         $result[$count]=$reading;
                    }
                $count++;
            }
            $this->set('fieldNameArray', $fieldNameArray);
            $this->set('readings', $result);

            $this->render('download', 'download');
        }
        else if(!isset($_GET['date1']) && isset($_GET['building']))//if the date is set, create the csv file)
        {
             $this->set('techId', $_GET['building']);
        }
        $data = $this->Technician->find('list', array('fields' => array('id', 'first_name')));
        $this->set('technicians', $data);
        $this->set('chosenDate1',date('m/d/Y', (time()-14400)));
        $this->set('chosenDate2',date('m/d/Y', (time()-14400)));
        $this->set('chosenTime1','00:00');
        $this->set('chosenTime2','23:59');
        $this->set('fieldNameArray', 0);
    }

}