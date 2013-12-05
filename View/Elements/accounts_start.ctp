<?php if (isset($authuser['id'])): ?>
	<ul class="nav pull-right">
		<li id="fat-menu" class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="icon-user"></i> <?php echo $authuser['username'] ?>
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
				<li><?php echo $this->Html->link(__('Sign Out'), array('controller' => 'Users', 'action' => 'logout', 'admin' => TRUE, 'plugin' => 'accounts')); ?></li>
			</ul>
		</li>
	</ul>
<?php endif; ?>