<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><h3><?php echo __('Actions'); ?></h3></li>
			<li><?php echo $this->Ajs->link('<i class="icon-plus-sign"></i>' . __('New Location'), array('action' => 'add'), '', '#primary-ajax'); ?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<h2><?php echo __('Locations'); ?></h2>
	<table class="table table-condensed table-bordered table-striped">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('parent_id'); ?></th>
				<th><?php echo $this->Paginator->sort('lft'); ?></th>
				<th><?php echo $this->Paginator->sort('rght'); ?></th>
				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<th><?php echo $this->Paginator->sort('latitude'); ?></th>
				<th><?php echo $this->Paginator->sort('longitude'); ?></th>
				<th><?php echo $this->Paginator->sort('is_capital'); ?></th>
				<th><?php echo $this->Paginator->sort('is_node'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($locations as $location): ?>
				<tr>
					<td><?php echo h($location['Location']['id']); ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($location['ParentLocation']['name'], array('controller' => 'locations', 'action' => 'view', $location['ParentLocation']['id'])); ?>
					</td>
					<td><?php echo h($location['Location']['lft']); ?>&nbsp;</td>
					<td><?php echo h($location['Location']['rght']); ?>&nbsp;</td>
					<td><?php echo h($location['Location']['name']); ?>&nbsp;</td>
					<td><?php echo h($location['Location']['latitude']); ?>&nbsp;</td>
					<td><?php echo h($location['Location']['longitude']); ?>&nbsp;</td>
					<td><?php echo h($location['Location']['is_capital']); ?>&nbsp;</td>
					<td><?php echo h($location['Location']['is_node']); ?>&nbsp;</td>
					<td class="actions">
						<div class="btn-group">
							<?php echo $this->Ajs->button('icon-pencil', array('action' => 'edit', $location['Location']['id']), '', '#primary-ajax') ?>
							<?php echo $this->Ajs->button('icon-eye-open', array('action' => 'view', $location['Location']['id']), '', '#primary-ajax') ?>
							<?php
							echo $this->Ajs->delete(
								'<i class="icon-trash icon-white"></i>', array('action' => 'delete', $location['Location']['id']), array('escape' => false, 'class' => 'btn btn-danger'), array('update' => '#primary-ajax', 'confirm' => __('Are you sure you want to delete \" %s \"?', $location['Location']['id']))
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
		echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
		?>
	</p>
	<div class="pagination pagination-centered">
		<?php echo $this->Ajs->numbers(); ?>
	</div>
</div>

