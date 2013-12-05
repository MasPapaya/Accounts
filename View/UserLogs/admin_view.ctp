<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><h3><?php echo __('Actions'); ?></h3></li>
			<li><?php echo $this->Ajs->link('<i class="icon-list"></i>&nbsp;'.__('List User Logs'),array('action'=>'index'),'','#primary-ajax');?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<h2><?php echo __('User Log'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($userLog['UserLog']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($userLog['UserLog']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ip'); ?></dt>
		<dd>
			<?php echo h($userLog['UserLog']['ip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($userLog['UserLog']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

