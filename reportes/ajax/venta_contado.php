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
	echo '<h1>Reporte: Ventas a contado al '.$date_format[2].' de '.nombreMes($date_format[1]).' a&ntilde;o '.$date_format[0].'</h1>';
}
else{
	echo '<h1>Reporte General: Ventas al contado</h1>';	
}



//* DECLARACION DE VARIABLES
$t_clientes=0;
$ventas=0;
$t_ventas=0;

/*
 	* hacemos el query para buscar las facturas y pagos
	* ordemanos el resultado por el mayor a menor
	* conel idcliente buscamos la informacion del cliente
*/
$sql_ = mysql_query("
	SELECT ID_CLIENTE FROM rnc WHERE cc = '2' GROUP BY ID_CLIENTE ORDER BY SUM(valor) DESC");
?>
<table border="1" cellpadding="0" cellspacing="0" id="table" width="600">
<tr>
	<th width="50">Codigo</th>
    <th>Nombre</th>
    <th width="50">RNC</th>
    <th width="130">Telefono</th>
    <th width="90" class="derecha">Ventas</th>
</tr>
<?php 
while ($row = mysql_fetch_array($sql_)){
// * revisamos si la consulta tiene fecha	
	if($_GET['inicio']!='' and $_GET['fin']!=''){
		$valor = mysql_query("
		SELECT SUM(valor)AS fact,tipo
		FROM rnc
		WHERE ID_CLIENTE = '".$row['ID_CLIENTE']."' and Fecha_registro BETWEEN '".$_GET['inicio']."' AND DATE_ADD('".$_GET['fin']."', INTERVAL 1 DAY)
		GROUP BY tipo
		");
	}
	else{
		$valor = mysql_query("
		SELECT SUM(valor)AS fact,tipo
		FROM rnc
		WHERE ID_CLIENTE = '".$row['ID_CLIENTE']."' 
		GROUP BY tipo
		");		
	}
//los carculos con o sin itbis
	$ventas=0;
	while($fac = mysql_fetch_array($valor)){
		if($fac['tipo'] == 'Gasolina Regular' or $fac['tipo'] == 'Gasolina Premium' or $fac['tipo'] == 'Diesel'){
			$ventas = $ventas + $fac['fact'];
		}
		else{
			$ventas = $ventas + $fac['fact'] + ($fac['fact']*0.16);
		}
	}	
	$t_ventas = $t_ventas + $ventas;
	$t_clientes = $t_clientes + 1;
/*
 	* BUSCAMOS LA INFORMACION DEL CLIENTE POR EL IDCLIENTE DE LA CONSULTA ANTERIOR
*/
	$client= mysql_fetch_array(mysql_query("SELECT ID_CLIENTE,nombre,RNC,telefono FROM clientes WHERE ID_CLIENTE = '".$row['ID_CLIENTE']."' ORDER BY nombre"));
	
	echo '
	<tr>
		<td>&nbsp;'.$client['ID_CLIENTE'].'</td>
		<td>&nbsp;'.$client['nombre'].'</td>
		<td>&nbsp;'.$client['RNC'].'</td>
		<td>&nbsp;'.$client['telefono'].'</td>
		<td class="derecha">&nbsp;'.number_format($ventas,2).'</td>
	</tr>    
	';
}	
?>
<!-- MOSTRANDO LA SUMA -->
<tr>
	<td colspan="4"><strong>Numeros de clientes= <?php  echo $t_clientes; ?></strong></td>
    <td class="derecha"><strong><?php echo number_format($t_ventas,2);?></strong></td>
</tr>
</table>
