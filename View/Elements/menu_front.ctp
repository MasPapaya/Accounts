<?php
	if ($this->Session->check('Auth.User')) {
		$user = $this->Session->read('Auth.User');

		switch ($user['group_id']) {

			case 3:
			case 4:
				echo $this->element('menu_front/user');
				break;
			default;
				echo $this->element('menu_front/default');
				break;
		}
	} else {
		echo $this->element('menu_front/default');
	}
?>
