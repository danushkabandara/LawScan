<div class="users form" style="width: 100%;float: left;margin-left: 0;background:#8e8e8e;">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('Technician');?>
    <fieldset>
        <legend><?php echo __('Please enter your username and password'); ?></legend>

            <?php
                echo $this->Form->input('username', array('label'=>'<h style="color:#fff">USERNAME</h>'));
                echo $this->Form->input('password', array('label'=>'<h style="color:#fff">PASSWORD</h>'));

            ?>

    </fieldset>
<?php echo $this->Form->end(__('Login'));?>
</div>
