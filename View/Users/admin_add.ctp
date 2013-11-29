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
		<legend><?php echo __('Admin Add User'); ?></legend>
	<?php
		echo $this->Form->input('group_id');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('password_2',array('type'=>'password','label'=>'Repeat Password'));
//		echo $this->Form->input('fbid');
//		echo $this->Form->input('twid');		
		echo $this->Form->input('email');
		
		echo $this->Form->input('birthday',array('type'=>'text','class'=>'date'));

		echo $this->Form->input('activated',array('type'=>'hidden','value'=>date('Y-m-d H:i:s')));
//		echo $this->Form->input('banned',array('type'=>'hidden','value'=>'1970-01-01 00:00:00'));
		echo $this->Form->input('banned',array('type'=>'hidden','value'=>'1800-01-01 00:00:00'));
//		echo $this->Form->input('deleted',array('type'=>'hidden','value'=>'1970-01-01 00:00:00'));
		echo $this->Form->input('deleted',array('type'=>'hidden','value'=>'1800-01-01 00:00:00'));
				
				
	?>
	</fieldset>
<?php echo $this->Form->end(array('label'=>__('Submit'),'class'=>'btn btn-primary')); ?>
</div>
