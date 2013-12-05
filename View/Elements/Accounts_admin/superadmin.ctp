<ul class="nav">	
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-black"></i>&nbsp;<?php echo __('Users') ?><b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link('<i class="icon-user"></i>&nbsp;' . __('Users'), array('plugin' => 'accounts', 'controller' => 'Users', 'action' => 'admin_index','admin'=>true), array('escape' => false)); ?></li>	
			<li><?php echo $this->Html->link('<i class="icon-th-large"></i>&nbsp;' . __('Groups'), array('plugin' => 'accounts', 'controller' => 'Groups', 'action' => 'admin_index','admin'=>true), array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="icon-random"></i>&nbsp;' . __('Social Networks'), array('plugin' => 'accounts', 'controller' => 'SocialNetworks', 'action' => 'admin_index','admin'=>true), array('escape' => false)); ?></li>			
			<li><?php echo $this->Html->link('<i class="icon-lock"></i>&nbsp;' . __('User Passwords'), array('plugin' => 'accounts', 'controller' => 'UserPasswords', 'action' => 'admin_index','admin'=>true), array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="icon-ok-sign"></i>&nbsp;' . __('User Logs'), array('plugin' => 'accounts', 'controller' => 'UserLogs', 'action' => 'admin_index','admin'=>true), array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="icon-retweet"></i>&nbsp;' . __('Alterante Login'), array('plugin' => 'accounts', 'controller' => 'AlternateLogins', 'action' => 'admin_index','admin'=>true), array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="icon-headphones"></i>&nbsp;' . __('Profiles'), array('plugin' => 'accounts', 'controller' => 'Profiles', 'action' => 'admin_index','admin'=>true), array('escape' => false)); ?></li>
		</ul>
	</li>
	<li><?php echo $this->Html->link('<i class="icon-globe"></i>&nbsp;' . __('Locations'), array('plugin' => 'accounts', 'controller' => 'Locations', 'action' => 'index','admin'=>false), array('escape' => false)); ?></li>
	<li><?php echo $this->Html->link('<i class="icon-book"></i>&nbsp;' . __('Document Types'), array('plugin' => 'documents', 'controller' => 'DocumentTypes', 'action' => 'admin_index','admin'=>true), array('escape' => false)); ?></li>
	<li><?php echo $this->Html->link('<i class="icon-glass"></i>&nbsp;' . __('Entities'), array('plugin' => 'documents', 'controller' => 'Entities', 'action' => 'admin_index','admin'=>true), array('escape' => false)); ?></li>
	<li><?php echo $this->Html->link('<i class="icon-font"></i>&nbsp;' . __('Languages'), array('controller' => 'Languages', 'action' => 'index'), array('escape' => false)); ?></li>
	<li><?php echo $this->Html->link('<i class="icon-leaf"></i>&nbsp;' . __('Products'), array('controller' => 'Products', 'action' => 'index'), array('escape' => false)); ?></li>
	
   <!--  <li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-bookmark icon-black"></i>&nbsp;<?php echo __('Skill') ?><b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link(__('Skills'), array('controller' => 'Skills', 'action' => 'index', 'admin' => true)); ?></li>
			<li><?php echo $this->Html->link(__('Skill Groups'), array('controller' => 'SkillGroups', 'action' => 'index', 'admin' => true)); ?></li>
			<li><?php echo $this->Html->link(__('Skill Types'), array('controller' => 'SkillTypes', 'action' => 'index', 'admin' => true)); ?></li>
		</ul>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-inbox icon-black"></i>&nbsp;<?php echo __('Company') ?><b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link(__('companies'), array('controller' => 'companies', 'action' => 'index', 'admin' => true), array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link(__('Works'), array('controller' => 'works', 'action' => 'admin_index', 'admin' => true), array('escape' => false)); ?></li>	
			<li><?php echo $this->Html->link(__('Positions'), array('controller' => 'Positions', 'action' => 'index', 'admin' => true), array('escape' => false)); ?></li>	
			<li><?php echo $this->Html->link(__('Industries'), array('controller' => 'Industries', 'action' => 'index', 'admin' => true), array('escape' => false)); ?></li>
			<li class="divider"></li>
			<li><?php echo $this->Html->link(__('Job Types'), array('controller' => 'JobTypes', 'action' => 'index', 'admin' => true)); ?></li>
			<li><?php echo $this->Html->link(__('Manager Groups'), array('controller' => 'ManagerGroups', 'action' => 'index', 'admin' => true)); ?></li>
		</ul>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-wrench icon-black"></i>&nbsp;<?php echo __('System') ?><b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link('<i class="icon-globe"></i>&nbsp;' . __('Languages'), array('controller' => 'Languages', 'action' => 'index', 'admin' => true), array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="icon-map-marker"></i>&nbsp;' . __('Locations'), array('controller' => 'locations', 'action' => 'index', 'admin' => true), array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="icon-file"></i>&nbsp;' . __('Documents'), array('controller' => 'Documents', 'action' => 'pagecontents', 'admin' => true), array('escape' => false)); ?></li>	
			<li class="divider"></li>			
			<li><?php echo $this->Html->link(__('Resource Types'), array('controller' => 'ResourceTypes', 'action' => 'index', 'admin' => true)); ?></li>
			<li><?php echo $this->Html->link(__('Allowed Types'), array('controller' => 'AllowedTypes', 'action' => 'index', 'admin' => true)); ?></li>
			<li><?php echo $this->Html->link(__('Resource Group Types'), array('controller' => 'ResourceGroupTypes', 'action' => 'index', 'admin' => true)); ?></li>
			<li><?php echo $this->Html->link(__('Allowed Resource Types'), array('controller' => 'AllowedResourceTypes', 'action' => 'index', 'admin' => true)); ?></li>
		</ul>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog"></i>&nbsp;<?php echo __('Config'); ?><b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link(__('Groups'), array('controller' => 'groups', 'action' => 'index', 'admin' => true)); ?></li>
			<li><?php echo $this->Html->link(__('Attributes Types'), array('controller' => 'AttributeTypes', 'action' => 'index', 'admin' => true)); ?></li>
			<li><?php echo $this->Html->link(__('Document Types'), array('controller' => 'DocumentTypes', 'action' => 'index', 'admin' => true)); ?></li>
			<li><?php echo $this->Html->link(__('Entities'), array('controller' => 'Entities', 'action' => 'index', 'admin' => true)); ?></li>
			<li><?php echo $this->Html->link(__('Featured Types'), array('controller' => 'FeaturedTypes', 'action' => 'index', 'admin' => true)); ?></li>						
			<li><?php echo $this->Html->link(__('Reference Types'), array('controller' => 'ReferenceTypes', 'action' => 'index', 'admin' => true)); ?></li>
		</ul>
	</li>-->
</ul>