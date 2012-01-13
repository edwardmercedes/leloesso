<?php 
include '../conf/conn.php';

if($_GET['nombre'] != NULL){
$client_query= mysql_query("SELECT nombre,ID_CLIENTE FROM clientes WHERE nombre LIKE '".$_GET['nombre']."%' ORDER BY nombre LIMIT 5");
}
else{
	$client_query= mysql_query("SELECT nombre,ID_CLIENTE FROM clientes ORDER BY nombre LIMIT 5");
}


if(!empty($_GET['nombre'])){
	echo '<table border="1" cellpadding="0" cellspacing="0" class="masther" style="margin-left:90px;">';

	while ($row = mysql_fetch_array($client_query)){
		echo '
		<tr>
			<td>'.$row[0].'</td>
			<td><input type="button" value=" v " id="'.$row[1].'" onclick="ncf_lista_cliente_cargar(this.id)"/></td>
		</tr>    
	';
	}
echo '</table>';
}
?>
