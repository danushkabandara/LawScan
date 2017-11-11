<!-- <div class="workOrders index"> -->
<div class="breakTimes">

<?php echo $this->Html->script('jquery-ui-1.10.3.custom.min'); ?>
<?php echo $this->Html->css('jquery-ui-1.10.3.custom.min'); ?>
	<h2><?php echo __('Break Times'); ?></h2>
    <input id="datepicker" style="margin-top:7px;margin-right: 7px;height: 20px;width: 120px;float:right;" type="text" value=""  /></div>
	<table id="WorkOrdersIndexTable" class="hovertable" cellpadding="0" cellspacing="0">
	<tr>
        <th><?php echo $this->Paginator->sort('technician_id'); ?></th>
			<th><?php echo $this->Paginator->sort('start_time'); ?></th>
			<th><?php echo $this->Paginator->sort('end_time'); ?></th>

	</tr>

	<?php foreach ($breakTimes as $breakTime): ?>

	<tr>
        <td><?php echo h($breakTime['BreakTime']['technician_id']); ?>&nbsp;</td>
        <td><?php echo h($breakTime['BreakTime']['start_time']); ?>&nbsp;</td>
		<td><?php echo h($breakTime['BreakTime']['end_time']); ?>&nbsp;</td>

	</tr>

<?php endforeach; ?>
	</table>
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

    <script>
$(function(){
    $.datepicker.setDefaults(
        $.extend($.datepicker.regional[''])
    );
    $('#datepicker').datepicker({
        changeMonth: true,
        changeYear: true,
        minDate: '-1y', // The min date that can be selected, i.e. 30 days from the 'now'
        maxDate: '+0d', // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
        onSelect: function(dateText, obj) {
            window.location = "<?php echo Router::url(null, true); ?>?date="+(((obj.selectedMonth+1) < 10) ? ("0" + (obj.selectedMonth+1)) : (obj.selectedMonth+1))+"/"+((obj.selectedDay < 10) ? ("0" + obj.selectedDay) : obj.selectedDay)+"/"+obj.selectedYear;
        },

    });
});
</script>



