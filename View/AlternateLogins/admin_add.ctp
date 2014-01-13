<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><h3><?php echo __('Actions'); ?></h3></li>
			<li><?php echo $this->Ajs->link('<i class="icon-list"></i>&nbsp;' . __('List Alternate Logins'), array('action' => 'index'), '', '#primary-ajax'); ?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<?php echo $this->Form->create('AlternateLogin'); ?>
	<fieldset>
		<legend><?php echo __d('accounts', 'Add Alternate Login'); ?></legend>
		<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('social_network_id');
		echo $this->Form->input('uid');
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn-primary')); ?>
</div>

