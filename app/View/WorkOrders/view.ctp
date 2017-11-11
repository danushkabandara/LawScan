<div class="workOrders view">

<h2><?php echo __('QR Code'); ?></h2>
	<dl>
		<dt><?php echo __('File No'); ?></dt>
		<dd>
			<?php echo $this->Html->link($workOrder['WorkOrder']['file_no'], array('controller'=>'work_orders', 'action'=>'viewSummary', $workOrder['WorkOrder']['id']),array('style'=>'text-decoration:underline;font-weight:bold;'));?>
			&nbsp;
		</dd>
		<dt><?php echo __('Case No'); ?></dt>
		<dd>
			<?php echo h($workOrder['WorkOrder']['case_no']); ?>
			&nbsp;
		</dd>
        <dt><?php echo __('Court'); ?></dt>
        <dd>
        <?php echo h($workOrder['WorkOrder']['court']); ?>
        &nbsp;
        </dd>

        <dt><?php echo __('QRCode'); ?></dt>

        <dd>
            <div id="printArea" style="width:100px;height:auto">


            <?php echo $this->QrCode->text(h($workOrder['WorkOrder']['file_no']), array('height' => 80)); ?>
                <div style="float:left">
                    <?php echo h( $workOrder['WorkOrder']['client_last_name'].', '.$workOrder['WorkOrder']['client_first_name']); ?>
                </div>

            </div>
            &nbsp; <br><br>

            <button onClick="printDiv('printArea')" > Print </button>
        </dd>



		<dt><?php echo __('Start Date'); ?></dt>
		<dd>
			<?php echo h($workOrder['WorkOrder']['start_time']); ?>
			&nbsp;
		</dd>



	</dl>


<!--<div class="related">
	<h3><?php echo __('Related Client'); ?></h3>
	<?php if (!empty($workOrder['Technician'])): ?>
	<table class = 'hovertable' cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('First Name'); ?></th>
		<th><?php echo __('Last Name'); ?></th>
		<th><?php echo __('Phone Number'); ?></th>

		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($workOrder['Technician'] as $technician): ?>
		<tr>
			<td><?php echo $technician['id']; ?></td>
			<td><?php echo $technician['first_name']; ?></td>
			<td><?php echo $technician['last_name']; ?></td>
			<td><?php echo $technician['phone_number']; ?></td>


			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'technicians', 'action' => 'view', $technician['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'technicians', 'action' => 'edit', $technician['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'technicians', 'action' => 'delete', $technician['id']), null, __('Are you sure you want to delete # %s?', $technician['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>-->







<!--<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
    <li><?php echo $this->Html->link(__('Edit Case'), array('action' => 'edit', $workOrder['WorkOrder']['id'])); ?> </li>
    <li><?php echo $this->Form->postLink(__('Delete Case'), array('action' => 'delete', $workOrder['WorkOrder']['id']), null, __('Are you sure you want to delete # %s?', $workOrder['WorkOrder']['id'])); ?> </li>
    <li><?php echo $this->Html->link(__('List Cases'), array('action' => 'index')); ?> </li>
    <li><?php echo $this->Html->link(__('New Case'), array('action' => 'add')); ?> </li>
    <li><?php echo $this->Html->link(__('List Clients'), array('controller' => 'technicians', 'action' => 'index')); ?> </li>
    <li><?php echo $this->Html->link(__('New Client'), array('controller' => 'technicians', 'action' => 'add')); ?> </li>
    </ul>
</div>-->


<script>
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
    }
</script>