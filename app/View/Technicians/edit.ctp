<div class="technicians form">
<?php echo $this->Form->create('Technician'); ?>
	<fieldset>
		<legend><?php echo __('Edit Client'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('phone_number');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Technician.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Technician.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Clients'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Cases'), array('controller' => 'work_orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Case'), array('controller' => 'work_orders', 'action' => 'add')); ?> </li>
	</ul>
</div>
