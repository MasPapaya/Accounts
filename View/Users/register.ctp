<?php
$this->Html->script(
	array('http://www.google.com/recaptcha/api/js/recaptcha_ajax.js',
	'/' . strtolower($this->plugin) . '/js/jquery_ui.min',
	'/' . strtolower($this->plugin) . '/js/jquery-ui-timepicker',
	'/' . strtolower($this->plugin) . '/js/admin_acc'
	), array('inline' => false));

$this->Html->css(array(
	'/' . strtolower($this->plugin) . '/css/jquery_ui.min',
	'/' . strtolower($this->plugin) . '/css/jquery-ui-timepicker'
	), null, array('inline' => false));
?>

<div class="border">
	<?php echo $this->Form->create('User'); ?>


	<fieldset class="user-data">
		<legend><?php echo __('User Data'); ?></legend>

		<?php
		echo $this->Form->input('email');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('password_2', array('label' => __('Repeat Password'), 'type' => 'password'));
		?>
	</fieldset>


	<?php if (Configure::check('Accounts.register.data')): ?>

		<?php if (Configure::read('Accounts.register.data') == 'both' || Configure::read('Accounts.register.data') == 'profile'): ?>
			<fieldset class="user-profile">
				<legend><?php echo __('User Profile'); ?></legend>

				<?php
				echo $this->Form->input('Profile.first_name');
				echo $this->Form->input('Profile.last_name');
				echo __('Gender') . '<br/>';
				echo $this->Form->input('Profile.gender', array('type' => 'radio', 'options' => array('M' => __('Male'), 'F' => __('Female')), 'legend' => false));
				if (Configure::read('Configuration.location.tree')) {
					echo $this->Locations->input('Profile', $locations);
				} else {
					echo $this->Form->input('Profile.location_id', array('options' => $locations, 'default' => 'empty', 'empty' => 'Seleccione un Pais'));
				}
				echo $this->Form->input('Profile.address');
				echo $this->Form->input('Profile.docid');
				echo $this->Form->input('Profile.phone');
				echo $this->Form->input('Profile.mobile');
				echo $this->Form->input('Profile.birthday', array('type' => 'text', 'class' => '_date', 'placeholder' => __('yyyy-mm-dd')));
				// echo $this->Form->input('birthday');
				?>
			</fieldset>
		<?php endif; ?>


		<?php if (Configure::read('Accounts.register.data') == 'both' || Configure::read('Accounts.register.data') == 'attributes'): ?>
			<fieldset class="user-attributes">
				<legend><?php echo __('User Attributes'); ?></legend>
				<?php echo $this->Attribute->inputs($attrs); ?>
			</fieldset>
		<?php endif; ?>


	<?php endif; ?>



	<?php if (Configure::check('Accounts.register.captcha') && Configure::read('Accounts.register.captcha') == TRUE): ?>

		<div class="captcha">
			<div id="captcha"></div>
			<strong class="error-message">
				<?php
				if (isset($error_captcha)):
					switch (trim($error_captcha)):
						case 'incorrect-captcha-sol':
							echo __('Word(s) incorrect');
							break;
						case 'invalid-request-cookie':
							echo __('The challenge parameter of the verify script was incorrect.');
							break;
						case 'captcha-timeout':
							echo __('timeout.');
							break;
						case 'invalid-site-private-key':
						case 'recaptcha-not-reachable':
							echo __('ups! have a configuration error.');
							break;
						default:
							echo '';
							break;
					endswitch;
				endif;
				?>
			</strong>
		</div>
	<?php endif; ?>

	<hr class="separator" />
	<div>
		<?php
		if (Configure::check('Accounts.default.termsURL')) {
			echo $this->Form->input('accept_terms', array('label' => $this->Html->link(__('Accept the Terms and Conditions of use'), Configure::read('Accounts.default.termsURL'), array('target' => '_blank')), 'type' => 'checkbox', 'style' => 'float:left;margin-right:5px', 'div' => array('class' => 'checkbox_null')));
		} else {
			echo $this->Form->input('accept_terms', array('label' => __('Accept the Terms and Conditions of use'), 'type' => 'checkbox', 'style' => 'float:left;margin-right:5px', 'div' => array('class' => 'checkbox_null')));
		}
		?>
	</div>
	<div>
		<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-primary')); ?>
	</div>

	<?php echo $this->Form->end(); ?>


	<?php if (Configure::check('Accounts.register.captcha') && Configure::read('Accounts.register.captcha') == TRUE): ?>

		<script type="text/javascript">
	<?php
	if (Configure::check('Accounts.recaptcha.Publickey') && Configure::check('Accounts.recaptcha.PrivateKey')) {
		echo 'var Publickey = "' . Configure::read('Accounts.recaptcha.Publickey') . '";';
		echo 'var PrivateKey = "' . Configure::read('Accounts.recaptcha.PrivateKey') . '";';
	}
	?>
		Recaptcha.create(Publickey, "captcha", {theme: "white", /*callback: Recaptcha.focus_response_field*/lang: 'es'});
	<?php if (isset($message_controller)): ?>
			alert('<?php echo $message_controller ?>');
			document.location.href = '<?php echo $this->Html->url(array('controller' => 'pages', 'action' => 'index')) ?>';
	<?php endif; ?>
	<?php if (isset($redirect) && $redirect): ?>
			//setTimeout("",3500);
	<?php endif; ?>
		</script>
	<?php endif; ?>

	<?php // echo $this->element('sql_dump');  ?>
</div>