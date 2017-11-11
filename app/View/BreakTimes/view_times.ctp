<!-- <div class="workOrders index"> -->
<div class="breakTimes">

<?php echo $this->Html->script('jquery-ui-1.10.3.custom.min'); ?>
<?php echo $this->Html->css('jquery-ui-1.10.3.custom.min'); ?>
	<h2><?php echo __('Break Times'); ?></h2>

        <div style="float:left;width:160px;">From: <input id="datepicker"  type="text" value="<?php echo $chosenDate1; ?>"  /></div>
        <div style="float:left;width:160px;padding-left:10px;">To: <input id="datepicker1"  type="text" value="<?php echo $chosenDate2; ?>"  /></div>
    <div style="float:left;width:100px;padding-top:20px;padding-left:10px;"> <input type="submit" value="Submit" name="Submit" id="submit_btn"style="float:left;"></div>
        <div style="float:left;width:160px;padding-top: 25px;">Total Hours: <?php echo $totalHours; ?> </div>
    <table id="WorkOrdersIndexTable" class="hovertable" cellpadding="0" cellspacing="0">
	<tr>
        <th><?php echo $this->Paginator->sort('technician_id'); ?></th>
			<th><?php echo $this->Paginator->sort('start_time'); ?></th>
			<th><?php echo $this->Paginator->sort('end_time'); ?></th>
        <th><?php echo "Hours"; ?></th>
	</tr>

	<?php foreach ($breakTimes as $breakTime): ?>

	<tr>
        <td><?php echo h($breakTime['BreakTime']['technician_id']); ?>&nbsp;</td>
        <td><?php echo h($breakTime['BreakTime']['start_time']);
        $hours=0;
        if($breakTime['BreakTime']['start_time']!='0000-00-00 00:00:00'){
                $format = 'Y-m-d H:i:s';
                $date1 = DateTime::createFromFormat($format, h($breakTime['BreakTime']['start_time']));}
               
                if($breakTime['BreakTime']['end_time']!='0000-00-00 00:00:00'){
            $format = 'Y-m-d H:i:s';
            $date2 = DateTime::createFromFormat($format, h($breakTime['BreakTime']['end_time']));
            $timelapse = $date1->diff($date2);
            $hours=number_format(($timelapse->format('%i'))/60+$timelapse->format('%h'),2);
            }?>&nbsp;</td>
		<td><?php echo h($breakTime['BreakTime']['end_time']); ?>&nbsp;</td>
        <td><?php echo $hours;?>&nbsp;</td>

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

        });
    });
    </script>
    <script>
    $(function(){
        $.datepicker.setDefaults(
            $.extend($.datepicker.regional[''])
        );
        $('#datepicker1').datepicker({
        changeMonth: true,
        changeYear: true,
        minDate: '-1y', // The min date that can be selected, i.e. 30 days from the 'now'
        maxDate: '+0d', // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
        });
    });
    $('#submit_btn').click(function(e) {
        e.preventDefault();
        window.location = "<?php echo Router::url(null, true); ?>?date1="+$("#datepicker").val()+"&date2="+$("#datepicker1").val();
        });
    </script>



