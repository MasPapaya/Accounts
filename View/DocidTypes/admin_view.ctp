<div class="docidTypes view">
<h2><?php echo __d('accounts','Docid Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($docidType['DocidType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($docidType['DocidType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Alias'); ?></dt>
		<dd>
			<?php echo h($docidType['DocidType']['alias']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Docid Type'), array('action' => 'edit', $docidType['DocidType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Docid Type'), array('action' => 'delete', $docidType['DocidType']['id']), null, __('Are you sure you want to delete # %s?', $docidType['DocidType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Docid Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Docid Type'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Profiles'), array('controller' => 'profiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Profile'), array('controller' => 'profiles', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Profiles'); ?></h3>
	<?php if (!empty($docidType['Profile'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Location Id'); ?></th>
		<th><?php echo __('Docid Type Id'); ?></th>
		<th><?php echo __('First Name'); ?></th>
		<th><?php echo __('Last Name'); ?></th>
		<th><?php echo __('Docid'); ?></th>
		<th><?php echo __('Gender'); ?></th>
		<th><?php echo __('Birthday'); ?></th>
		<th><?php echo __('Address'); ?></th>
		<th><?php echo __('Mobile'); ?></th>
		<th><?php echo __('Phone'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($docidType['Profile'] as $profile): ?>
		<tr>
			<td><?php echo $profile['id']; ?></td>
			<td><?php echo $profile['user_id']; ?></td>
			<td><?php echo $profile['location_id']; ?></td>
			<td><?php echo $profile['docid_type_id']; ?></td>
			<td><?php echo $profile['first_name']; ?></td>
			<td><?php echo $profile['last_name']; ?></td>
			<td><?php echo $profile['docid']; ?></td>
			<td><?php echo $profile['gender']; ?></td>
			<td><?php echo $profile['birthday']; ?></td>
			<td><?php echo $profile['address']; ?></td>
			<td><?php echo $profile['mobile']; ?></td>
			<td><?php echo $profile['phone']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'profiles', 'action' => 'view', $profile['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'profiles', 'action' => 'edit', $profile['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'profiles', 'action' => 'delete', $profile['id']), null, __('Are you sure you want to delete # %s?', $profile['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Profile'), array('controller' => 'profiles', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
