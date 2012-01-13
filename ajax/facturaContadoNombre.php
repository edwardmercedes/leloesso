<?php
include '../conf/conn.php'; 

if($_GET['nombre']!= ''){
	$query = mysql_query("SELECT nombre,RNC,direccion,telefono FROM clientes WHERE nombre LIKE '".$_GET['nombre']."%' ORDER BY nombre LIMIT 10 ");
	while($clientes = mysql_fetch_array($query)){
		?>
		<a href="#" id="<?php echo $clientes['RNC'] ?>" class="<?php echo $clientes['direccion'] ?>" title="<?php echo $clientes['nombre'] ?>"  name="<?php echo $clientes['telefono'] ?>" onclick="nombreFacturaElegido(this)"><?php echo $clientes['nombre'] ?></a>
		<?php
	}
}


