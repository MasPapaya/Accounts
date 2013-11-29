<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li><h3><?php echo __('Actions'); ?></h3></li>
			<li><?php echo $this->Ajs->link('<i class="icon-plus-sign"></i>' . __('New Profile'), array('action' => 'add'), '', '#primary-ajax'); ?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<h2><?php echo __('Profiles'); ?></h2>
	<table class="table table-condensed table-bordered table-striped">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('user_id'); ?></th>
				<th><?php echo $this->Paginator->sort('location_id'); ?></th>
				<th><?php echo $this->Paginator->sort('first_name'); ?></th>
				<th><?php echo $this->Paginator->sort('last_name'); ?></th>
				<th><?php echo $this->Paginator->sort('docid'); ?></th>
				<th><?php echo $this->Paginator->sort('gender'); ?></th>
				<th><?php echo $this->Paginator->sort('birthday'); ?></th>
				<th><?php echo $this->Paginator->sort('address'); ?></th>
				<th><?php echo $this->Paginator->sort('mobile'); ?></th>
				<th><?php echo $this->Paginator->sort('phone'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($profiles as $profile): ?>
				<tr>
					<td><?php echo h($profile['Profile']['id']); ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($profile['User']['id'], array('controller' => 'users', 'action' => 'view', $profile['User']['id'])); ?>
					</td>
					<td>
						<?php echo $this->Html->link($profile['Location']['name'], array('controller' => 'locations', 'action' => 'view', $profile['Location']['id'])); ?>
					</td>
					<td><?php echo h($profile['Profile']['first_name']); ?>&nbsp;</td>
					<td><?php echo h($profile['Profile']['last_name']); ?>&nbsp;</td>
					<td><?php echo h($profile['Profile']['docid']); ?>&nbsp;</td>
					<td><?php echo h($profile['Profile']['gender']); ?>&nbsp;</td>
					<td><?php echo h($profile['Profile']['birthday']); ?>&nbsp;</td>
					<td><?php echo h($profile['Profile']['address']); ?>&nbsp;</td>
					<td><?php echo h($profile['Profile']['mobile']); ?>&nbsp;</td>
					<td><?php echo h($profile['Profile']['phone']); ?>&nbsp;</td>
					<td class="actions">
						<div class="btn-group">
							<?php echo $this->Ajs->button('icon-pencil', array('action' => 'edit', $profile['Profile']['id']), '', '#primary-ajax') ?>							
							<?php echo $this->Ajs->button('icon-eye-open', array('action' => 'view', $profile['Profile']['id']), '', '#primary-ajax') ?>							
							<?php
							echo $this->Ajs->delete(
								'<i class="icon-trash icon-white"></i>', array('action' => 'delete', $profile['Profile']['id']), array('escape' => false, 'class' => 'btn btn-danger'), array('update' => '#primary-ajax', 'confirm' => __('Are you sure you want to delete \" %s \"?', $profile['Profile']['id']))
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

