<?php

?>
<h1><?php echo __('Account Activation'); ?></h1>
<strong><?php echo __('Welcome to');?> Pagina de voulet</strong>

<p style="text-align: left; width: 350px;font-family: fantasy">
	<?php echo __('Thank you for registering on our website Voulet');?>	
	<?php echo __('To enjoy our benefits please');?>	
	<?php echo __('To activate your account you must click on the following link');?>	
	<?php echo __('For safety we suggest that you copy the text and paste it in the address bar of the browser');?>	
	
</p>

<?php  $url =  Router::url(array('plugin'=>'accounts','controller'=>'users','action'=>'activate_account'),true).'/?id='. $user_id.'&cod='.$code; ?>


<a href="<?php echo $url;?>"><?php echo $url;?></a>


<h2><?php echo __('After activating your account, use the following information to access it');?></h2>
<strong><?php echo __('Your login details are:');?></strong>
<p style="text-align: left; width: 350px;font-family: fantasy">
	
<h3><strong>Username:</strong></h3><?php echo $username;?><br>
<h3><strong>Password:</strong></h3><?php echo $password ;?>
</p>