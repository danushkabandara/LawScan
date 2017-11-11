<div class="workOrders view">

    <h2><?php echo __('Case Summary'); ?></h2>
    <dl>
        <dt><?php echo __('File No'); ?></dt>
        <dd>
        <?php echo h($workOrder['WorkOrder']['file_no']); ?>
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
        <dt><?php echo __('Client Id'); ?></dt>
        <dd>
        <?php echo h($workOrder['WorkOrder']['technician_id']); ?>
        &nbsp;
        </dd>

        <dt><?php echo __('Start Date'); ?></dt>
        <dd>
        <?php echo h($workOrder['WorkOrder']['start_datestart_']); ?>
        &nbsp;
        </dd>



    </dl>


    <div class="related">
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
    <?php endif; ?>

        <div class="actions">
            <ul>
                <li><?php echo $this->Html->link(__('New Technician'), array('controller' => 'technicians', 'action' => 'add')); ?> </li>
            </ul>
        </div>
    </div>


    <div class="related">
        <h3><?php echo __('scans'); ?></h3>

        <table class = 'hovertable' cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('Id'); ?></th>
                <th><?php echo __('technician_id'); ?></th>
                <th><?php echo __('start_time'); ?></th>
                <th><?php echo __('end_time'); ?></th>


            </tr>
        <?php foreach ($scans as $scan): ?>
            <tr>
                <td><?php echo $scan['Scan']['id']; ?></td>
                <td><?php echo $scan['Scan']['technician_id']; ?></td>
                <td><?php if($scan['Scan']['start_time']!='0000-00-00 00:00:00'){
                $format = 'Y-m-d H:i:s';
                $date = DateTime::createFromFormat($format, h($scan['Scan']['start_time']));
                echo $date->format('Y-m-d h:i:s');} ?>&nbsp;</td>
                <td><?php
                    if($scan['Scan']['end_time']!='0000-00-00 00:00:00'){
            $format = 'Y-m-d H:i:s';
            $date = DateTime::createFromFormat($format, h($scan['Scan']['end_time']));
            echo $date->format('Y-m-d h:i:s');} ?>&nbsp;</td>

            </tr>
        <?php endforeach; ?>
        </table>



    </div>


</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
    <li><?php echo $this->Html->link(__('Edit Case'), array('action' => 'edit', $workOrder['WorkOrder']['id'])); ?> </li>
    <li><?php echo $this->Form->postLink(__('Delete Case'), array('action' => 'delete', $workOrder['WorkOrder']['id']), null, __('Are you sure you want to delete # %s?', $workOrder['WorkOrder']['id'])); ?> </li>
    <li><?php echo $this->Html->link(__('List Cases'), array('action' => 'index')); ?> </li>
    <li><?php echo $this->Html->link(__('New Case'), array('action' => 'add')); ?> </li>
    <li><?php echo $this->Html->link(__('List Clients'), array('controller' => 'technicians', 'action' => 'index')); ?> </li>
    <li><?php echo $this->Html->link(__('New Client'), array('controller' => 'technicians', 'action' => 'add')); ?> </li>
    </ul>
</div>


    <script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
        }
    </script>