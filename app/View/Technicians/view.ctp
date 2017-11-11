<div class="technicians view">


<h2><?php echo __('Client Summary'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($technician['Technician']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Name'); ?></dt>
		<dd>
			<?php echo h($technician['Technician']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Name'); ?></dt>
		<dd>
			<?php echo h($technician['Technician']['last_name']); ?>
			&nbsp;
		</dd>
		<dt></dt>
		<dd>

			&nbsp;
		</dd>
	</dl>

    <div class="related">
        <h3><?php echo __('Totals'); ?></h3>
        <table class= 'hovertable' cellpadding = "0" cellspacing = "0">
            <tr>

                <th><?php echo __('Orders Completed'); ?></th>
                <th><?php echo __('Estimated Hours'); ?></th>
                <th><?php echo __('Total Hours'); ?></th>

                <th><?php echo __('Hours Differential'); ?></th>
                <th><?php echo __('Percent Differential'); ?></th>
            </tr>
            <tr>
                <td><?php echo $workOrdersCompleted; ?></td>
                <td><?php echo $hoursEstimated;?></td>
                <td><?php echo $hoursTaken;?></td>

                <td><?php if(h(($hoursTaken-$hoursEstimated))<0){echo '<h style="color:green">'.($hoursTaken-$hoursEstimated).'<h>';}else {echo '<h style="color:red">+'.($hoursTaken-$hoursEstimated).'</h>';} ?></td>
                <td><?php if($hoursEstimated != 0) {echo number_format(($hoursTaken-$hoursEstimated)/$hoursEstimated,2,'.',',').'%'; }else echo 0;?></td>
            </tr>

        </table>

    </div>

    <!--<div class="related">
        <h3><?php echo __('Open Work Orders'); ?></h3>
    <?php if (!empty($technician['WorkOrder'])): ?>
        <table class= 'hovertable' cellpadding = "0" cellspacing = "0">
            <tr>

                <th><?php echo __('Vin'); ?></th>
                <th><?php echo __('Order No'); ?></th>
                <th><?php echo __('Description'); ?></th>
                <th><?php echo __('Estimated Hours'); ?></th>
                <th><?php echo __('Start Time'); ?></th>
                <th><?php echo __('Completion Time'); ?></th>
                <th><?php echo __('Logged Hours'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        <?php foreach ($technician['WorkOrder'] as $workOrder): ?>
        <?php if ($workOrder['completion_time']==NULL): ?>
            <tr>

                <td><?php echo $workOrder['vin']; ?></td>
                <td><?php echo $workOrder['order_no']; ?></td>
                <td><?php echo $workOrder['description']; ?></td>
                <td><?php echo $workOrder['estimated_hours']; ?></td>
                <td><?php
            if(isset($workOrder['WorkOrder']['start_time']))
            {$format = 'Y-m-d H:i:s';
            $date = DateTime::createFromFormat($format, h($workOrder['WorkOrder']['start_time']));
            echo $date->format('Y-m-d h:i:s');}
             else echo '0';?>&nbsp;</td>
                <td><?php
            if(isset($workOrder['WorkOrder']['start_time']))
            {$format = 'Y-m-d H:i:s';
            $date = DateTime::createFromFormat($format, h($workOrder['WorkOrder']['completion_time']));
            echo $date->format('Y-m-d h:i:s');}
             else echo '0';?>&nbsp;</td>
                <td><?php echo $workOrder['completed_hours']; ?></td>
                <td class="actions">
                <?php echo $this->Html->link(__('View'), array('controller' => 'work_orders', 'action' => 'view', $workOrder['id'])); ?>
                <?php echo $this->Html->link(__('Edit'), array('controller' => 'work_orders', 'action' => 'edit', $workOrder['id'])); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'work_orders', 'action' => 'delete', $workOrder['id']), null, __('Are you sure you want to delete # %s?', $workOrder['id'])); ?>
                </td>
            </tr>
        <?php endif; ?>
        <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>-->

    <div class="related">
        <h3><?php echo __('Closed Cases'); ?>
        <table class= 'hovertable' cellpadding = "0" cellspacing = "0">
            <tr>
              <th><?php echo __('File No'); ?></th>
                <th><?php echo __('Case No'); ?></th>
                <th><?php echo __('Start Date'); ?></th>
                <th><?php echo __('Court'); ?></th>
                <th><?php echo __('Advanced Hours'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        <?php foreach ($technician['WorkOrder'] as $workOrder): ?>
        <?php if ($workOrder['completion_time']!=NULL): ?>
            <tr>

                <td><?php echo $workOrder['file_no']; ?></td>
                <td><?php echo $workOrder['case_no']; ?></td>
                <td><?php
                 if(isset($workOrder['start_time'])){
            $format = 'Y-m-d H:i:s';
            $date = DateTime::createFromFormat($format, h($workOrder['start_time']));
            echo $date->format('Y-m-d');} ?>&nbsp;</td>
                <td><?php echo $workOrder['court']; ?></td>
                <td><?php echo $workOrder['advanced_hours']; ?></td>



                <td class="actions">
                <?php echo $this->Html->link(__('View'), array('controller' => 'work_orders', 'action' => 'view', $workOrder['id'])); ?>
                <?php echo $this->Html->link(__('Edit'), array('controller' => 'work_orders', 'action' => 'edit', $workOrder['id'])); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'work_orders', 'action' => 'delete', $workOrder['id']), null, __('Are you sure you want to delete # %s?', $workOrder['id'])); ?>
                </td>
            </tr>
        <?php endif; ?>
        <?php endforeach; ?>
        </table>

        </div>


        <div class="related">

        <?php if (!empty($scans)): ?>
            <h3><?php echo __('Scans'); ?></h3>
            <table class= 'hovertable' cellpadding = "0" cellspacing = "0">
                <tr>

                    <th><?php echo __('Work Order Id'); ?></th>
                    <th><?php echo __('Start Time'); ?></th>
                    <th><?php echo __('Completion Time'); ?></th>

                 </tr>
            <?php foreach ($scans as $scan): ?>
                <tr>
                    <td><?php echo $scan['Scan']['work_order_id']; ?></td>
                    <td><?php
            $format = 'Y-m-d H:i:s';
            $date = DateTime::createFromFormat($format, h($scan['Scan']['start_time']));
            echo $date->format('Y-m-d h:i:s'); ?>&nbsp;</td>
                    <td><?php
                    if($scan['Scan']['end_time']!='0000-00-00 00:00:00'){
            $format = 'Y-m-d H:i:s';
            $date = DateTime::createFromFormat($format, h($scan['Scan']['end_time']));
            echo $date->format('Y-m-d h:i:s');} ?>&nbsp;</td>

                    </tr>
            <?php endforeach; ?>
            </table>
        <?php endif; ?>
</div>





</div>

<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
    <li><?php echo $this->Html->link(__('Edit Client'), array('action' => 'edit', $technician['Technician']['id'])); ?> </li>
    <li><?php echo $this->Form->postLink(__('Delete Client'), array('action' => 'delete', $technician['Technician']['id']), null, __('Are you sure you want to delete # %s?', $technician['Technician']['id'])); ?> </li>
    <li><?php echo $this->Html->link(__('List Clients'), array('action' => 'index')); ?> </li>
    <li><?php echo $this->Html->link(__('New Client'), array('action' => 'add')); ?> </li>
 
    </ul>
</div></div>



