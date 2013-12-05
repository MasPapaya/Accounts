<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><h3><?php echo __('Actions'); ?></h3></li>
			<li><?php echo $this->Ajs->link('<i class="icon-list"></i>&nbsp;'.__('List Alternate Logins'),array('action'=>'index'),'','#primary-ajax');?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<h2><?php echo __('Alternate Login'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($alternateLogin['AlternateLogin']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($alternateLogin['User']['id'], array('controller' => 'users', 'action' => 'view', $alternateLogin['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Social Network'); ?></dt>
		<dd>
			<?php echo $this->Html->link($alternateLogin['SocialNetwork']['name'], array('controller' => 'social_networks', 'action' => 'view', $alternateLogin['SocialNetwork']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Uid'); ?></dt>
		<dd>
			<?php echo h($alternateLogin['AlternateLogin']['uid']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

