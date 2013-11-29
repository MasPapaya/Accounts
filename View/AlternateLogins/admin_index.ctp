<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><h3><?php echo __('Actions'); ?></h3></li>
			<li><?php echo $this->Ajs->link('<i class="icon-plus-sign"></i>&nbsp;' . __('New Alternate Login'), array('action' => 'add'), '', '#primary-ajax'); ?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<h2><?php echo __('Alternate Logins'); ?></h2>
	<table class="table table-condensed table-bordered table-striped">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('user_id'); ?></th>
				<th><?php echo $this->Paginator->sort('social_network_id'); ?></th>
				<th><?php echo $this->Paginator->sort('uid'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($alternateLogins as $alternateLogin): ?>
				<tr>
					<td><?php echo h($alternateLogin['AlternateLogin']['id']); ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($alternateLogin['User']['id'], array('controller' => 'users', 'action' => 'view', $alternateLogin['User']['id'])); ?>
					</td>
					<td>
						<?php echo $this->Html->link($alternateLogin['SocialNetwork']['name'], array('controller' => 'social_networks', 'action' => 'view', $alternateLogin['SocialNetwork']['id'])); ?>
					</td>
					<td><?php echo h($alternateLogin['AlternateLogin']['uid']); ?>&nbsp;</td>
					<td class="actions">
						<div class="btn-group">
							<?php echo $this->Ajs->button('icon-pencil', array('action' => 'edit', $alternateLogin['AlternateLogin']['id']), '', '#primary-ajax') ?>							
							<?php echo $this->Ajs->button('icon-eye-open', array('action' => 'view', $alternateLogin['AlternateLogin']['id']), '', '#primary-ajax') ?>							
							<?php
							echo $this->Ajs->delete(
								'<i class="icon-trash icon-white"></i>', array('action' => 'delete', $alternateLogin['AlternateLogin']['id']), array('escape' => false, 'class' => 'btn btn-danger'), array('update' => '#primary-ajax', 'confirm' => __('Are you sure you want to delete \" %s \"?', $alternateLogin['AlternateLogin']['id']))
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

