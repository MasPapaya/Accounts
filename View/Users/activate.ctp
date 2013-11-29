	  
<div class="activate">
	<h2><?php echo __('Account Activation') ?></h2>
	<p>
		<strong><?php echo __('Welcome'); ?></strong>
		<br />
		<?php
		switch ($status):
		case 1:
		echo __('Your account has been successfully activated.');
		break;
		case 2:
		echo __('Failed to activate the account.');
		break;
		case 3:
		echo __('Your account has been activated, on a previous occasion.');
		break;
		default:
		echo __('Please check the URL and try again');
		break;
		endswitch;
		?>
	</p>
	<?php echo $this->Html->link(__('Login'), array('plugin' => 'accounts', 'controller' => 'users', 'action' => 'login', 'admin' => FALSE), array('class' => 'btn btn-primary')); ?>
</div>
