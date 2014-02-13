<?php
if (Configure::read('Accounts.social_networks_enabled')) {
	$this->Html->script(
		array(
		'http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js',
		'https://apis.google.com/js/plusone.js',
		'https://apis.google.com/js/client:plusone.js',
		'https://apis.google.com/js/plusone.js?onload=OnLoadCallback',
		'http://connect.facebook.net/en_ES/all.js',
		'Accounts.fb_login',
		), array('inline' => false)
	);
}
?>
<div class="span4"></div>

<div class="normal-login span4">
	<div class="login-form">

		<?php echo $this->Form->create('User', array('class' => 'form')); ?>
		<fieldset>

			<legend><?php echo __('Login') ?></legend>
			<?php
			echo $this->Form->input('username', array('label' => __('User')));
			echo $this->Form->input('password', array('label' => __('Password')));
			?>
		</fieldset>
		<?php echo $this->Form->end(array('label' => __('Sign In', true), 'class' => 'btn btn-primary')); ?>

	</div>

	<div class="register-remember">
		<?php
		if (Configure::read('Accounts.login.forgot.password')) {
			echo $this->Html->link(__('Forgot password?'), array('plugin' => 'accounts', 'controller' => 'Users', 'action' => 'remember'));
		}
		if (Configure::read('Accounts.login.forgot.username')) {
			echo $this->Html->link(__('Forgot username?'), array('plugin' => 'accounts', 'controller' => 'Users', 'action' => 'username'));
		}

		if (Configure::read('Accounts.login.register')) {
			echo $this->Html->link(__('Register'), array('plugin' => 'accounts', 'controller' => 'Users', 'action' => 'register'));
		}
		?>
	</div>
</div>
<div class="span4"></div>

<?php if (Configure::read('Accounts.social_networks_enabled')): ?>
	<div class="social-logins">
		<?php
		echo $this->Form->create(Null, array('id' => 'fbform', 'url' => array('controller' => 'Users', 'action' => 'login_fb'), 'style' => 'heigth:0px;overflow:hidden;margin:0;padding:0;'));
		echo $this->Form->input('User.at', array('type' => 'hidden', 'label' => false));
		echo $this->Form->end();
		?>
		<div class="btn-group">
			<?php
			if (Configure::read('Accounts.social_facebook_enabled')) {
				echo $this->Html->link('Facebook', '#', array('id' => 'fb_login', 'class' => 'btn btn-default'));
			}
			?>
			<?php
			if (Configure::read('Accounts.social_twitter_enabled')) {
				echo $this->Html->link('Twitter', array('controller' => 'Users', 'action' => 'conect_twitter'), array('escape' => false, 'class' => 'btn btn-default'));
			}
			?>
			<?php
			if (Configure::read('Accounts.social_googleplus_enabled')) {
				echo $this->Html->link('Google +', $authURL, array('escape' => false, 'class' => 'btn'));
			}
			?>
		</div>
	</div>
<?php endif; ?>