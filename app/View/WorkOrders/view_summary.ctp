<?php echo $this->Html->script(array('https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'));?>
<?php echo $this->Html->script('jquery-ui-1.10.3.custom.min'); ?>
<?php echo $this->Html->css('jquery-ui-1.10.3.custom.min'); ?>
<?php echo $this->Html->script('highcharts'); ?>


    <h2><?php echo __('Case Summary'); ?></h2>

    <h2 style="font-size:200%"><?php echo $workOrder['WorkOrder']['client_last_name'].','.$workOrder['WorkOrder']['client_first_name'];; ?></h2>

    <div class="row">
    <?php if(count($scans) > 0): ?>
    <div class="col-md-12 table-responsive">
        <div id="pie" style="float : center; width: 750px; height: 450px; margin: 0 auto"></div>
    </div>
    <?php else: ?>
        <div style="margin-bottom:20px">
            <h2 style="font-size:200%">No Activity Found</h2>
        </div>
    <?php endif; ?>
    </div>
    <div class="row">
    <div class="col-md-2 col-sm-2 col-xs-2">
        <button style="width:100px;height:40px;margin-bottom: 10px;" onClick="printDiv('printArea')" > Print </button>
    </div>
    <!--<div class="col-md-2 col-sm-2 col-xs-2">
        <button style="width:100px;height:40px;margin-bottom: 10px;"> QR Code </button>
    </div>-->
    </div>
    <div class="row">
    <div class ="col-md-2 col-sm-2 col-xs-6">
        From: <input id="datepicker"  type="text" value="<?php echo $chosenDate1; ?>"  />
    </div>
    <div class ="col-md-2 col-sm-2 col-xs-6">
        To: <input id="datepicker1"  type="text" value="<?php echo $chosenDate2; ?>"  />
    </div>
    <div class ="col-md-2 col-sm-2 col-xs-12">
        <input type="submit" value="Submit" name="Submit" id="submit_btn"style="margin-top:13px;">
    </div>
    </div>
 <div id="printArea" style="width:auto;height:auto;">

     <div id="letterHead" style="display: none;">
         <div style="float:left;width:300px">
            Parry Law Offices<br>
            410 W. Court Street<br>
            Rome, NY  13440<br>
            Tel:  (315) 337-3450<br><br><br>
         </div>
         <div style="float:right;width:300px">
         <?php echo $workOrder['WorkOrder']['client_first_name']." ";?>
         <?php echo $workOrder['WorkOrder']['client_last_name'];?><br>
            <?php echo nl2br($workOrder['WorkOrder']['address']);?>
         </div>
     </div>

    <div class="related" style="padding-top:10px;">
        <h3><?php echo __('Time Slip'); ?></h3>
        <div id="add_div" class="row" style="margin-right:0; margin-left:0">
            <div class="col-md-6" style="padding-left:0;padding-bottom:5px;">
                <!--<?php echo $this->Html->link(__('Manually Add Activity'), array('controller' => 'scans','action' => 'add_manual', $workOrder['WorkOrder']['id']), array('id'=>'addScanButton')); ?>-->
                <?php echo $this->Html->link(__('Manually Add Activity'), array('controller'=>'scans','action' => 'add_manual', $workOrder['WorkOrder']['id']), array('id'=>'AddWorkOrderBtn', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Create A New Activity')); ?>
            </div>
        </div>
        <div class="table-responsive">
        <table id="scans_table" class = 'hovertable' cellpadding = "0" cellspacing = "0">
            <tr>
               <th ><?php echo __('Start Date'); ?></th>
                <th><?php echo __('End Date'); ?></th>
                <th><?php echo __('Activity'); ?></th>
                <th><?php echo __('Description'); ?></th>
                <th><?php echo __('Hours worked'); ?></th>
                <th><?php echo __('Billing Rate'); ?></th>
                <th><?php echo __('Bill'); ?></th>
                <th class="username_col"><?php echo __('Username'); ?></th>
                <th class="actions_col"><?php echo __('Actions'); ?></th>
            </tr>
        <?php foreach ($scans as $scan): ?>
            <tr onmouseover="this.style.backgroundColor='#BCC6CC';" onmouseout="this.style.backgroundColor='#d4e3e5';">
                <td><?php if($scan['Scan']['start_time']!='0000-00-00 00:00:00'){
                $format = 'Y-m-d H:i:s';
                $date1 = DateTime::createFromFormat($format, h($scan['Scan']['start_time']));
                echo $date1->format('m-d-Y g:i:s A');} ?>&nbsp;</td>
                <td><?php
                    if($scan['Scan']['end_time']!='0000-00-00 00:00:00'){
            $format = 'Y-m-d H:i:s';
            $date2 = DateTime::createFromFormat($format, h($scan['Scan']['end_time']));
            echo $date2->format('m-d-Y g:i:s A');} ?>&nbsp;</td>
                <td><?php echo Scan::activities($scan['Scan']['activity']); ?></td>
                <td><?php echo $scan['Scan']['description']; ?></td>
                <td><?php if($scan['Scan']['end_time']!='0000-00-00 00:00:00'){
                          $timelapse = $date1->diff($date2);

                            if($workOrder['WorkOrder']['billing_method']==1)//realtime rule
                            {
                                 echo $this->Number->precision(($timelapse->format('%i'))/60+$timelapse->format('%h'),3);
                                 //echo ceil((($timelapse->format('%i'))/60+$timelapse->format('%h'))*100)/100;
                                 $bill = ($timelapse->format('%i')/60+$timelapse->format('%h'))*$scan['Scan']['billing_rate'];
                            }
                            else if($workOrder['WorkOrder']['billing_method']==2)//tenths rule
                           {
                                  echo number_format(ceil((($timelapse->format('%i'))/60+$timelapse->format('%h'))*10)/10,1);
                                  //echo number_format(($timelapse->format('%i'))/60+$timelapse->format('%h'),1);
                                  $bill=+ceil(($timelapse->format('%i')/60+$timelapse->format('%h'))*10)*($scan['Scan']['billing_rate']/10);
                           } else if($workOrder['WorkOrder']['billing_method']==3) {
                                echo number_format(ceil((($timelapse->format('%i'))/60+$timelapse->format('%h'))*4)/4,2);
                                  //echo number_format(($timelapse->format('%i'))/60+$timelapse->format('%h'),1);
                                  $bill=+ceil(($timelapse->format('%i')/60+$timelapse->format('%h'))*4)*($scan['Scan']['billing_rate']/4);
                           }
            }else $bill=0; ?>&nbsp;</td>
                <td><?php echo $scan['Scan']['billing_rate']; ?></td>
                <td><?php echo '$'.number_format($bill,2); ?></td>
                <td><?php echo $scan['Scan']['technician_id']; ?></td>
                <td class="actions"> <?php echo $this->Html->link(__('Edit'), array('controller' => 'scans','action' => 'edit', $scan['Scan']['id'],$workOrder['WorkOrder']['id'])); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'scans','action' => 'delete', $scan['Scan']['id'],$workOrder['WorkOrder']['id']), null, __('Are you sure you want to delete # %s?', $scan['Scan']['id'])); ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
        </div>
    </div>

    <?php if($expense_reimbursements): ?>
    <div class="related">
        <h3><?php echo __('Disbursement History'); ?></h3>
        <div class="table-responsive">
        <table class = 'hovertable' cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('Date'); ?></th>
                <th><?php echo __('Description'); ?></th>
                <th><?php echo __('Amount'); ?></th>
            </tr>

            <?php for($i = 1; $i <= count($expense_reimbursements); $i++): ?>
            <tr>
                <td><?php
                    $format = 'Y-m-d';
                    $date1 = DateTime::createFromFormat($format, $expense_reimbursement_dates["date_".$i]);
                    echo $date1->format('m-d-Y'); ?></td>
                <td><?php echo $expense_reimbursement_types["type_".$i]; ?></td>
                <td><?php echo '$'.number_format($expense_reimbursements["expense_".$i],2); ?></td>
            </tr>
            <?php endfor; ?>

        </table>
        </div>
    </div>
    <?php endif; ?>

    <div class="related">
        <h3><?php echo __('Totals'); ?></h3>
        <div class="table-responsive">
        <table id="totals_table" class = 'hovertable' cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('File No'); ?></th>
                <th><?php echo __('Start Date'); ?></th>
                <th><?php echo __('End Date'); ?></th>
                <th><?php echo __('Total Hours'); ?></th>
                <th><?php echo __('Remaining Retainer'); ?></th>
                <th><?php echo __('Remaining Disbursement'); ?></th>
                <th><?php echo __('Advanced Hours'); ?></th>
                <th><?php echo __('Total Bill'); ?></th>
            </tr>

            <tr>
                <td><?php echo $workOrder['WorkOrder']['file_no']; ?></td>
                <td><?php if($startDate!='0000-00-00 00:00:00'){
                $format = 'Y-m-d H:i:s';
                $date1 = DateTime::createFromFormat($format, h($startDate));
                echo $date1->format('m-d-Y');} ?>&nbsp;</td>
                <td><?php if($endDate!='0000-00-00 00:00:00'){
                $format = 'Y-m-d H:i:s';
                $date1 = DateTime::createFromFormat($format, h($endDate));
                echo $date1->format('m-d-Y');} ?>&nbsp;</td>
                <td><?php echo $this->Number->precision($totalHours,3); ?></td>
                <td><?php echo '$'.number_format($remainingRetainer,2); ?></td>
                <td><?php echo '$'.number_format($remainingDisbursement,2); ?></td>
                <td><?php echo $workOrder['WorkOrder']['advanced_hours'];?></td>
                <td><?php echo '$'.number_format($totalBill,2); ?></td>
            </tr>

        </table>
        </div>
    </div>

    <h1 id="totalBill" style="visibility:hidden;float:right;font-size:200%;"></h1>

