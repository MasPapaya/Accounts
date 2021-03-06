<div class="cru">
	<div class="btn-options">
		<?php echo $this->Html->link('<i class="glyphicon glyphicon-list icon-white"></i>&nbsp;' . __('Back to List'), array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary', 'escape' => FALSE)); ?>	
	</div>
	<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __d('accounts', 'User Data'); ?></legend>
		<div class="col-md-3">
			<?php
			echo $this->Form->input('group_id');
			echo $this->Form->input('username');
			echo $this->Form->input('password');
			echo $this->Form->input('password_2', array('type' => 'password', 'label' => __d('accounts', 'Repeat Password')));
			echo $this->Form->input('email');
			echo $this->Form->input('activated', array('type' => 'hidden', 'value' => date('Y-m-d H:i:s')));
			?>
		</div>
    </fieldset>
	<fieldset class="user-profile">
		<legend><?php echo __d('accounts', 'Profile Data'); ?></legend>
		<div class="col-md-3">
			<?php
			echo $this->Form->input('Profile.first_name', array('label' => __d('accounts', 'First Name')));
			echo $this->Form->input('Profile.last_name', array('label' => __d('accounts', 'Last Name')));
			echo $this->Form->input('Profile.birthday', array('type' => 'text', 'class' => '_date', 'placeholder' => __('yyyy-mm-dd')));
			echo __d('accounts', 'Gender') . '<br/>';
			echo $this->Form->input('Profile.gender', array('type' => 'radio', 'options' => array('M' => __('Male'), 'F' => __('Female')), 'legend' => false));
			if (Configure::read('Configuration.location.tree')) {
				echo $this->Locations->input('Profile', $locations);
			} else {
				echo $this->Form->input('Profile.location_id', array('options' => $locations, 'default' => 'empty', 'empty' => 'Seleccione un Pais'));
			}
			echo $this->Form->input('Profile.address');
//		echo $this->Form->input('Profile.docid_type_id', array('label' => __d('accounts', 'Docid Type'), 'options' => $doctypes, 'default' => 'empty', 'empty' => __('Select Docid Type')));
//		echo $this->Form->input('Profile.docid', array('label' => __d('accounts', 'Docid')));
			echo $this->Form->input('Profile.phone');
			echo $this->Form->input('Profile.mobile', array('label' => __d('accounts', 'Mobile')));

			// echo $this->Form->input('birthday');
			?>
		</div>
	</fieldset>
	<?php echo $this->Form->end(array('label' => __('Save'), 'class' => 'btn btn-primary')); ?>
</div>
