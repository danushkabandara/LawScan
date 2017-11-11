
<div class="workOrders index">
	<div class="row">
		<div class="col-md-12">
		<button style="padding:10px;" onclick="goBack()">Back To Search</button>
		<h2>Client Totals</h2>
		<table id="clientTotalsTable" class="hovertable">
			<tr>
				<th><?php echo __('Client Name'); ?></th>
				<th><?php echo __('File No'); ?></th>
				<th><?php echo __('Total Hours'); ?></th>
			</tr>
			<?php foreach ($client_totals as $file=>$total): ?>
				<tr>
					<td><?php echo $total['client'];?></td>
					<td><?php echo $file;?></td>
					<td><?php echo $total['hours'];?></td>
				</tr>
			<?php endforeach;?>
		</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
		<h2>Attorney Totals</h2>
		<table id="userTotalsTable" class="hovertable">
			<tr>
				<th><?php echo __('Attorney'); ?></th>
				<th><?php echo __('Total Hours'); ?></th>
			</tr>
			<?php foreach ($attorney_totals as $user=>$total): ?>
				<tr>
					<td><?php echo $user;?></td>
					<td><?php echo $total['hours'];?></td>
				</tr>
			<?php endforeach;?>
		</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h2>Scans</h2>
			<table id="scansTable" class="hovertable">
				<thead>
					<tr>
						<th><?php echo 'Client Name';?></th>
						<th><?php echo 'File No';?></th>
						<th><?php echo 'Start Date';?></th>
						<th><?php echo 'End Date';?></th>
						<th><?php echo 'Activity';?></th>
						<th><?php echo 'Description';?></th>
						<th><?php echo __('Hours worked'); ?></th>
						<th><?php echo 'Billing Rate';?></th>
						<th class="username_col"><?php echo  'Username';?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($scans as $scan):?>
					<tr>
						<td><?php echo $scan['WorkOrder']['full_name'];?></td>
						<td><?php echo $scan['WorkOrder']['file_no'];?></td>
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
						<td><?php if($scan['Scan']['end_time']!='0000-00-00 00:00:00'){
							$date1 = DateTime::createFromFormat($format, h($scan['Scan']['start_time']));
							$date2 = DateTime::createFromFormat($format, h($scan['Scan']['end_time']));
							$timelapse = $date1->diff($date2);

							if($scan['WorkOrder']['billing_method']==1)//realtime rule
							{
								echo $this->Number->precision(($timelapse->format('%i'))/60+$timelapse->format('%h'),3);
								//echo ceil((($timelapse->format('%i'))/60+$timelapse->format('%h'))*100)/100;
								$bill = ($timelapse->format('%i')/60+$timelapse->format('%h'))*$scan['Scan']['billing_rate'];
							}
							else if($scan['WorkOrder']['billing_method']==2)//tenths rule
							{
								echo number_format(ceil((($timelapse->format('%i'))/60+$timelapse->format('%h'))*10)/10,1);
								//echo number_format(($timelapse->format('%i'))/60+$timelapse->format('%h'),1);
								$bill=+ceil(($timelapse->format('%i')/60+$timelapse->format('%h'))*10)*($scan['Scan']['billing_rate']/10);
							} else if($scan['WorkOrder']['billing_method']==3) {
								echo number_format(ceil((($timelapse->format('%i'))/60+$timelapse->format('%h'))*4)/4,2);
								//echo number_format(($timelapse->format('%i'))/60+$timelapse->format('%h'),1);
								$bill=+ceil(($timelapse->format('%i')/60+$timelapse->format('%h'))*4)*($scan['Scan']['billing_rate']/4);
							}
							}else $bill=0; ?>&nbsp;</td>
						<td><?php echo $scan['Scan']['billing_rate']; ?></td>
						<td><?php echo $scan['Scan']['technician_id']; ?></td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
function goBack() {
    window.history.back();
}
</script>