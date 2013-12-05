<div class="border">
	<?php echo $this->Form->create('User'); ?>
	<fieldset class="">
		<legend><?php echo __('User Profile'); ?></legend>

		<?php
		echo $this->Form->input('Profile.id');

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
	<div>
		<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-primary')); ?>
	</div>
	<?php echo $this->Form->end(); ?>

	<?php // echo $this->element('sql_dump');  ?>
</div>

