<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
	    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	    </button>
	    <?php echo $this->Html->link($this->Html->image('admin.png', array('border' => '0')), array('controller' => 'Pages', 'action' => 'home', 'admin' => TRUE, 'plugin' => 'accounts'), array('alt' => 'ToPay', 'escape' => false, 'class' => 'brand')); ?>
	    <div class="nav-collapse collapse">	
		<ul class="nav">					
		</ul>
		<?php //echo $this->element('Accounts.accounts_start'); ?>
	    </div>
	</div>
    </div>
</div>