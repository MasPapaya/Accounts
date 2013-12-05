<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li><h3><?php echo __('Actions'); ?></h3></li>
			<li><?php echo $this->Ajs->link('<i class="icon-list"></i>'.__('List User Passwords'),array('action'=>'index'),'','#primary-ajax')?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<h2><?php echo __('User Password'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($userPassword['UserPassword']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userPassword['User']['id'], array('controller' => 'users', 'action' => 'view', $userPassword['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($userPassword['UserPassword']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($userPassword['UserPassword']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

