<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><h3><?php echo __('Actions'); ?></h3></li>
			<li><?php echo $this->Ajs->link('<i class="icon-list"></i>'.__('List User Passwords'),array('action'=>'index'),'','#primary-ajax');?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<?php echo $this->Form->create('UserPassword'); ?>
	<fieldset>
		<legend><?php echo __('Edit User Password'); ?></legend>
		<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('password');
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label'=>__('Submit'),'class'=>'btn-primary')); ?>
</div>

