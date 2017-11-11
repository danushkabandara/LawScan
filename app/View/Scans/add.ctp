<div class="scans form">
<?php echo $this->Form->create('Scan'); ?>
	<fieldset>
		<legend><?php echo __('Add Scan'); ?></legend>
	<?php
		echo $this->Form->input('vin');
		echo $this->Form->input('order_no');
		echo $this->Form->input('description');
		echo $this->Form->input('estimated_hours');
		echo $this->Form->input('start_time');
		echo $this->Form->input('estimated_completion_time');
		echo $this->Form->input('Technician');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Cases'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Clients'), array('controller' => 'technicians', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client'), array('controller' => 'technicians', 'action' => 'add')); ?> </li>
	</ul>
</div>
