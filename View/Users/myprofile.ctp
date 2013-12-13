<?php
//debug($user);
?>
<div class="myprofile">
	<?php
	if (CakePlugin::loaded('Resources') && Configure::read('Accounts.profile.picture') == TRUE) {

		echo "<h3>" . __('User Picture') . "</h3>";
		if ($this->Session->check('picture')) {
			$pic = $this->Session->read('picture');
			echo $this->Html->image('/files/' . $pic['entity_folder'] . '/' . $pic['filename'], array('alt' => $pic['name'], 'style' => 'width:200px;margin:20px 20px 20px 0;'));
		} else {
			
		}
		echo $this->Frame->link('icon-film', 'frame', 'user', $authuser['id']);
	}
	?>

	<h3><?php echo __('User Data'); ?></h3>
	<table class="table table-striped table-bordered table-condensed">
		<tr>
			<th><?php echo __('Key'); ?></th>
			<th><?php echo __('Value'); ?></th>
		</tr>
		<tr>
			<td><?php echo __('username'); ?></td>
			<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
		</tr>
		<tr>
			<td><?php echo __('email'); ?></td>
			<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
		</tr>
		<tr>
			<td><?php echo __('group'); ?></td>
			<td><?php echo h($user['Group']['name']); ?>&nbsp;</td>
		</tr>
		<tr>
			<td><?php echo __('created'); ?></td>
			<td><?php echo h($user['User']['created']); ?>&nbsp;</td>
		</tr>
		<tr>
			<td><?php echo __('activated'); ?></td>
			<td><?php echo h($user['User']['activated']); ?>&nbsp;</td>
		</tr>
	</table>
	<?php echo $this->Html->link(__('Edit'), array('action' => 'mydataedit'), array('class' => 'btn btn-primary')); ?>

	<?php if (!empty($profile)): ?>
		<h3><?php echo __('User Profile'); ?></h3>
		<table class="table table-striped table-bordered table-condensed">
			<tr>
				<th><?php echo __('Key'); ?></th>
				<th><?php echo __('Value'); ?></th>
			</tr>
			<tr>
				<td><?php echo __('first_name'); ?></td>
				<td><?php echo h($profile['Profile']['first_name']); ?>&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo __('last_name'); ?></td>
				<td><?php echo h($profile['Profile']['last_name']); ?>&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo __('location'); ?></td>
				<td><?php echo h($profile['Location']['name']); ?>&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo __('docid'); ?></td>
				<td><?php echo h($profile['Profile']['docid']); ?>&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo __('gender'); ?></td>
				<td><?php echo h($profile['Profile']['gender']); ?>&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo __('birthday'); ?></td>
				<td><?php echo h($profile['Profile']['birthday']); ?>&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo __('address'); ?></td>
				<td><?php echo h($profile['Profile']['address']); ?>&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo __('mobile'); ?></td>
				<td><?php echo h($profile['Profile']['mobile']); ?>&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo __('phone'); ?></td>
				<td><?php echo h($profile['Profile']['phone']); ?>&nbsp;</td>
			</tr>
		</table>
		<?php echo $this->Html->link(__('Edit'), array('action' => 'myprofileedit'), array('class' => 'btn btn-primary')); ?>
	<?php endif; ?>

	<?php if (!empty($attributes)): ?>
		<h3><?php echo __('User Attributes'); ?></h3>
		<table class="table table-striped table-bordered table-condensed">
			<tr>
				<th><?php echo __('Key'); ?></th>
				<th><?php echo __('Value'); ?></th>
			</tr>
			<?php foreach ($attributes as $attribute): ?>
				<tr>
					<td><?php echo __($attribute['ViewAttribute']['code']); ?>&nbsp;</td>	
					<td><?php echo h($attribute['ViewAttribute']['value']); ?>&nbsp;</td>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php echo $this->Html->link(__('Edit'), array('plugin' => 'attributes', 'controller' => 'Attributes', 'action' => 'edit', $user_id, 'user', 'accounts', 'Users', 'myprofile'), array('class' => 'btn btn-primary')); ?>
	<?php endif; ?>

	<?php
	if (CakePlugin::loaded('Resources')) {
		echo $this->Frame->modal('frame', array('title' => __('Profile Picture')));
		echo $this->Frame->scriptload();
	}
	?>
</div>