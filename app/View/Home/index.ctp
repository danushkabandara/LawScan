
<div class="workOrders index">

<?php echo $this->Html->script(array('https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'));?>
<?php echo $this->Html->script('highcharts'); ?>
    <div class="row">
        <div class="col-md-12">

            <h2><script type="text/javascript">
            var d = new Date()
            var weekday=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday")
            var monthname=new Array("Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov","Dec")
            document.write(weekday[d.getDay()] + " ")
            document.write(monthname[d.getMonth()] + " ")
            document.write(d.getDate() + ", ")
            document.write(d.getFullYear())
            </script></h2>

        </div>
    </div>

    <?php if(!empty($openScans)): ?>
    <h2>Open Scans</h2>
    <div class="table-responsive">
        <table class="hovertable"  cellpadding="0" cellspacing="0" >
            <tr>
                <th><?php echo $this->Paginator->sort('Attorney'); ?></th>
                <th><?php echo $this->Paginator->sort('file_no'); ?></th>
                <th><?php echo $this->Paginator->sort('client_last_name');?></th>
                <th><?php echo $this->Paginator->sort('start_time'); ?></th>
                <th class="timecard"><?php echo __('Timecard'); ?></th>
            </tr>
            <?php foreach ($openScans as $openScan): ?>
            <?php if($userName==$openScan['Scan']['technician_id']): ?>
            <tr>
                <td><?php echo $openScan['Scan']['technician_id'];?></td>
                <td><?php echo $openScan['Scan']['work_order_id'];?></td>
                <td><?php echo $customerNames[$openScan['Scan']['work_order_id']];?></td>
                <td><?php echo $openScan['Scan']['start_time'];?></td>
                <td class="timecard">
                    <?php echo $this->Form->postLink(__('Stop Time'), array('controller' => 'tech_orders','action' => 'scanOut', $openScan['Scan']['id']), array('data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Punch Out Of A Work Order')); ?>
                </td>
            </tr>
            <?php endif;?>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12" style="padding-left: 0;padding-bottom: 5px;">
            <?php echo $this->Html->link(__('Add Case'), array('controller'=>'work_orders','action' => 'add' ),array('id'=>'AddWorkOrderBtn')); ?>
        </div>
    </div>
    <div class="row">
            <div class="table-responsive">
            <table id="HomeIndexTable" class="hovertable"  cellpadding="0" cellspacing="0" >
                    <tr>
                        <th><?php echo $this->Paginator->sort('client_last_name'); ?></th>
                        <th><?php echo $this->Paginator->sort('client_first_name'); ?></th>
                        <th><?php echo $this->Paginator->sort('file_no'); ?></th>
                        <th><?php echo $this->Paginator->sort('case_no'); ?></th>
                        <th><?php echo $this->Paginator->sort('start_time'); ?></th>
                        <th><?php echo $this->Paginator->sort('nature_of_work'); ?></th>
                        <th><?php echo $this->Paginator->sort('court'); ?></th>
                        <th><?php echo $this->Paginator->sort('advanced_hours'); ?></th>

                        <th class="actions"><?php echo __('Actions'); ?></th>
                        <?php if(empty($openScans)): ?>
                        <th class="timecard"><?php echo __('Timecard'); ?></th>
                        <?php endif; ?>
                    </tr>
                <?php foreach ($workOrders as $workOrder): ?>

                <?php if ($workOrder['WorkOrder']['completion_time']==NULL): ?>
                    <tr onmouseover="this.style.backgroundColor='#BCC6CC';" onmouseout="this.style.backgroundColor='#d4e3e5';">
                        <td><?php echo h($workOrder['WorkOrder']['client_last_name']); ?>&nbsp;</td>
                        <td><?php echo h($workOrder['WorkOrder']['client_first_name']); ?>&nbsp;</td>
                       <td><?php echo '<a id="FileNO" href='.Router::url('/').'work_orders/viewSummary/'.h($workOrder['WorkOrder']['id']).'>'.h($workOrder['WorkOrder']['file_no']).'</a>'; ?>&nbsp;</td>
                        <td><?php echo h($workOrder['WorkOrder']['case_no']); ?>&nbsp;</td>
                        <td><?php
                             if(isset($workOrder['WorkOrder']['start_time'])){
                        $format = 'Y-m-d H:i:s';
                        $date = DateTime::createFromFormat($format, h($workOrder['WorkOrder']['start_time']));
                        echo $date->format('m-d-Y');} ?>&nbsp;</td>
                        <td><?php echo h($workOrder['WorkOrder']['nature_of_work']); ?>&nbsp;</td>
                        <td><?php echo h($workOrder['WorkOrder']['court']); ?>&nbsp;</td>
                        <td><?php echo h($workOrder['WorkOrder']['advanced_hours']); ?>&nbsp;</td>


                        <td class="actions">
                        <?php echo $this->Html->link(__('QR Code'), array('controller' => 'work_orders','action' => 'view', $workOrder['WorkOrder']['id'])); ?>
                        <?php echo $this->Html->link(__('Edit'), array('controller' => 'work_orders','action' => 'edit', $workOrder['WorkOrder']['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'work_orders','action' => 'delete', $workOrder['WorkOrder']['id']), null, __('Are you sure you want to delete # %s?', $workOrder['WorkOrder']['id'])); ?>
                        <?php echo $this->Form->postLink(__('Close'), array('controller' => 'work_orders','action' => 'close', $workOrder['WorkOrder']['id']), null, __('Are you sure you want to close # %s?', $workOrder['WorkOrder']['id'])); ?>
                        </td>
                        <?php if(empty($openScans)): ?>
                        <td class="timecard">
                        <?php echo $this->Html->link(__('Start Time'), array('controller' => 'tech_orders','action' => 'scan', $workOrder['WorkOrder']['id'], AuthComponent::user('username')), array('data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Punch In To A Work Order'));?>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endif; ?>
                <?php endforeach; ?>
             </table>
            </div>
        </div>
</div>

<script type="text/javascript">
$(function(){

$('a:contains("Stop Time")').removeAttr('onclick');

    $('a:contains("Stop Time")').click(function(e){
        e.preventDefault();
        var d = new Date();
        var n = d.getTimezoneOffset();
        var form = $(this).prev();
        url = $(form).attr("action");
        url = url + "/" + n;
        console.log(url);
        $.post(url, function(data) {
            window.location = <?php echo "\"".$this->webroot."\""; ?>+"/home/index/sort:id/direction:desc";
        });

        return false;
    });
});
</script>



