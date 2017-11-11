<div class="workOrders view">
<h2><?php echo __('Work Order'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($workOrder['WorkOrder']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vin'); ?></dt>
		<dd>
			<?php echo h($workOrder['WorkOrder']['vin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Order No'); ?></dt>
		<dd>
			<?php echo h($workOrder['WorkOrder']['order_no']); ?>
			&nbsp;
		</dd>
        <dt><?php echo __('QRCode'); ?></dt>
        <dd>
            <?php echo $this->QrCode->text(h($workOrder['WorkOrder']['order_no'])); ?>
            &nbsp;
        </dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($workOrder['WorkOrder']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estimated Hours'); ?></dt>
		<dd>
			<?php echo h($workOrder['WorkOrder']['estimated_hours']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Technician Id'); ?></dt>
		<dd>
			<?php echo h($workOrder['WorkOrder']['technician_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start Time'); ?></dt>
		<dd>
			<?php echo h($workOrder['WorkOrder']['start_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Completion Time'); ?></dt>
		<dd>
			<?php echo h($workOrder['WorkOrder']['completion_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estimated Completion Time'); ?></dt>
		<dd>
			<?php echo h($workOrder['WorkOrder']['estimated_completion_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Logged Hours'); ?></dt>
		<dd>
			<?php echo h($workOrder['WorkOrder']['completed_hours']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Work Order'), array('action' => 'edit', $workOrder['WorkOrder']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Work Order'), array('action' => 'delete', $workOrder['WorkOrder']['id']), null, __('Are you sure you want to delete # %s?', $workOrder['WorkOrder']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Work Orders'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Work Order'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Technicians'), array('controller' => 'technicians', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Technician'), array('controller' => 'technicians', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Technicians'); ?></h3>
	<?php if (!empty($workOrder['Technician'])): ?>
	<table cellpadding = "0" cellspacing = "0">
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
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Technician'), array('controller' => 'technicians', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
