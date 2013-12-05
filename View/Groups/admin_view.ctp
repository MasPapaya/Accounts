<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li><h3><?php echo __('Actions'); ?></h3></li>
			<li><?php echo $this->Html->link('<i class="icon-list"></i>' . __('List Groups'), array('action' => 'index'), array('escape' => FALSE)); ?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<h2><?php echo __('Group'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($group['Group']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($group['Group']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>


