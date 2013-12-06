<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link('<i class="icon-list"></i>&nbsp;' . __('List Docid Types'), array('action' => 'index', 'admin' => true), array('escape' => FALSE)); ?></li>
		</ul>		
	</div>
</div>
<div class="span8">
	<?php echo $this->Form->create('DocidType'); ?>
	<fieldset>
		<legend><?php echo __('Add Docid Type'); ?></legend>
		<?php
		echo $this->Form->input('name');
		echo $this->Form->input('alias');
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-primary')); ?>
</div>
