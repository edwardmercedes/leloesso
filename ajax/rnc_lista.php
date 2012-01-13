<?php 
	include '../conf/conn.php';

$query = mysql_query("SELECT nombre,RNC FROM clientes WHERE nombre LIKE '".$_GET['id']."%' ORDER BY nombre ");
$cliente = mysql_num_rows(mysql_query("SELECT nombre,RNC FROM clientes WHERE nombre LIKE '".$_GET['id']."%' ORDER BY nombre "));

	if($cliente > 0){
		echo '<select name="lista_client" id="select_lista" onchange="llenar()" >';

		while($lista = mysql_fetch_array($query)){
			echo '<option value="'.$lista[1].'">'.$lista[0].'</option>';
		}
		echo '</select>'; 
	}
	else{
		echo '<p style="color:#FF0000">No hay cliente con ese nombre</p>';
	}

?>
