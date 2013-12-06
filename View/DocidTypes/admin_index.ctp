<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link('<i class="icon-plus-sign"></i>&nbsp;' . __('New Docid Type'), array('action' => 'add', 'admin' => true), array('escape' => FALSE)); ?></li>
		</ul>		
	</div>
</div>
<div class="span8">
	<h2><?php echo __('Docid Types'); ?></h2>
	<table class="table table-striped table-bordered table-condensed">
		<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('alias'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
		<?php foreach ($docidTypes as $docidType): ?>
			<tr>
				<td><?php echo h($docidType['DocidType']['id']); ?>&nbsp;</td>
				<td><?php echo h($docidType['DocidType']['name']); ?>&nbsp;</td>
				<td><?php echo h($docidType['DocidType']['alias']); ?>&nbsp;</td>
				<td class="actions">

					<div class="btn-group">
						<?php echo $this->Html->link('<i class="icon-pencil"></i>', array('action' => 'edit', $docidType['DocidType']['id']), array('escape' => FALSE, 'class' => 'btn')) ?>							

						<?php
						echo $this->Form->postLink('<i class="icon-trash icon-white"></i>', array('action' => 'delete', $docidType['DocidType']['id']), array('class' => 'btn btn-danger', 'escape' => FALSE), __('Are you sure you want to delete # %s?', $docidType['DocidType']['name']));
						?>
					</div>			
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<div class="pagination pagination-centered">
		<ul>
			<?php echo $this->Paginator->prev('<', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
			<?php echo $this->Paginator->numbers(array('tag' => 'li', 'separator' => '', 'currentTag' => 'a', 'currentClass' => 'active')); ?>
			<?php echo $this->Paginator->next('>', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
		</ul>
	</div>
</div>