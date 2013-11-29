<div class="border">
	<?php echo $this->Form->create('User'); ?>
	<fieldset class="">
		<legend><?php echo __('User Data'); ?></legend>
		<?php
		echo $this->Form->input('id');
		echo $this->Form->input('email');
		echo $this->Form->input('username',array('DISABLED'=>'DISABLED'));
		echo $this->Form->input('password');
		echo $this->Form->input('password_2', array('label' => __('Repeat Password'), 'type' => 'password'));
		?>
	</fieldset>
			
	<div>
		<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-primary')); ?>
	</div>
	<?php echo $this->Form->end(); ?>
	<?php // echo $this->element('sql_dump'); ?>
</div>