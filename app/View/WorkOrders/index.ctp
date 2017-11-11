<!-- <div class="workOrders index"> -->
<div class="workOrders index">


	<h2><?php echo __('Closed Cases'); ?></h2>
	<div class="table-responsive">
	<table class="hovertable" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Client'); ?></th>
			<th><?php echo $this->Paginator->sort('file_no'); ?></th>
        <th><?php echo $this->Paginator->sort('case_no'); ?></th>
			<th><?php echo $this->Paginator->sort('start_time','Start Date'); ?></th>
        <th><?php echo $this->Paginator->sort('nature_of_work'); ?></th>
			<th><?php echo $this->Paginator->sort('court'); ?></th>
        <th><?php echo $this->Paginator->sort('advanced_hours'); ?></th>
        <th><?php echo $this->Paginator->sort('completion_time','End Date'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($workOrders as $workOrder): ?>
    <?php if ($workOrder['WorkOrder']['completion_time']!=NULL): ?>
	<tr>

        <td><?php echo h($workOrder['WorkOrder']['client_last_name']).', '.h($workOrder['WorkOrder']['client_first_name']); ?>&nbsp;</td>
        <td><?php echo h($workOrder['WorkOrder']['file_no']); ?>&nbsp;</td>
        <td><?php echo h($workOrder['WorkOrder']['case_no']); ?>&nbsp;</td>
        <td><?php
                 if(isset($workOrder['WorkOrder']['start_time'])){
            $format = 'Y-m-d H:i:s';
            $date = DateTime::createFromFormat($format, h($workOrder['WorkOrder']['start_time']));
            echo $date->format('Y-m-d');} ?>&nbsp;</td>
        <td><?php echo h($workOrder['WorkOrder']['nature_of_work']); ?>&nbsp;</td>
        <td><?php echo h($workOrder['WorkOrder']['court']); ?>&nbsp;</td>
        <td><?php echo h($workOrder['WorkOrder']['advanced_hours']); ?>&nbsp;</td>
        <td><?php
                 if(isset($workOrder['WorkOrder']['completion_time'])){
            $format = 'Y-m-d H:i:s';
            $date = DateTime::createFromFormat($format, h($workOrder['WorkOrder']['completion_time']));
            echo $date->format('Y-m-d');} ?>&nbsp;</td>
        <td class="actions">
			<?php echo $this->Html->link(__('QR Code'), array('action' => 'view', $workOrder['WorkOrder']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $workOrder['WorkOrder']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $workOrder['WorkOrder']['id']), null, __('Are you sure you want to delete # %s?', $workOrder['WorkOrder']['id'])); ?>
		</td>
	</tr>
        <?php endif; ?>
<?php endforeach; ?>
	</table>
</div>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>

</div>


