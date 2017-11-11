
<div class="techOrder scan">
	<?php echo $this->Form->create('TechOrder', array('action'=>'scan'));?>
	<?php echo $this->Form->input('work_order_id', array('type'=>'number','default'=>$work_order_id, 'hidden'=>1, 'label'=>false));?>
	<?php echo $this->Form->input('client_name',array('default'=>$client_name, 'disabled'=>true));?>
	<?php echo $this->Form->input('activity',array('options'=>$activities));?>
	<?php echo $this->Form->input('rate',array('type'=>'number','min'=>0,'default'=>$billing_rate));?>
	<?php echo $this->Form->input('offset',array('type'=>'number','default'=>0,'hidden'=>1,'id'=>'offset','label'=>false));?>
	<?php echo $this->Form->end('Scan');?>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		var input = document.getElementById('offset');
		var d = new Date();
      var n = d.getTimezoneOffset();
      console.log(n);
      input.setAttribute('value',n);
	});
</script>