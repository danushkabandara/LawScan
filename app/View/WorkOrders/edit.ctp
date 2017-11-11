<?php echo $this->Html->script('jquery-ui-1.10.3.custom.min'); ?>
<?php echo $this->Html->script('jquery-ui-1.10.3.custom'); ?>
<?php echo $this->Html->css('jquery-ui-1.10.3.custom.min'); ?>

<div class="workOrders form">
<?php echo $this->Form->create('WorkOrder'); ?>
	<fieldset>
		<legend><?php echo __('Edit Case'); ?></legend>
	<?php
//	echo $this->Form->input('created_time',array('default' => $created_time));
	   echo $this->Form->input('id');
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
		echo '<div id = "addreimbursementfield">';
		if(!empty($expense_reimbursements)){
            for ($i = 1; $i <=count($expense_reimbursements); $i++) {
                echo $this->Form->input('expense_reimbursements.expense_'.$i,array('default' => $expense_reimbursements['expense_'.$i], 'class'=>'editWorkOrdertxtArea'));
                 echo $this->Form->input('expense_reimbursement_dates.date_'.$i,array('default' => $expense_reimbursement_dates['date_'.$i],'class'=>'editWorkOrdertxtArea'));
                echo $this->Form->input('expense_reimbursement_types.type_'.$i,array('default' => $expense_reimbursement_types['type_'.$i],'class'=>'editWorkOrdertxtArea'));
            }
         }
        echo '</div>';
        echo '<a id ="addreimbursementlink"><span class="glyphicon glyphicon-plus"></span> Add reimbursement</a>';

	    echo '<div id = "addretainerfield">';

		if(!empty($additional_retainers)){
            for ($i = 1; $i <=count($additional_retainers); $i++) {
                echo $this->Form->input('additional_retainers.value_'.$i,array('default' => $additional_retainers['value_'.$i]));
                echo $this->Form->input('additional_retainers_dates.date_'.$i,array('default' => $additional_retainers_dates['date_'.$i]));
            }
         }
        echo '</div>';
        echo '<a id ="addretainerlink"><span class="glyphicon glyphicon-plus"></span> Add retainer</a>';
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

    <script>
$(function(){
    $.datepicker.setDefaults(
        $.extend($.datepicker.regional[''])
    );
    $('#WorkOrderReimbursement1Date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        minDate: '-1y', // The min date that can be selected, i.e. 30 days from the 'now'
        maxDate: '+0d', // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
    });


    $('#WorkOrderReimbursement2Date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        minDate: '-1y', // The min date that can be selected, i.e. 30 days from the 'now'
        maxDate: '+0d', // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
        });
    $('#WorkOrderReimbursement3Date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        minDate: '-1y', // The min date that can be selected, i.e. 30 days from the 'now'
        maxDate: '+0d', // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
        });
    $('#WorkOrderReimbursement4Date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        minDate: '-1y', // The min date that can be selected, i.e. 30 days from the 'now'
        maxDate: '+0d', // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
        });
    $('#WorkOrderReimbursement5Date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        minDate: '-1y', // The min date that can be selected, i.e. 30 days from the 'now'
        maxDate: '+0d', // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
        });


   });


</script>

    <script>
    $(document).ready(function() {

        var MaxInputs       = 30; //maximum input boxes allowed
        var InputsWrapper   = $("#addreimbursementfield"); //Input boxes wrapper ID
        var AddButton       = $("#addreimbursementlink"); //Add button ID

        var x = InputsWrapper.length; //initlal text box count
        var FieldCount=1; //to keep track of text box added

        var MaxInputs1       = 30; //maximum input boxes allowed
        var InputsWrapper1   = $("#addretainerfield"); //Input boxes wrapper ID
        var AddButton1     = $("#addretainerlink"); //Add button ID


        var FieldCount1=1; //to keep track of text box added

        var d = new Date();
        var curr_date = d.getDate();
        var curr_month = d.getMonth() + 1; //Months are zero based
        var curr_year = d.getFullYear();
        var dateString = curr_year + "-" + curr_month + "-" + curr_date;


        $(AddButton).click(function (e)  //on add input button click
        {
            if(x <= MaxInputs) //max input box allowed
            {

                FieldCount++; //text box added increment
                //add input box
                $(InputsWrapper).append('<div><label>Expense '+(<?php if(empty($expense_reimbursements))echo "0"; else{echo count($expense_reimbursements);}?>+x)+'</label><input type="text" name="data[expense_reimbursements][expense_'+(<?php if(empty($expense_reimbursements))echo "0"; else{echo count($expense_reimbursements);}?>+x)+']'+'" id="field_'+ (<?php if(empty($expense_reimbursements))echo "0"; else{echo count($expense_reimbursements);}?>+x) +'" value=""/><!--a href="#" class="removeclass">&times;</a--></div>');
                $(InputsWrapper).append('<div><label>Date '+(<?php if(empty($expense_reimbursements))echo "0"; else{echo count($expense_reimbursements);}?>+x)+'</label><input type="text" name="data[expense_reimbursement_dates][date_'+(<?php if(empty($expense_reimbursements))echo "0"; else{echo count($expense_reimbursements);}?>+x)+']'+'" id="field_'+ (<?php if(empty($expense_reimbursements))echo "0"; else{echo count($expense_reimbursements);}?>+x) +'" value="'+ dateString +'"/><!--a href="#" class="removeclass">&times;</a--></div>');
                $(InputsWrapper).append('<div><label>Type '+(<?php if(empty($expense_reimbursements))echo "0"; else{echo count($expense_reimbursements);}?>+x)+'</label><input type="text" name="data[expense_reimbursement_types][type_'+(<?php if(empty($expense_reimbursements))echo "0"; else{echo count($expense_reimbursements);}?>+x)+']'+'" id="field_'+ (<?php if(empty($expense_reimbursements))echo "0"; else{echo count($expense_reimbursements);}?>+x) +'" value=""/><!--a href="#" class="removeclass">&times;</a--></div>');
                x++; //text box increment
            }
            return false;
        });
        var x1 = InputsWrapper1.length; //initlal text box count
        $(AddButton1).click(function (e)  //on add input button click
        {
            if(x1 <= MaxInputs1) //max input box allowed
            {
                FieldCount1++; //text box added increment
                $(InputsWrapper1).append('<div><label>Retainer '+(<?php if(empty($additional_retainers))echo "0"; else{echo count($additional_retainers);}?>+x1)+'</label><input type="text" name="data[additional_retainers][value_'+(<?php if(empty($additional_retainers))echo "0"; else{echo count($additional_retainers);}?>+x1)+']'+'" id="field_'+ (<?php if(empty($additional_retainers))echo "0"; else{echo count($additional_retainers);}?>+x1) +'" value=""/><!--a href="#" class="removeclass">&times;</a--></div>');
                $(InputsWrapper1).append('<div><label>Date '+(<?php if(empty($additional_retainers))echo "0"; else{echo count($additional_retainers);}?>+x1)+'</label><input type="text" name="data[additional_retainers_dates][date_'+(<?php if(empty($additional_retainers))echo "0"; else{echo count($additional_retainers);}?>+x1)+']'+'" id="field_'+ (<?php if(empty($additional_retainers))echo "0"; else{echo count($additional_retainers);}?>+x1) +'" value="'+ dateString +'"/><!--a href="#" class="removeclass">&times;</a--></div>');
                x1++; //text box increment
            }
        return false;
    });


    $("body").on("click",".removeclass", function(e){ //user click on remove text
        if( x > 1 ) {
        $(this).parent('div').remove(); //remove text box
        x--; //decrement textbox
        }
    return false;
    })

    });
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