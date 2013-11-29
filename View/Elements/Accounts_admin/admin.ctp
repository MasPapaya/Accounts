<?php //if (isset($authuser['group_id']) && $authuser['group_id'] == '1'): ?>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i>&nbsp;<?php echo __('Accounts') ?><b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link(__('Groups'), array('controller' => 'Groups', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'accounts')); ?></li>
			<li><?php echo $this->Html->link(__('Users'), array('controller' => 'Users', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'accounts')); ?></li>
			<li><?php echo $this->Html->link(__('Social Networks'), array('controller' => 'SocialNetworks', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'accounts')); ?></li>
		</ul>
	</li>
<?php //endif; ?>