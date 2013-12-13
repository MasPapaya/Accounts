<div class="border">
	<?php echo $this->Form->create('User'); ?>
	<fieldset class="">		
		<?php
		echo $this->Form->input('Profile.id');
		echo $this->Form->input('Profile.first_name');
		echo $this->Form->input('Profile.last_name');

		echo $this->Form->input('User.id');
		echo $this->Form->input('User.email',array('DISABLED' => 'DISABLED'));
		echo $this->Form->input('User.username', array('DISABLED' => 'DISABLED'));
		echo $this->Form->input('User.password');
		echo $this->Form->input('User.password_2', array('label' => __('Repeat Password'), 'type' => 'password'));

		if (Configure::read('Configuration.location.tree')) {			
			echo $this->Locations->input('Profile', $locations);
		} else {
			pr('ola2');
			echo $this->Form->input('Profile.location_id', array('options' => $locations, 'default' => 'empty', 'empty' => 'Seleccione un Pais'));
		}
//		echo $this->Form->input('Profile.address');
//		echo $this->Form->input('Profile.docid_type_id', array('options' => $doctypes, 'default' => 'empty', 'empty' => __('Select Docid Type')));
//		echo $this->Form->input('Profile.docid');
//		echo $this->Form->input('Profile.phone');
//		echo $this->Form->input('Profile.mobile');
//		echo $this->Form->input('Profile.birthday', array('type' => 'text', 'class' => '_date', 'placeholder' => __('yyyy-mm-dd')));
		
		echo $this->Attribute->inputs($attrs);
		?>
	</fieldset>
	<div>
		<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-primary')); ?>
	</div>
	<?php echo $this->Form->end(); ?>
</div>

