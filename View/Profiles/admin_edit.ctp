<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><h3><?php echo __('Actions'); ?></h3></li>
			<li><?php echo $this->Ajs->link('<i class="icon-list"></i>' . __('List Profiles'), array('action' => 'index'), '', '#primary-ajax') ?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<?php echo $this->Form->create('Profile'); ?>
	<fieldset>
		<legend><?php echo __('Edit Profile'); ?></legend>
		<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('location_id');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('docid');
		echo $this->Form->input('gender');
		echo $this->Form->input('birthday');
		echo $this->Form->input('address');
		echo $this->Form->input('mobile');
		echo $this->Form->input('phone');
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label' => __('Submit'), 'btn-primary')); ?>
</div>

