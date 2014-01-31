<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><h3><?php echo __('Actions'); ?></h3></li>
			<li><?php echo $this->Ajs->link('<i class="icon-list"></i>' . __d('accounts','List Profiles'), array('action' => 'index'), '', '#primary-ajax'); ?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<h2><?php echo __d('accounts','Profile'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($profile['Profile']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($profile['User']['id'], array('controller' => 'users', 'action' => 'view', $profile['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php echo $this->Html->link($profile['Location']['name'], array('controller' => 'locations', 'action' => 'view', $profile['Location']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Name'); ?></dt>
		<dd>
			<?php echo h($profile['Profile']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Name'); ?></dt>
		<dd>
			<?php echo h($profile['Profile']['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Docid'); ?></dt>
		<dd>
			<?php echo h($profile['Profile']['docid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gender'); ?></dt>
		<dd>
			<?php echo h($profile['Profile']['gender']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Birthday'); ?></dt>
		<dd>
			<?php echo h($profile['Profile']['birthday']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo h($profile['Profile']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mobile'); ?></dt>
		<dd>
			<?php echo h($profile['Profile']['mobile']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($profile['Profile']['phone']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

