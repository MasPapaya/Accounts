<?php
	if ($this->Session->check('Auth.User')) {
		$user = $this->Session->read('Auth.User');

		switch ($user['group_id']) {
			case 3:
				echo $this->element('menu_front/company');
				break;
			case 4:
				echo $this->element('menu_front/employee');
				break;
			default;
				echo '';
				break;
		}
	} else {
		echo '';
	}
?>
