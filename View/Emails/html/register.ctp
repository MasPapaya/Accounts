<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	 Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link		  http://cakephp.org CakePHP(tm) Project
 * @package	   app.View.Emails.html
 * @since		 CakePHP(tm) v 0.10.0.1076
 * @license	   MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<h1><?php echo __('Account Activation')?></h1>
<strong><?php echo __('Welcome to');?> Página de Voulet</strong>

<p style="text-align: left; width: 350px; font-family: fantasy">
	<?php echo __('Thank you for registering on our website Voulet');?>	
	<?php echo __('To enjoy our benefits please');?>	
	<?php echo __('To activate your account you must click on the following link');?>	
	<?php echo __('For safety we suggest that you copy the text and paste it in the address bar of the browser');?>	
</p>

<?php  $url =  Router::url(array('plugin'=>'accounts','controller'=>'users','action'=>'activate_account'),true).'/?id='. $user_id.'&cod='.$code; ?>
<a href="<?php echo $url ?>"><?php echo $url ?></a>