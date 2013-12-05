<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Ajs->link('<i class="icon-list"></i>&nbsp;' . __('List Social Networks'), array('action' => 'index'), '', '#primary-ajax'); ?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<h2><?php echo __('Social Network'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($socialNetwork['SocialNetwork']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($socialNetwork['SocialNetwork']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

