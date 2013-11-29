<?php
$this->Html->script(array(
	'http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js',
	' https://maps.google.com/maps/api/js?sensor=true',
	'/' . strtolower($this->plugin) . '/js/maps',
	'/' . strtolower($this->plugin) . '/js/main_2',
));
?>
<div class="span3 well ">
	<ul class="nav nav-list">
		<li class="nav-header"><h3><?php echo __('Actions'); ?></h3></li>
		<li><?php echo $this->Ajs->link('<i class="icon-th-list"></i>' . __('List Locations'), array('action' => 'index'), '', '#primary-ajax'); ?></li>
	</ul>
</div>
<div class="span9">
	<div class="span3">
		<?php echo $this->Form->create('Location'); ?>
		<fieldset>
			<legend><?php echo __('Add Location'); ?></legend>
			<?php
			echo $this->Form->input('parent_id', array('empty' => true, 'options' => $locations));
			echo $this->Form->input('name');
			echo '<span>De clic sobre el marcador en el mapa para capturar la latitud y longitud.</span>';
			echo '<span>' . $this->Html->image('http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png', array('alt' => 'Marcador Rojo')) . '</span>';
			echo $this->Form->input('latitude', array('type' => 'text', 'value' => 4.597465143278145, 'class' => 'latitude', 'readonly' => 'readonly'));
			echo $this->Form->input('longitude', array('type' => 'text', 'value' => -434.08543164062496, 'class' => 'longitude', 'readonly' => 'readonly'));
			echo $this->Form->input('is_capital');
			echo $this->Form->input('is_node');
			?>
		</fieldset>
		<?php echo $this->Form->end(array('label' => __('Add'), 'class' => 'btn btn-primary')); ?>
	</div>
	<div class="span9">
		<div id="map_canvas" style="width:100%; height:475px" ><script type="text/javascript">initialize();</script></div>
	</div>
</div>
