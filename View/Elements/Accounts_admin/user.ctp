<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<ul class="nav">
	<li class="dropdown"></li>
	<li><?php echo $this->Html->link('<i class="icon-home"></i>&nbsp;' . __('Home'), array('plugin' => 'accounts', 'controller' => 'pages', 'action' => 'home'), array('escape' => false)); ?></li>
</ul>