<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	 Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link		  http://cakephp.org CakePHP(tm) Project
 * @package	   Cake.View.Emails.html
 * @since		 CakePHP(tm) v 0.10.0.1076
 * @license	   MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<table style="width: 700px;margin: 0 auto;
	   text-align: center;">
	<tr>
		<td style="padding-top:20px;"></td>
	</tr>
	<tr>
		<td style="padding: 27px 0 15px 0;color: #999999;font-size: 26px;"><?php echo __('Password Reset', true) ?> </td>
	</tr>
	<tr>
		<td style="color: #fe852c;
			font-size: 18px;
			padding-bottom: 30px;
			">
				<?php echo $username . ' ' . __('Your new password is', true) . ' ' . '<i style="color:#000;">' . $var_comodin . '</i>'; ?>
		</td>
	</tr>
</table>