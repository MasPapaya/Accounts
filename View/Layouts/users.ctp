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
 * @package	   Cake.View.Layouts
 * @since		 CakePHP(tm) v 0.10.0.1076
 * @license	   MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
	<head>
		<?php echo $this->Html->charset(); ?>
		<title><?php echo $title_for_layout; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<script type="text/javascript">var base = '<?php echo $this->html->url('/'); ?>';</script>
		<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array('bootstrap.min', 'bootstrap-responsive.min', 'jquery_ui.min', 'jquery-ui-timepicker', 'admin'));
		echo $this->Html->script(array('http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js','jquery-1.9.1.min','jquery_ui.min', 'jquery-ui-timepicker','admin','tiny_mce/tiny_mce','fb_login','bootstrap.min','http://connect.facebook.net/en_ES/all.js'));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		?>

		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>	   

	</head>
	<body style="padding-top: 50px;">
		<div id="fb-root"></div>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<?php
					//echo $this->Html->link('Fotos Son 1000', array('controller' => 'users', 'action' => 'welcome', 'admin' => true), array('update' => '#primary-ajax', 'class' => 'brand'));
					?>
					<span class="form_votes">
						<?php
						// cambiar logo en el admin
//							echo $this->html->link($this->Html->image('mercedes-benz-admin.png'), array('controller' => 'users', 'action' => 'welcome'), array('escape' => false))
						?>
					</span>
					<?php if ($this->Session->read('Auth.User.id') != "") { ?>
						<div class="btn-group pull-right">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="icon-user"></i> <?php echo $this->Session->read('Auth.User.username') ?>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<?php $user_id = $this->Session->read('Auth.User.id'); ?>
								<li><?php echo $this->Html->link(__('Sign Out'), array('controller' => 'users', 'action' => 'logout', 'admin' => true)); ?></li>
								<?php // $redirect_logout=array('plugin'=>'uregister', 'controller'=>'users','action'=>'welcome');?>
								<!--<li><?php // echo $this->Html->link(__('Sign Out'), array('plugin'=>'uregister','controller' => 'users', 'action' => 'logout',$redirect_logout));  ?></li>-->
							</ul>
						</div>
					<?php } ?>
					<?php echo $this->element('menu'); ?>
				</div>
			</div>
		</div>	
		<div class="container-fluid"><div class="row-fluid"><?php echo $this->Session->flash(); ?></div></div>
		<div class="container-fluid">
			<div id="primary-ajax" class="row-fluid">
				<?php echo $this->fetch('content'); ?>

			</div>
			<div class="row-fluid">
				<div class="span12">
					<?php //echo $this->element('sql_dump');	?>
				</div>
			</div>
			<hr />
			<footer>
				<p><?php echo $this->Html->link($this->Html->image('maspapaya.png', array('border' => '0')), 'http://maspapaya.net/', array('target' => '_blank', 'escape' => false)); ?></p>
			</footer>
		</div>
		<?php echo $this->Js->writeBuffer(); ?>
	</body>
</html>