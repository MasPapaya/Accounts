<?php
$this->Html->css(array(
	'/' . strtolower($this->plugin) . '/css/jquery_ui.min',
	'/' . strtolower($this->plugin) . '/css/jquery-ui-timepicker'
),null, array('inline' => false));

$this->Html->script(array(
	'http://www.google.com/recaptcha/api/js/recaptcha_ajax.js',
	'/' . strtolower($this->plugin) . '/js/jquery_ui.min',
	'/' . strtolower($this->plugin) . '/js/jquery-ui-timepicker',
	'/' . strtolower($this->plugin) . '/js/admin_acc'
		), array('inline' => false));
?>
<div class="span12">
	<div class="well">
		<div>
			<h2><?php echo 'To continue your registration on our website:'; ?></h2>	
			<h3><?php echo 'the following information is required'; ?></h3>
		</div>
	</div>
	<div class="form-complete">

		<h3><?php echo __('Your Account Data:'); ?></h3>

		<?php
		echo $this->Form->create('Profile', array('id' => 'comp_inf', 'url' => array('controller' => 'users', 'action' => 'complete_information')));
		echo $this->Form->input('User.username', array('required' => 'required'));
		echo $this->Form->input('User.password', array('required' => 'required'));
		echo $this->Form->input('User.password_2', array('label' => __('Repeat Password'), 'type' => 'password', 'required' => 'required'));

		if ($this->request->data['AlternateLogin']['social_network_id'] == 3) {
			echo $this->Form->input('User.email', array('required' => 'required'));
		} else {
			echo $this->Form->input('User.email', array('required' => 'required', 'readonly' => 'readonly'));
		}
		?>
		</br>
		<h3><?php echo __('Your Profile Data:'); ?></h3>

		<?php
		echo $this->Form->input('first_name', array('required' => 'required'));
		echo $this->Form->input('last_name', array('required' => 'required'));
		echo $this->Form->input('Profile.docid', array('type' => 'text', 'required' => 'required'));
		echo __('Gender </br>');
		echo $this->Form->radio('gender', array('male' => 'Male', 'female' => 'Female'), array('legend' => false));
		echo $this->Form->input('birthday', array('type' => 'text', 'class' => 'date'));
		echo $this->Form->input('address', array('type' => 'text', 'required' => 'required'));
		echo $this->Form->input('mobile', array('type' => 'text', 'required' => 'required'));
		echo $this->Form->input('phone', array('type' => 'text'));

		echo $this->Locations->input('Profile', $locations);
		?>
		</br>

		<?php
		echo $this->Form->input('AlternateLogin.uid', array('type' => 'hidden', 'label' => false));
		echo $this->Form->input('AlternateLogin.user_id', array('type' => 'hidden', 'label' => false));
		echo $this->Form->input('AlternateLogin.social_network_id', array('type' => 'hidden', 'label' => false));
		?>

		<div id="captcha">

		</div>
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
		<hr class="featurette-divider" />

		<div style="text-align: left;  font-family: arial; font-size: 12px;">
			<?php echo $this->Form->input('User.accept_terms', array('label' => $this->Html->link(__('Accept the terms and conditions of use'), array('plugin' => 'accounts', 'controller' => 'pages', 'action' => 'terms'), array('target' => 'blank')), 'type' => 'checkbox', 'style' => 'float:left;margin-right:5px', 'div' => array('class' => 'checkbox_null'))); ?>
		</div>
		<div style="text-align: center;">
			<?php
			echo $this->Form->end(array('label' => __('Complete information'), 'class' => 'btn-success'));
			?>	
		</div>
	</div>
</div>
<script type="text/javascript">
<?php
if (Configure::check('Accounts.recaptcha.Publickey') && Configure::check('Accounts.recaptcha.PrivateKey')) {
	echo 'var Publickey = "' . Configure::read('Accounts.recaptcha.Publickey') . '";';
	echo 'var PrivateKey = "' . Configure::read('Accounts.recaptcha.PrivateKey') . '";';
}
?>
	Recaptcha.create(Publickey, "captcha", {theme: "white", callback: Recaptcha.focus_response_field, lang: 'es'});
<?php if (isset($message_controller)): ?>
		alert('<?php echo $message_controller ?>');
		document.location.href = '<?php echo $this->Html->url(array('controller' => 'pages', 'action' => 'index')) ?>';
<?php endif; ?>
<?php if (isset($redirect) && $redirect): ?>
		//		setTimeout("",3500);
<?php endif; ?>
</script>

