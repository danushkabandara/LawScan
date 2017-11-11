<div class="row">
	<h2>Current Billing Period</h2>
	<table id="scansTable" class="hovertable">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('WorkOrder.client_name', 'Client Name');?></th>
				<th><?php echo $this->Paginator->sort('start_time','Start Date'); ?></th>
				<th><?php echo $this->Paginator->sort('end_time','End Date'); ?></th>
				<th><?php echo $this->Paginator->sort('Activity.name','Activity'); ?></th>
				<th><?php echo $this->Paginator->sort('description'); ?></th>
				<th><?php echo __('Hours worked'); ?></th>
				<th><?php echo $this->Paginator->sort('billing_rate'); ?></th>
				<th class="username_col"><?php echo $this->Paginator->sort('technician_id','Username'); ?></th>
				<th class="actions_col"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($scans as $scan):?>
			<tr>
				<td><?php echo $scan['WorkOrder']['client_name'];?></td>
				<td><?php if($scan['Scan']['start_time']!='0000-00-00 00:00:00'){
				$format = 'Y-m-d H:i:s';
				$date = DateTime::createFromFormat($format, h($scan['Scan']['start_time']));
				echo $date->format('m-d-Y g:i:s A');} ?>&nbsp;</td>
				<td><?php if($scan['Scan']['end_time']!='0000-00-00 00:00:00'){
				$format = 'Y-m-d H:i:s';
				$date = DateTime::createFromFormat($format, h($scan['Scan']['end_time']));
				echo $date->format('m-d-Y g:i:s A');} ?>&nbsp;</td>
				<td><?php echo $scan['Activity']['name'];?></td>
				<td><?php echo $scan['Scan']['description']; ?></td>
				<td></td>
				<td><?php echo $scan['Scan']['billing_rate']; ?></td>
				<td><?php echo $scan['Scan']['technician_id']; ?></td>
				<td class="actions">
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
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
		//$('#scansTable').dynatable();
	});
</script>