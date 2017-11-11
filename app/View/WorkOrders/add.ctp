<?php echo $this->Html->script('jquery-ui-1.10.3.custom.min'); ?>
<?php echo $this->Html->script('jquery-ui-1.10.3.custom'); ?>
<?php echo $this->Html->css('jquery-ui-1.10.3.custom.min'); ?>

<div class="workOrders form">
<?php echo $this->Form->create('WorkOrder'); ?>
	<fieldset>
		<legend><?php echo __('Add Case'); ?></legend>

	<?php
	//	echo $this->Form->input('created_time',array('default' => $created_time));
	    echo $this->Form->input('client_first_name');
	    echo $this->Form->input('client_last_name');
	    echo $this->Form->input('address');
		echo $this->Form->input('file_no');
		echo $this->Form->input('case_no');
		echo $this->Form->input('nature_of_work');
		echo $this->Form->input('court');

		echo $this->Form->input('start_time', array('type' => 'text'));
		//echo $this->Form->input('estimated_completion_time');
		//echo $this->Form->input('Technician',array('label' => 'Client'));
		echo $this->Form->input('retainer');
	    echo $this->Form->input('disbursement');
		echo $this->Form->input('billing_rate');
		echo $this->Form->input('billing_method',array('options'=>WorkOrder::billingMethod()) );
		echo $this->Form->input('advanced_hours');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

    <script>
    $(function(){
        $.datepicker.setDefaults(
            $.extend($.datepicker.regional[''])
        );
        $('#WorkOrderStartTime').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        minDate: '-1y', // The min date that can be selected, i.e. 30 days from the 'now'
        maxDate: '+0d', // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
        });
        var myDate = new Date();
        var prettyDate =myDate.getFullYear() + '-' +(myDate.getMonth()+1) + '-' + myDate.getDate();
    $("#WorkOrderStartTime").val(prettyDate);

    });



    </script>

    <script>
    function displayTotal() {
        var sum = 0
        var retainer = document.getElementById('WorkOrderRetainer').value;
        var billingRate = document.getElementById('WorkOrderBillingRate').value;
        var advancedHours = '';
       if(!isNaN(retainer) && !isNaN(billingRate) && billingRate != 0)
            var advancedHours = retainer/billingRate;

        document.getElementById('WorkOrderAdvancedHours').value = advancedHours.toFixed(2);
    }
    $('#WorkOrderRetainer').keyup(displayTotal);
    $('#WorkOrderBillingRate').keyup(displayTotal);
    </script>