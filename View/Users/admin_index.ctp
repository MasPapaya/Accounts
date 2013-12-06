<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link('<i class="icon-plus-sign"></i>&nbsp;' . __('New User'), array('action' => 'add', 'admin' => true), array('escape' => FALSE)); ?></li>
		</ul>		
	</div>
</div>

<div class="span8">
	<h2><?php echo __('Users'); ?></h2>
    <table class="table table-striped table-bordered table-condensed">
		<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('username'); ?></th>
			<th><?php echo $this->Paginator->sort('group_id'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th><?php echo $this->Paginator->sort('Actions'); ?></th>

		</tr>
		<?php foreach ($users as $user): ?>
			<tr>
				<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
				<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
				<td><?php echo $user['Group']['name']; ?></td>		
				<td><?php echo h($user['User']['email']); ?>&nbsp;</td>		
				<td class="actions">
					<div class="btn-group">
						<?php echo $this->Html->link('<i class="icon-pencil"></i>', array('action' => 'edit', $user['User']['id']), array('escape' => FALSE, 'class' => 'btn')) ?>							
						<?php echo $this->Html->link('<i class="icon-eye-open"></i>', array('action' => 'view', $user['User']['id']), array('escape' => FALSE, 'class' => 'btn')) ?>							
						<?php if (Configure::read('Accounts.register.data') == 'both' || Configure::read('Accounts.register.data') == 'profile'): ?>
							<?php echo $this->Html->link('<i class="icon-edit"></i>', array('plugin' => 'accounts', 'controller' => 'Users', 'action' => 'myprofileedit', 'admin' => false), array('escape' => FALSE, 'class' => 'btn')) ?>
						<?php endif; ?>
						<?php if (Configure::read('Accounts.register.data') == 'both' || Configure::read('Accounts.register.data') == 'attributes'): ?>
							<?php if (CakePlugin::loaded('Attributes')): ?>
								<?php echo $this->Html->link('<i class="icon-th-large"></i>', array('plugin' => 'attributes', 'controller' => 'Attributes', 'action' => 'edit', $user['User']['id'], 'user', 'accounts', 'Users', 'index', true, 'admin' => false), array('escape' => FALSE, 'class' => 'btn')) ?>
							<?php endif; ?>
						<?php endif; ?>
						<?php
						echo $this->Form->postLink('<i class="icon-trash icon-white"></i>', array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-danger', 'escape' => FALSE), __('Are you sure you want to delete # %s?', $user['User']['username']));
						?>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<p>
		<?php
		$this->Paginator->options(array(
			'update' => '#primary-ajax',
			'evalScripts' => true,
			//'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			//'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
			)
		);
		echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
		?>
	</p>
	<div class="pagination pagination-centered">
		<ul>
			<?php echo $this->Paginator->prev('<', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
			<?php echo $this->Paginator->numbers(array('tag' => 'li', 'separator' => '', 'currentTag' => 'a', 'currentClass' => 'active')); ?>
			<?php echo $this->Paginator->next('>', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
		</ul>
	</div>
</div>
