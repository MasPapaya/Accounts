<?php

if (!empty($picture)) {
	echo $this->Html->image('/files/' . $picture['ViewResource']['entity_folder'] . '/' . $picture['ViewResource']['filename'], array('alt' => $picture['ViewResource']['name']));
} else {
	if ($session == 'picture') {
		if ($this->Session->check('picture')) {
			$pic = $this->Session->read('picture');
			echo $this->Html->image('/files/' . $pic['entity_folder'] . '/' . $pic['filename'], array('alt' => $pic['name']));
		}
	}
}

		




