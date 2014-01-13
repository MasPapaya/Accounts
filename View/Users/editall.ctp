<div class="border">
	<?php echo $this->Form->create('User'); ?>
	<fieldset class="">		
		<?php
		if (CakePlugin::loaded('Resources') && Configure::read('Accounts.profile.picture') == TRUE) {

			echo "<h3>" . __('User Picture') . "</h3>";			
			if ($this->Session->check('picture')) {
				$pic = $this->Session->read('picture');
				echo $this->Html->image('/files/' . $pic['entity_folder'] . '/' . $pic['filename'], array('alt' => $pic['name'], 'style' => 'width:200px;margin:20px 20px 20px 0;'));
			}
			echo $this->Frame->link('icon-film', 'frame', 'user', $authuser['id']);
		}
		?>		
		<?php
		echo $this->Form->input('Profile.id');
		echo $this->Form->input('Profile.first_name');
		echo $this->Form->input('Profile.last_name');

		echo $this->Form->input('User.id');
		echo $this->Form->input('User.email', array('DISABLED' => 'DISABLED'));
		echo $this->Form->input('User.username', array('DISABLED' => 'DISABLED'));
		echo $this->Form->input('User.password');
		echo $this->Form->input('User.password_2', array('label' => __('Repeat Password'), 'type' => 'password'));

		if (Configure::read('Configuration.location.tree')) {
			echo $this->Locations->input('Profile', $locations);
		} else {
			
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

	<?php
	if (CakePlugin::loaded('Resources')) {
		echo $this->Frame->modal('frame', array('title' => __('Profile Picture')));
		echo $this->Frame->scriptload();
	}
	?>
</div>

