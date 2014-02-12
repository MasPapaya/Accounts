<div class="users">
	<?php echo $this->Html->link('<i class="glyphicon glyphicon-plus-sign icon-white"></i>&nbsp;' . __d('accounts', 'New User'), array('action' => 'add', 'admin' => true), array('class' => 'btn btn-primary', 'escape' => FALSE)); ?>
	<div class="title_form">
		<h2><?php echo __d('accounts', 'Users'); ?></h2>
		<?php
		echo $this->Form->create('User', array('action' => 'search', 'class' => 'form-inline'));
		echo '<div class="form-group">';
		echo $this->Form->input('search', array('label' => false, 'div' => false, 'class' => 'form-control', 'placeholder' => __('Search', true)));
		echo '</div>';
		echo $this->Form->button('<i class="glyphicon glyphicon-search"></i>', array('label' => false, 'div' => false, 'class' => 'btn btn-default'));
		echo $this->Form->end();
		?>
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
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span>', array('action' => 'edit', $user['User']['id']), array('escape' => FALSE, 'class' => 'btn btn-default')) ?>														
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>', array('action' => 'view', $user['User']['id']), array('escape' => FALSE, 'class' => 'btn btn-default')) ?>							
							<?php if (Configure::read('Accounts.register.data') == 'both' || Configure::read('Accounts.register.data') == 'profile'): ?>
								<?php echo $this->Html->link('<i class="glyphicon glyphicon-edit"></i>', array('plugin' => 'accounts', 'controller' => 'Users', 'action' => 'myprofileedit', 'admin' => false), array('escape' => FALSE, 'class' => 'btn-default btn')) ?>
							<?php endif; ?>
							<?php if (Configure::read('Accounts.register.data') == 'both' || Configure::read('Accounts.register.data') == 'attributes'): ?>
								<?php if (CakePlugin::loaded('Attributes')): ?>
									<?php echo $this->Html->link('<span class="glyphicon glyphicon-th-large"></span>', array('plugin' => 'attributes', 'controller' => 'Attributes', 'action' => 'edit', $user['User']['id'], 'user', 'accounts', 'Users', 'index', true, 'admin' => false), array('escape' => FALSE, 'class' => 'btn btn-default ')) ?>
								<?php endif; ?>
							<?php endif; ?>
							<?php
							echo $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span>', array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-danger', 'escape' => FALSE), __('Are you sure you want to delete # %s?', $user['User']['username']));
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
				)
			);
			?>
		</p>
		<div class="pagination-centered">
			<ul  class="pagination ">
				<?php echo $this->Paginator->prev('<', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
				<?php echo $this->Paginator->numbers(array('tag' => 'li', 'separator' => '', 'currentTag' => 'a', 'currentClass' => 'active')); ?>
				<?php echo $this->Paginator->next('>', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
			</ul>
		</div>
	</div>
</div>
