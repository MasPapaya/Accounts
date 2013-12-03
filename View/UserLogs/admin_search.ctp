<div class="span12 user_logs">
    <h2><?php echo __('Inscriptions'); ?></h2>
		<?php
	echo $this->Form->create('UserLog', array('action' => 'search'), array('method' => 'GET', 'class' => 'form-inline'));
	echo '<div class="input-append">';
	echo $this->Form->input('search_log', array('label' => false, 'div' => false, 'class' => 'search input-large', 'placeholder' => __('Search', true)));
	echo $this->Form->button('<i class="icon icon-search"></i>', array('label' => false, 'div' => false, 'class' => 'btn'));
	echo '</div>';
	echo $this->Form->end();
	?>
    <table class="table table-condensed table-bordered table-striped">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('username'); ?></th>
				<th><?php echo $this->Paginator->sort('ip'); ?></th>
				<th><?php echo $this->Paginator->sort('user_agent'); ?></th>
				<th><?php echo $this->Paginator->sort('created'); ?></th>
				<!--<th class="actions"><?php echo __('Actions'); ?></th>-->
			</tr>
		</thead>
		<tbody>
			<?php foreach ($logs_search as $userLog): ?>
				<tr>
					<td><?php echo h($userLog['UserLog']['id']); ?>&nbsp;</td>
					<td><?php echo h($userLog['UserLog']['username']); ?>&nbsp;</td>
					<td><?php echo h($userLog['UserLog']['ip']); ?>&nbsp;</td>
					<td><?php echo h($userLog['UserLog']['user_agent']); ?>&nbsp;</td>
					<td><?php echo h($userLog['UserLog']['created']); ?>&nbsp;</td>
	<!--					<td class="actions">
						<div class="btn-group">
					<?php echo $this->Ajs->button('icon-pencil', array('action' => 'edit', $userLog['UserLog']['id']), '', '#primary-ajax') ?>							
					<?php echo $this->Ajs->button('icon-eye-open', array('action' => 'view', $userLog['UserLog']['id']), '', '#primary-ajax') ?>							
					<?php
					echo $this->Ajs->delete(
						'<i class="icon-trash icon-white"></i>', array('action' => 'delete', $userLog['UserLog']['id']), array('escape' => false, 'class' => 'btn btn-danger'), array('update' => '#primary-ajax', 'confirm' => __('Are you sure you want to delete \" %s \"?', $userLog['UserLog']['id']))
					);
					?>
						</div>
					</td>-->
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
    <div class="pagination pagination-centered">
        <ul>
			<?php echo $this->Paginator->prev('<', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
			<?php echo $this->Paginator->numbers(array('tag' => 'li', 'separator' => '', 'currentTag' => 'a', 'currentClass' => 'active')); ?>
			<?php echo $this->Paginator->next('>', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
        </ul>
    </div>
    <div id="inscription"></div>
</div>
