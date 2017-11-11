<div class="scan add">
	<?php echo $this->Form->create('Scan', array('action'=>'add_manual'));?>
	<?php echo $this->Form->input('work_order_id', array('type'=>'number','default'=>$work_order_id, 'hidden'=>1, 'label'=>false));?>
	<?php echo $this->Form->input('client_name',array('default'=>$client_name, 'disabled'=>true));?>
	<?php echo $this->Form->input('start_time');?>
	<?php echo $this->Form->input('end_time');?>
	<?php echo $this->Form->input('activity',array('options'=>$activities));?>
	<?php echo $this->Form->input('billing_rate',array('type'=>'number','min'=>0,'default'=>$billing_rate));?>
	<?php echo $this->Form->input('description');?>
	<?php echo $this->Form->end('Add');?>
</div>