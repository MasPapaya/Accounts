<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><h3><?php echo __('Actions'); ?></h3></li>
			<li><?php echo $this->Ajs->link('<i class="icon-plus-sign"></i>&nbsp;' . __('New User Password'), array('action' => 'add'), '', '#primary-ajax'); ?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<h2><?php echo __('User Passwords'); ?></h2>
	<table class="table table-condensed table-bordered table-striped">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('user_id'); ?></th>
				<th><?php echo $this->Paginator->sort('password'); ?></th>
				<th><?php echo $this->Paginator->sort('created'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($userPasswords as $userPassword): ?>
				<tr>
					<td><?php echo h($userPassword['UserPassword']['id']); ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($userPassword['User']['id'], array('controller' => 'users', 'action' => 'view', $userPassword['User']['id'])); ?>
					</td>
					<td><?php echo h($userPassword['UserPassword']['password']); ?>&nbsp;</td>
					<td><?php echo h($userPassword['UserPassword']['created']); ?>&nbsp;</td>
					<td class="actions">
						<div class="btn-group">
							<?php echo $this->Ajs->button('icon-pencil', array('action' => 'edit', $userPassword['UserPassword']['id']), '', '#primary-ajax') ?>							
							<?php echo $this->Ajs->button('icon-eye-open', array('action' => 'view', $userPassword['UserPassword']['id']), '', '#primary-ajax') ?>							
							<?php
							echo $this->Ajs->delete(
								'<i class="icon-trash icon-white"></i>', array('action' => 'delete', $userPassword['UserPassword']['id']), array('escape' => false, 'class' => 'btn btn-danger'), array('update' => '#primary-ajax', 'confirm' => __('Are you sure you want to delete \" %s \"?', $userPassword['UserPassword']['id']))
							);
							?>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
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
		?>
	</p>
	<div class="pagination pagination-centered">
		<?php echo $this->Ajs->numbers(); ?>
	</div>
</div>