</div>

    <script type="text/javascript">
    var pieChart;
    $(function () {
        $('#pie').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
    title: {
        text: 'Activity Distribution'
        },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'

    },
    plotOptions: {
        pie: {
        //size:250,
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
        enabled: true,
        color: '#000000',
        connectorColor: '#000000',
        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
}
}
},
series: [{
    type: 'pie',
    name: 'Share of hours',
    data: [
    <?php
    foreach ($typesArray as $key => $val){
    echo "[name ='".$val."',y=".$percentagesArray[$key]."],";
    }
?>
]
}]
});
});

function printDiv(divName) {

    var letterhead = document.getElementById("letterHead");
    letterHead.style.display = "block";

    var originalContents = document.body.innerHTML;

    //hide actions and username columns
    $('#scans_table td:nth-child(8)').hide();
    $('#scans_table td:nth-child(9)').hide();
    $('#scans_table th:nth-child(8)').hide();
    $('#scans_table th:nth-child(9)').hide();
    $('#add_div').hide();

    //iterate through each table row
    $('#scans_table tr').each(function(index, tr) {
        //iterate through each table data by row
        var lines = $('td', tr).map(function(index, td) {
            //return each table data element
            return $(td);
        });
        // regular expression for date format 00-00-0000 00:00:00 AM
        var regx = /(\d{2})-(\d{2})-(\d{4}) (\d{1,2}):(\d{2}):(\d{2}) (\w{2})/;

        if(lines[0]){
            //execute regular expression on date and extract values into array
            var startDateArray = regx.exec(lines[0].text());
            lines[0].html(startDateArray[1]+'-'+startDateArray[2]+'-'+startDateArray[3]);
        }
        if(lines[1]) {
            //execute regular expression on date and extract values into array
            var endDateArray = regx.exec(lines[1].text());
            lines[1].html(endDateArray[1]+'-'+endDateArray[2]+'-'+endDateArray[3]);
        }
    });

    totalBill = $('#totals_table tr:nth-child(2) td:nth-child(8)').text();

    $('#totalBill').html('Total Bill: ' + totalBill);
    $('#totalBill').css('visibility', 'visible');

    var printContents = document.getElementById(divName).innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
    letterHead.style.display = "none";
}

</script>

                     <script>
                     $(function(){
                         $.datepicker.setDefaults(
                             $.extend($.datepicker.regional[''])
                         );
                         $('#datepicker').datepicker({
                         changeMonth: true,
                         changeYear: true,
                         minDate: '-1y', // The min date that can be selected, i.e. 30 days from the 'now'
                         maxDate: '+0d', // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'

                         });
                     });
                     </script>
                     <script>
                     $(function(){
                         $.datepicker.setDefaults(
                             $.extend($.datepicker.regional[''])
                         );
                         $('#datepicker1').datepicker({
                         changeMonth: true,
                         changeYear: true,
                         minDate: '-1y', // The min date that can be selected, i.e. 30 days from the 'now'
                         maxDate: '+0d', // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
                         });
                     });
                     $('#submit_btn').click(function(e) {
                         e.preventDefault();
                         window.location = "<?php echo Router::url(null, true); ?>?date1="+$("#datepicker").val()+"&date2="+$("#datepicker1").val();
                         });
                     </script>
