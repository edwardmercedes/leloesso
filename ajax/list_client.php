<?php 
include '../conf/conn.php';

if($_GET['codigo'] != NULL){
$client_query= mysql_query("SELECT ID_CLIENTE,nombre,RNC,telefono,tipo FROM clientes WHERE ID_CLIENTE= '".$_GET['codigo']."' AND tipo = '".$_GET['tipo']."' ORDER BY nombre LIMIT 20");
}
elseif($_GET['nombre'] != NULL){
$client_query= mysql_query("SELECT ID_CLIENTE,nombre,RNC,telefono,tipo FROM clientes WHERE nombre LIKE '".$_GET['nombre']."%' AND tipo = '".$_GET['tipo']."' ORDER BY nombre LIMIT 20");
}
else{
	$client_query= mysql_query("SELECT ID_CLIENTE,nombre,RNC,telefono,tipo FROM clientes WHERE tipo = '".$_GET['tipo']."' ORDER BY nombre LIMIT 20");
}
?>

<table border="0" cellpadding="0" cellspacing="0" class="masther">
<tr>
	<th>Codigo</th>
    <th>Nombre</th>
    <th>RNC</th>
    <th>Telefono</th>
    <th>Movimientos</th>
    <th>Informacion Cuenta</th>
</tr>
<?php 
while ($clien_row = mysql_fetch_array($client_query)){
	echo '
	<tr>
		<td>'.$clien_row['ID_CLIENTE'].' <a href="cliente_edit.php?id='.$clien_row['ID_CLIENTE'].'" class="editar"><img src="images/edit.gif" /></a></td>
		<td>'.$clien_row['nombre'].'</td>
		<td>'.$clien_row['RNC'].'</td>
		<td>'.$clien_row['telefono'].'</td>	
	';	
	if($clien_row['tipo']==2){
		echo '<td></td><td></td>';
	}
	else{
	echo '
		<td><a href="credito.php?id='.$clien_row['ID_CLIENTE'].'">Facturas</a> | <a href="debito.php?id='.$clien_row['ID_CLIENTE'].'">Pagos</a></td>	
		<td><a href="estado_cuenta2.php?id='.$clien_row['ID_CLIENTE'].'">Estado </a> | <a href="comprobante_fiscal.php?id='.$clien_row['ID_CLIENTE'].'">Comprobante </a> | <a href="client_report.php?id='.$clien_row['ID_CLIENTE'].'">Reporte</a></td>	
		';
		}
	echo '	
	</tr>    
	';
}
?>
</table>