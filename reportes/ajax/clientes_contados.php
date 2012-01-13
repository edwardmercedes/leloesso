<div id="datepick">
    	<label>Inicio: </label> <input type="text" id="inicio" value="<?php echo $_GET['inicio']; ?>" name="inicio" onClick="displayDatePicker('inicio', false, 'ymd', '-');"> 
        <label>Final: </label> <input type="text" id="final"  value="<?php echo $_GET['fin']; ?>" name="final" onClick="displayDatePicker('final', false, 'ymd', '-');"> 
        <input type="button" value="Go" id="go" onclick="dosfecha();">
</div> 

<table id="informacion_esso">
   <tr>
     <td valign="top"><img src="images/logo.jpg" id="logo"></td>
     <td>
<div id="testo_empresa">
<strong>ESTACION ESSO / PEDRO MANUEL BAEZ B.</strong><br>
Ave. Santa Rosa #64, esquina Duarte<br>
Tel. (809) - 556-2530&nbsp;&nbsp;&nbsp;
RNC: 130655537<br>
</div>
    </td>
   </tr>
 </table>

<?php
include '../../conf/conn.php';
include '../include/funciones.php';

/*
	*Title reporte
*/
if($_GET['fin']){
	$date_format = explode("-",$_GET['fin']);
	echo '<h1>Reporte: Clientes al Contado reporte al '.$date_format[2].' de '.nombreMes($date_format[1]).' a&ntilde;o '.$date_format[0].'</h1>';
}
else{
	echo '<h1>Reporte General: Clientes al Contado</h1>';
}


//Declaracin de variables
$t_cliente =0;
$facturas = 0;
$t_facturas = 0;

/*
 	* hacemos el query para buscar las facturas y pagos *
	* ordemanos el resultado por el mayor a menor *
	* conel idcliente buscamos la informacion del cliente *
*/
$fact_query= mysql_query("SELECT ID_CLIENTE FROM rnc WHERE cc = 2 GROUP BY ID_CLIENTE");	
?>
<table border="1" cellpadding="0" cellspacing="0"  id="table" width="600">
    <tr>
        <th width="50">Codigo</th>
        <th>Nombre</th>
        <th width="50">RNC</th>
        <th>Telefono</th>
        <th width="100" class="derecha">Facturas</th>
    </tr>
<?php 
while($fact_row = mysql_fetch_array($fact_query)){
	//informacion del cliente
	$cliente_sql = mysql_fetch_array(mysql_query("SELECT nombre,telefono,RNC FROM clientes WHERE ID_CLIENTE = '".$fact_row['ID_CLIENTE']."' "));
	
	//facturas 
	if($_GET['fin']!=''){
		$fact_sql = mysql_query("
					SELECT tipo,SUM(valor) AS fact 
					FROM rnc WHERE ID_CLIENTE = '".$fact_row['ID_CLIENTE']."' AND Fecha_registro < date_add('".$_GET['fin']."',INTERVAL 1 DAY)
					GROUP BY tipo
					");
	}
	else{
		$fact_sql = mysql_query("SELECT tipo,SUM(valor) AS fact FROM rnc WHERE ID_CLIENTE = '".$fact_row['ID_CLIENTE']."' GROUP BY tipo");
	}
	
	while($row = mysql_fetch_array($fact_sql)){
		if($row['tipo'] == 'Gasolina Regular' or $row['tipo'] == 'Gasolina Premium' or $row['tipo'] == 'Diesel'){
			$facturas = $facturas +  $row['fact'];
		}
		else{
			$facturas = $facturas +  $row['fact'] + ($row['fact'] * 0.16);
		}
		//$facturas = $facturas + 1;
	}
	
//	contendio de tota cliente y suma total factura
	$t_facturas = $t_facturas + $facturas;	
	$t_cliente = $t_cliente + 1;

	echo '
	    <tr>
			<td>&nbsp;'.$fact_row['ID_CLIENTE'].'</td>
			<td>&nbsp;'.$cliente_sql['nombre'].'</td>
			<td>&nbsp;'.$cliente_sql['RNC'].'</td>
			<td>&nbsp;'.$cliente_sql['telefono'].'</td>
			<td class="derecha">&nbsp;'.number_format($facturas,2).'</td>
	    </tr>
	';
	}
?>	
<tr>
	<td colspan="4"><strong>Numero Total de clientes = <?php echo $t_cliente; ?></strong></td>
    <td class="derecha">&nbsp;<strong><?php echo number_format($t_facturas,2);?></strong></td>
</tr>
</table>
