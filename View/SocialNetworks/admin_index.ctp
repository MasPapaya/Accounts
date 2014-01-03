<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Ajs->link('<i class="icon-plus-sign"></i>&nbsp;' . __('New Social Network'), array('action' => 'add'), '', '#primary-ajax'); ?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<h2><?php echo __('Social Networks'); ?></h2>
	<table class="table table-condensed table-bordered table-striped">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($socialNetworks as $socialNetwork): ?>
				<tr>
					<td><?php echo h($socialNetwork['SocialNetwork']['id']); ?>&nbsp;</td>
					<td><?php echo h($socialNetwork['SocialNetwork']['name']); ?>&nbsp;</td>
					<td class="actions">
						<div class="btn-group">
							<?php echo $this->Ajs->button('icon-pencil', array('action' => 'edit', $socialNetwork['SocialNetwork']['id']), '', '#primary-ajax') ?>							
							<?php echo $this->Ajs->button('icon-eye-open', array('action' => 'view', $socialNetwork['SocialNetwork']['id']), '', '#primary-ajax') ?>							
							<?php
							echo $this->Ajs->delete(
								'<i class="icon-trash icon-white"></i>', array('action' => 'delete', $socialNetwork['SocialNetwork']['id']), array('escape' => false, 'class' => 'btn btn-danger'), array('update' => '#primary-ajax', 'confirm' => __('Are you sure you want to delete \" %s \"?', $socialNetwork['SocialNetwork']['id']))
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

