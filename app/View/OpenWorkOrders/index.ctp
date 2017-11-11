<!--<div class="workOrders index">-->
<div class="workOrders">

    <h2><?php echo __('Open Cases'); ?></h2>
    <table class="hovertable" cellpadding="0" cellspacing="0">
        <tr>

            <th><?php echo $this->Paginator->sort('vin'); ?></th>
            <th><?php echo $this->Paginator->sort('order_no'); ?></th>
            <th><?php echo $this->Paginator->sort('description'); ?></th>
            <th><?php echo $this->Paginator->sort('estimated_hours'); ?></th>
            <th><?php echo $this->Paginator->sort('start_time'); ?></th>
            <th><?php echo $this->Paginator->sort('completed_hours'); ?></th>
            <th><?php echo "Percent Completed"; ?></th>
            <th><?php echo $this->Paginator->sort('technician_id'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
    <?php foreach ($workOrders as $workOrder): ?>
    <?php if ($workOrder['WorkOrder']['completion_time']==NULL): ?>
        <tr>

            <td><?php echo h($workOrder['WorkOrder']['vin']); ?>&nbsp;</td>
            <td><?php echo h($workOrder['WorkOrder']['order_no']); ?>&nbsp;</td>
            <td><?php echo h($workOrder['WorkOrder']['description']); ?>&nbsp;</td>
            <td><?php echo h($workOrder['WorkOrder']['estimated_hours']); ?>&nbsp;</td>
            <td><?php
                 if(isset($workOrder['WorkOrder']['start_time'])){
            $format = 'Y-m-d H:i:s';
            $date = DateTime::createFromFormat($format, h($workOrder['WorkOrder']['start_time']));
            echo $date->format('Y-m-d');} ?>&nbsp;</td>
            <td><?php echo h($workOrder['WorkOrder']['completed_hours']); ?>&nbsp;</td>
            <td> <?php if ($workOrder['WorkOrder']['estimated_hours']!=0){echo h(ceil($workOrder['WorkOrder']['completed_hours']*100/$workOrder['WorkOrder']['estimated_hours']));echo " %";}else echo "0%"; ?></td>
            <td><?php echo h($workOrder['WorkOrder']['technician_id']); ?>&nbsp;</td>
            <td class="actions">
            <?php echo $this->Html->link(__('QR Code'), array('controller'=>'workOrders','action' => 'view', $workOrder['WorkOrder']['id'])); ?>
            <?php echo $this->Html->link(__('Edit'), array('controller'=>'workOrders','action' => 'edit', $workOrder['WorkOrder']['id'])); ?>
            <?php echo $this->Form->postLink(__('Delete'), array('controller'=>'workOrders','action' => 'delete', $workOrder['WorkOrder']['id']), null, __('Are you sure you want to delete # %s?', $workOrder['WorkOrder']['id'])); ?>
            <?php echo $this->Form->postLink(__('Close'), array('controller' => 'work_orders','action' => 'close', $workOrder['WorkOrder']['id']), null, __('Are you sure you want to close # %s?', $workOrder['WorkOrder']['id'])); ?>
            </td>
        </tr>
    <?php endif; ?>
    <?php endforeach; ?>
    </table>



</div>




<!--div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Case'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Clients'), array('controller' => 'technicians', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client'), array('controller' => 'technicians', 'action' => 'add')); ?> </li>
	</ul>
</div-->
