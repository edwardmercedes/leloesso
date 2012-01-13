<script src="include/func.js" type="text/javascript"></script>
<form method="get" class="print" name="buscar_client_form">
<label>Codigo:</label>
	<input type="text" name="codigo" value="<?php if(isset($_GET['codigo'])){ echo $_GET['codigo'];}?>" style="width:40px;" onkeyup="cargar_cliente()" autocomplete="off" /> 
    <label>Nombre:</label>
    
    <input type="text" name="nombre" value="<?php if(isset($_GET['nombre'])){ echo $_GET['nombre'];}?>" onkeyup="cargar_cliente()"  autocomplete="off" style="width:120px;" />
    
    <label>Tipo cliente:</label>
    <select name="tipo" style="width:100px;" onchange="cargar_cliente()">
    	<option value="0">Creditos</option>
        <option value="2">Contado</option>
    </select>
    
</form>
<br />
<?php 
if(isset($_GET['codigo']) != NULL){
$client_query= mysql_query("SELECT ID_CLIENTE,nombre,RNC,telefono,tipo FROM clientes WHERE ID_CLIENTE= '".$_GET['codigo']."' AND tipo <> 2 ORDER BY nombre LIMIT 20");
}
elseif(isset($_GET['nombre']) != NULL){
$client_query= mysql_query("SELECT ID_CLIENTE,nombre,RNC,telefono,tipo FROM clientes WHERE nombre LIKE '".$_GET['nombre']."%' AND tipo <> 2 ORDER BY nombre LIMIT 20");
}
else{
	$client_query= mysql_query("SELECT ID_CLIENTE,nombre,RNC,telefono,tipo FROM clientes WHERE tipo <> 2 ORDER BY nombre LIMIT 20 ");
}
?>

<!-- llenar con los ajax-->
<div id="list_clients">
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
			?>
            <td><a href="credito.php?id=<?php echo $clien_row['ID_CLIENTE']; ?>">Facturas</a> | <a href="debito.php?id=<?php echo $clien_row['ID_CLIENTE'] ?>">Pagos</a></td>
            <td>
		        <a href="estado_cuenta2.php?id=<?php echo $clien_row['ID_CLIENTE'] ?>">Estado</a> |     
                <a href="comprobante_fiscal.php?id=<?php echo $clien_row['ID_CLIENTE'] ?>">Comprobante</a> | 
                <a href="#" onclick="abrirPopUp('recibo/recibo.php?id=<?php echo $clien_row['ID_CLIENTE'] ?>','500','300','Factura Contado')">Recibo Pago</a>
                <!-- <a href="client_report.php?id='.$clien_row['ID_CLIENTE'].'">Reporte</a> -->
            </td>
            <?php
		}
	echo '		
	</tr> 
	';   
	
}
?>
</table>
</div>