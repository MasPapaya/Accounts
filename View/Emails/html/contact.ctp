
<h2>Contacto</h2>

	<strong><?php echo $this->request->data['Contact']['name'];?></strong>
<ul>
	<li>Correo:		<strong><?php echo $this->request->data['Contact']['email'];?></strong> </li>
	<li>Ciudad:		<strong><?php echo $this->request->data['Contact']['city'];?></strong> </li>
	<li>Teléfono	<strong><?php echo $this->request->data['Contact']['phone'];?></strong></li>
</ul>

<?php
$content = explode("\n", $this->request->data['Contact']['comments']);
foreach ($content as $line):
	echo '<p> ' . $line . "</p> <br />";
endforeach;
?>
