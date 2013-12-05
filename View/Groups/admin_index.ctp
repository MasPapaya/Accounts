<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link('<i class="icon-plus-sign"></i>&nbsp;' . __('New Group'), array('action' => 'add', 'admin' => true), array('escape' => FALSE)); ?></li>
		</ul>		
	</div>
</div>

<div class="span8">
	<h2><?php echo __('Groups'); ?></h2>
	<table class="table table-striped table-bordered table-condensed">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($groups as $group): ?>
				<tr>
					<td><?php echo h($group['Group']['id']); ?>&nbsp;</td>
					<td><?php echo h($group['Group']['name']); ?>&nbsp;</td>
					<td>
						<div class="btn-group">
							<?php echo $this->Html->link('<i class="icon-pencil"></i>', array('action' => 'edit', $group['Group']['id']), array('escape' => FALSE, 'class' => 'btn')) ?>							
							<?php echo $this->Html->link('<i class="icon-eye-open"></i>', array('action' => 'view', $group['Group']['id']), array('escape' => FALSE, 'class' => 'btn')) ?>							
							<?php
							echo $this->Form->postLink('<i class="icon-trash icon-white"></i>', array('action' => 'delete', $group['Group']['id']), array('class' => 'btn btn-danger', 'escape' => FALSE), __('Are you sure you want to delete # %s?', $group['Group']['name']));							
							?>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="pagination pagination-centered">
		<p>
			<?php
			echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
			?>
		</p>
		<ul>
			<?php echo $this->Paginator->prev('<', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
			<?php echo $this->Paginator->numbers(array('tag' => 'li', 'separator' => '', 'currentTag' => 'a', 'currentClass' => 'active')); ?>
			<?php echo $this->Paginator->next('>', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
		</ul>
	</div>
</div>
