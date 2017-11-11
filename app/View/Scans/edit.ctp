<div class="scans form">
<?php echo $this->Form->create('Scan'); ?>
	<fieldset>
		<legend><?php echo __('Edit Scan'); ?></legend>
	<?php


		echo  $this->Form->input('id');
		echo $this->Form->input('start_time');
		echo $this->Form->input('end_time');
		echo $this->Form->input('billing_rate');
		echo $this->Form->input('description');
		echo $this->Form->input('activity',array('options'=>Scan::activities()) );
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

