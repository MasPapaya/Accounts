<div class="remember_password">
	<h3 class="title-section"><?php echo __('Remember Password', true); ?></h3>
	<hr  class="line"/>
	<div class="container-section">
		<?php
		echo $this->Form->create('User');
		echo $this->Form->input('username',array('label'=>__('Username/Register',true),'required'=>'required'));
		echo $this->Form->input('email',array('required'=>'required'));
		echo $this->Form->end(array('label' => __('Recover Password'), 'class' => 'btn btn-primary'));
		?>
	</div>
</div>



