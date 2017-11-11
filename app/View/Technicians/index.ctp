<div class="technicians">
        <h2><?php echo __('Clients'); ?></h2>
        <table class="hovertable" cellpadding="0" cellspacing="0" style="width: 60%;margin-left: 20%;">
            <tr>

                <th><?php echo $this->Paginator->sort('first_name'); ?></th>
                <th><?php echo $this->Paginator->sort('last_name'); ?></th>
               <!--<th><?php echo $this->Paginator->sort('phone_number'); ?></th>-->
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
	<?php foreach ($technicians as $technician): ?>
	<tr>

		<td><?php echo h($technician['Technician']['first_name']); ?>&nbsp;</td>
		<td><?php echo h($technician['Technician']['last_name']); ?>&nbsp;</td>
		<!--<td><?php echo h($technician['Technician']['phone_number']); ?>&nbsp;</td>-->
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $technician['Technician']['id'])); ?>

			<!--<?php echo $this->Html->link(__('Orders'), array('controller' => 'openWorkOrders', 'action' => 'view', $technician['Technician']['work_order_id'])); ?>
            <?php echo $this->Html->link(__('History'), array('controller'=>'workOrders','action' => 'view', $technician['Technician']['work_order_id'])); ?>
			-->
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $technician['Technician']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $technician['Technician']['id']), null, __('Are you sure you want to delete # %s?', $technician['Technician']['id'])); ?>
            <?php echo $this->Html->link(__('Download'), array('controller' => 'downloadData', 1,
    '?' => array('building' =>$technician['Technician']['id'] ))); ?>
		</td>
	</tr>
        <?php endforeach; ?>
	</table>
	<div class="actions" style="float:right">
    	<h3><?php echo __('Actions'); ?></h3>
    	<ul>
    		<li><?php echo $this->Html->link(__('New Client'), array('action' => 'add')); ?></li>

    	</ul>
    </div>
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



