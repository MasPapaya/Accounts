<div class="cru">
	<div class="btn-options">
		<?php echo $this->Html->link('<i class="icon-list icon-white"></i>&nbsp;' . __('Back to List'), array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary', 'escape' => FALSE)); ?>	
	</div>
	<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('New User'); ?></legend>
		<?php
		echo $this->Form->input('group_id');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('password_2', array('type' => 'password', 'label' => __('Repeat Password')));
//		echo $this->Form->input('fbid');
//		echo $this->Form->input('twid');		
		echo $this->Form->input('email');
		echo $this->Form->input('birthday', array('type' => 'text', 'class' => 'date'));
		echo $this->Form->input('activated', array('type' => 'hidden', 'value' => date('Y-m-d H:i:s')));
		?>
    </fieldset>
	<?php echo $this->Form->end(array('label' => __('Save'), 'class' => 'btn btn-primary')); ?>
</div>
