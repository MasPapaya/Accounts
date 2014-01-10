<div class="cru">
	<div class="btn-options">
		<?php echo $this->Html->link('<i class="icon-list icon-white"></i>&nbsp;' . __('Back to List'), array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary', 'escape' => FALSE)); ?>	
	</div>
	<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('User Data'); ?></legend>
		<?php
		echo $this->Form->input('group_id');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('password_2', array('type' => 'password', 'label' => __('Repeat Password')));
//		echo $this->Form->input('fbid');
//		echo $this->Form->input('twid');		
		echo $this->Form->input('email');
		//echo $this->Form->input('birthday', array('type' => 'text', 'class' => 'date'));
		echo $this->Form->input('activated', array('type' => 'hidden', 'value' => date('Y-m-d H:i:s')));
		?>
    </fieldset>
	<fieldset class="user-profile">
		<legend><?php echo __('Profile Data'); ?></legend>

		<?php
		echo $this->Form->input('Profile.first_name');
		echo $this->Form->input('Profile.last_name');
		echo $this->Form->input('Profile.birthday', array('type' => 'text', 'class' => '_date', 'placeholder' => __('yyyy-mm-dd')));
		echo __('Gender') . '<br/>';
		echo $this->Form->input('Profile.gender', array('type' => 'radio', 'options' => array('M' => __('Male'), 'F' => __('Female')), 'legend' => false));
		if (Configure::read('Configuration.location.tree')) {
			echo $this->Locations->input('Profile', $locations);
		} else {
			echo $this->Form->input('Profile.location_id', array('options' => $locations, 'default' => 'empty', 'empty' => 'Seleccione un Pais'));
		}
		echo $this->Form->input('Profile.address');
		echo $this->Form->input('Profile.docid_type_id', array('options' => $doctypes, 'default' => 'empty', 'empty' => __('Select Docid Type')));
		echo $this->Form->input('Profile.docid');
		echo $this->Form->input('Profile.phone');
		echo $this->Form->input('Profile.mobile');
		
		// echo $this->Form->input('birthday');
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label' => __('Save'), 'class' => 'btn btn-primary')); ?>
</div>
