
<div class="span12 user_logs title_form">
	<h2><?php echo __d('accounts', 'User Logs'); ?></h2>
	<?php
	echo $this->Form->create('UserLog', array('action' => 'search', 'class' => 'form-inline'));
	echo '<div class="form-group">';
	echo $this->Form->input('search_log', array('label' => false, 'div' => false, 'class' => 'search input-large', 'placeholder' => __('Search', true)));
	echo '</div>';
	echo $this->Form->button('<span class="glyphicon glyphicon-search"></span>', array('label' => false, 'div' => false, 'class' => 'btn btn-default'));
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
			</tr>
		</thead>
		<tbody>
			<?php foreach ($userLogs as $userLog): ?>
				<tr>
					<td><?php echo h($userLog['UserLog']['id']); ?>&nbsp;</td>
					<td><?php echo h($userLog['UserLog']['username']); ?>&nbsp;</td>
					<td><?php echo h($userLog['UserLog']['ip']); ?>&nbsp;</td>
					<td><?php echo h($userLog['UserLog']['user_agent']); ?>&nbsp;</td>
					<td><?php echo h($userLog['UserLog']['created']); ?>&nbsp;</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="pagination-centered">
        <ul class="pagination">
			<?php echo $this->Paginator->prev('<', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
			<?php echo $this->Paginator->numbers(array('tag' => 'li', 'separator' => '', 'currentTag' => 'a', 'currentClass' => 'active')); ?>
			<?php echo $this->Paginator->next('>', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
        </ul>
    </div>
</div>

