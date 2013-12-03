<div class="remember_password">

	<div class="span4"></div>


	<div class="container-section span4" >
		<?php echo $this->Form->create('User'); ?>
		<fieldset>

			<legend>Recuperar Contraseña</legend>
			<?php
			echo $this->Form->input('username', array('label' => __('Username/Register', true), 'required' => 'required'));
			echo $this->Form->input('email', array('required' => 'required'));
			?>
		</fieldset>
		<?php echo $this->Form->end(array('label' => __('Recover Password'), 'class' => 'btn btn-primary')); ?>
	</div>

	<div class="span4"></div>
</div>



