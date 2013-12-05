<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Ajs->link('<i class="icon-list"></i>&nbsp;'.__('List Social Networks'),array('action'=>'index'),'','#primary-ajax');?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<?php echo $this->Form->create('SocialNetwork'); ?>
	<fieldset>
		<legend><?php echo __('Edit Social Network'); ?></legend>
		<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label'=>__('Submit'),'class'=>'btn btn-primary')); ?>
</div>

