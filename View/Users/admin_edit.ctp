<div class="span3">	
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link('<i class="icon-list"></i>&nbsp;' . __('List Users'), array('action' => 'index', 'admin' => true), array('escape' => FALSE)); ?></li>
		</ul>
	</div>
</div>
<div class="span8">
	<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit User'); ?></legend>
		<?php
		echo $this->Form->input('id');
		echo $this->Form->input('group_id');
		echo $this->Form->input('username', array('type' => 'text', 'disabled' => 'disabled'));
		echo $this->Form->input('password', array('required' => false));
		echo $this->Form->input('password_2', array('label'=>__('Repeat Password'),'type'=>'password', 'required' => false));				
//		echo $this->Form->input('fbid', array('type'=>'text','disabled'=>'disabled'));
//		echo $this->Form->input('twid', array('type'=>'text','disabled'=>'disabled'));
		echo $this->Form->input('email', array('type' => 'text', 'disabled' => 'disabled'));
//		echo $this->Form->input('birthday',array('type'=>'hidden','value'=>'1970-01-01'));
//		echo $this->Form->input('activated',array('type'=>'hidden','value'=>'1970-01-01 00:00:00'));
//		echo $this->Form->input('banned',array('type'=>'hidden','value'=>'1970-01-01 00:00:00'));
//		echo $this->Form->input('deleted',array('type'=>'hidden','value'=>'1970-01-01 00:00:00'));
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label' => __('Save changes'), 'class' => 'btn btn-primary')); ?>
</div>

