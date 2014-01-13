<div class="cru">
	<div class="btn-options">
		<?php echo $this->Html->link('<i class="icon-list icon-white"></i>&nbsp;' . __('Back to List'), array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary', 'escape' => FALSE)); ?>	
	</div>
	<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __d('accounts','Edit User'); ?></legend>
		<?php
		echo $this->Form->input('id');
		echo $this->Form->input('group_id');
		echo $this->Form->input('username', array('type' => 'text', 'disabled' => 'disabled'));
		echo $this->Form->input('password', array('required' => false));
		echo $this->Form->input('password_2', array('label' => __d('accounts', 'Repeat Password'), 'type' => 'password', 'required' => false));
		echo $this->Form->input('email', array('type' => 'text', 'disabled' => 'disabled'));
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label' => __('Save'), 'class' => 'btn btn-primary')); ?>
</div>

