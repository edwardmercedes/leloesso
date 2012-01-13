<script type="text/javascript" src="include/func.js">
</script>
<?php 
$cc = @mysql_fetch_array(mysql_query("SELECT ID_NCF,ncf,cc,ID_CLIENTE,F_unicio,F_final,DATE_FORMAT(Fecha_registro, '%m/%d/%Y') as fecha FROM rnc WHERE ncf = '".$_GET['id']."' "));

//informacion del cliente
$client = @mysql_fetch_array(@mysql_query("SELECT nombre,telefono,direccion,RNC FROM clientes WHERE ID_CLIENTE = '".$cc['ID_CLIENTE']."' "));


//variables generales
$tutto = 0;
$tutto_ant = 0;
$tutto_mese = 0;
$itbs = 0;
$total_itbs = 0;


//trabajar con fechas valance anterior
$fecha_estado = @mysql_fetch_array(@mysql_query("SELECT 
DAYOFMONTH(DATE_SUB('".$cc['F_unicio']."', INTERVAL 1 DAY)) AS day,
MONTH(DATE_SUB('".$cc['F_unicio']."', INTERVAL 1 DAY)) AS mon,
YEAR(DATE_SUB('".$cc['F_unicio']."', INTERVAL 1 DAY)) AS year
"));

//trabajar con fechas valance resument
$fecha_resumen = @mysql_fetch_array(@mysql_query("SELECT 
DAYOFMONTH('".$cc['F_unicio']."') AS day,
MONTH('".$cc['F_unicio']."') AS mon,
YEAR('".$cc['F_unicio']."') AS year,
DAYOFMONTH('".$cc['F_final']."') AS day2,
MONTH('".$cc['F_final']."') AS mon2,
YEAR('".$cc['F_final']."') AS year2
"));

///valance antetior a la fecha seleccionada
//-----*-------*---------*--------*---//
$sql_1 ="SELECT Tipo_comb,SUM(Valor_fact) AS facturas, SUM(V_cheque) AS pagos ";
$sql_2 = "FROM registro ";
$sql_3 = "WHERE ID_CLIENTE = '".$cc['ID_CLIENTE']."' AND fecha < '".$cc['F_unicio']."' ";
$sql_4 = "GROUP BY Tipo_comb ";
$sql_5 = "ORDER BY fecha ";
$sql_query = mysql_query($sql_1.$sql_2.$sql_3.$sql_4.$sql_5);//QUERY ESTRUCTURA
while($row = mysql_fetch_array($sql_query)){

	if($row['Tipo_comb']=='Gasolina Regular' or $row['Tipo_comb']=='Gasolina Premium' or $row['Tipo_comb']=='Diesel'){
		$tutto_ant = $tutto_ant + $row['facturas'];
	
	}
	else{
		$tutto_ant = $tutto_ant + $row['facturas'] + $row['facturas'] * 0.16;
		$tutto_ant = $tutto_ant - $row['pagos'];
	}
}

//SELECIONAMOS LOS REGISTRO ENTRE LAS DOS FECHAS.... 
$Sql_1 = "SELECT ID,DATE_FORMAT(fecha,'%d-%m-%Y') AS fecha,fecha as orden,N_fact,ficha,Tipo_comb,Precio_comb,Valor_fact,N_cheque,V_cheque,banco ";
$Sql_2 = "FROM registro ";
$Sql_3 = "WHERE ID_CLIENTE = '".$cc['ID_CLIENTE']."' AND fecha BETWEEN '".$cc['F_unicio']."' AND '".$cc['F_final']."' ";
$Sql_4 = "ORDER BY orden ";
$data_query = mysql_query($Sql_1.$Sql_2.$Sql_3.$Sql_4);

//SELECIONAMOS LOS REGISTRO ENTRE LAS DOS FECHAS PERO PARA EL RESUMEN.... 
$resql_1 = "SELECT ID,SUM(Valor_fact) AS facturas,N_fact,ficha,Tipo_comb,Precio_comb,Valor_fact ";
$resql_2 = "FROM registro ";
$resql_3 = "WHERE ID_CLIENTE = '".$cc['ID_CLIENTE']."' AND fecha BETWEEN '".$cc['F_unicio']."' AND '".$cc['F_final']."' ";
$resql_4 = "GROUP BY Precio_comb ";
$resql_5 = "ORDER BY Tipo_comb";
$res_query = mysql_query($resql_1.$resql_2.$resql_3.$resql_4.$resql_5);

//PROCESO -> ASINAMOS EL TOTAL ANTERIOR A EL TOTAL DE FACTURA 
$tutto = $tutto_ant;

//FUNCTION -> PARA HACER EL HEADER DE PRINT CON LOS PAREMETROS DE NOMBRE DOCUMENT... 
//Const_header("Estado de cuenta",$fecha_resumen[0].' '.nombreMes($fecha_resumen[1]).' '.$fecha_resumen[2].' al '.$fecha_resumen[3].' '.nombreMes($fecha_resumen[4]).' '.$fecha_resumen[5]);
?>
<!--- ESPACIO PARA LA INFORMACION DEL CLIENTE -->

<!-- Informacion del cliente para impresion -->
<div id="informacion">
	<h1><strong>Cliente:</strong> <?php echo $client['nombre']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1>
	<span><strong>Direcci&oacute;n: </strong> <?php echo $client[2]; ?></span> <br />   
    <span><strong>RNC: </strong> <?php echo $client['RNC']; ?></span><br />
    <span><strong>Tel.: </strong><?php echo $client[1]; ?></span><br />
    <span><strong>NCF.: </strong><?php echo $_GET['id']; ?></span><br /><br />
    
    <span>NOTA:</span><br>Re-impresi&oacute;n de factura, <?php echo date("m/d/Y"); ?>, la factura original fue impresa en fecha de <?php echo $cc['fecha']; ?>
    
</div>


<br />
<input type="checkbox" value="1" checked="checked" onchange="resument(this,'detalles_factura')" class="print"/><label class="print">Mostrar Detalles</label>

<div id="detalles_factura">
<!-- ESPACIO PARA MOSTRAR LAS TRANZACIONES -->
<table border="1" cellpadding="0" cellspacing="0" class="masther" width="500">
<tr>
	<th>Fecha</th>
    <th>No. Fact</th>
    <th>Ficha</th>
    <th>Gls</th>
    <th>Combust.</th>
    <th>Precio</th>
    <th>Valor Fact</th>
	<th>ITBS</th>
    <th>No.Ch</th>
    <th>Pagos</th>
	<th>Banco</th>
    <th>Balance</th>
</tr>
<tr>
<td colspan="11" class="izquierda" align="left">Balance al  <?php echo $fecha_estado[0];  echo nombreMes($fecha_estado[1]);  echo 'del '.$fecha_estado[2];?> </td>
<td><?php echo number_format($tutto_ant,2);?></td>
</tr>
<?php
while($mes = mysql_fetch_array($data_query)){
//itbis
if($mes['Tipo_comb']=='Gasolina Regular' or $mes['Tipo_comb']=='Gasolina Premium' or $mes['Tipo_comb']=='Diesel'){
	$tutto = $tutto + $mes['Valor_fact'];
	$tutto = $tutto - $mes['V_cheque'];
	$tutto_mese = $tutto_mese + $mes['Valor_fact'];	
	$itbs = 0;
}
else{
	$tutto = $tutto + $mes['Valor_fact'] + $mes['Valor_fact'] * 0.16;
	$tutto = $tutto - $mes['V_cheque'];
	$itbs = $mes['Valor_fact'] * 0.16;
	$total_itbs = $total_itbs + $itbs;
	$tutto_mese = $tutto_mese + $mes['Valor_fact'] + $itbs;			
}
echo '<tr>';
//fecha con el link de actalizar
if($_SESSION['user']=='Pedro'){
	if(empty($mes['Valor_fact'])){
		echo '<td>'.$mes['fecha'].' <a href="debito_edit.php?id='.$_GET['id'].'&fc='.$mes['ID'].'" class="editar"><img src="images/edit.gif" /></a></td>';
	}
	else{
		echo '<td>'.$mes['fecha'].' <a href="credito_edit.php?id='.$_GET['id'].'&fc='.$mes['ID'].'" class="editar"><img src="images/edit.gif" /></a></td>';
	}
}
else{
	if(empty($mes['Valor_fact'])){
		echo '<td>'.$mes['fecha'].'</td>';
	}
	else{
		echo '<td>'.$mes['fecha'].'</td>';
	}
}		
//numero factura simple
	if(!empty($mes['N_fact'])){
		echo '<td>'.$mes['N_fact'].'</td>';
	}
	else{
		echo '<td>&nbsp;</td>';
	}
//Numero ficha simple 
	if(!empty($mes['ficha'])){
		echo '<td>'.$mes['ficha'].'</td>';
	}
	else{
		echo '<td>&nbsp;</td>';
	}
//Numeros de galones	
	if(!empty($mes['Valor_fact'])){
		echo '<td>'.@number_format($mes['Valor_fact'] / $mes['Precio_comb'],2).'</td>';
	}
	else{
		echo '<td>&nbsp;</td>';
	}
//Tipo de combustible
	if(!empty($mes['Tipo_comb'])){
		echo '<td>'.abreviar_combus($mes['Tipo_comb']).'</td>';
	}
	else{
		echo '<td>&nbsp;</td>';
	}
//precio combustible	
	if(!empty($mes['Precio_comb'])){
		echo '<td>'.$mes['Precio_comb'].'</td>';	
	}
	else{
		echo '<td>&nbsp;</td>';	
	}
//Valor factura	
	if($mes['Valor_fact'] > 0){
		echo '<td class="derecha">'.number_format($mes['Valor_fact'],2).'</td>';
	}
	else{
		echo '<td class="derecha">&nbsp;</td>';
	}
//iTBS
	if($itbs > 1){
		echo '<td class="derecha">'.number_format($itbs,2).'</td>';
	}
	else{
		echo '<td class="derecha">&nbsp;</td>';	
	}
//Numero de chaque	
	echo '<td>'.$mes['N_cheque'].' &nbsp;</td>';
//Pagos	
	if($mes['V_cheque'] > 1){
		echo '<td class="derecha">'.number_format($mes['V_cheque'],2).' &nbsp;</td>';	
	}
	else{
		echo '<td>&nbsp;</td>';	
	}
//BANCOS	
	if(!empty($mes['banco'])){
		echo '<td>'.$mes['banco'].' &nbsp;</td>';
	}
	else{
		echo '<td>&nbsp;</td>';
	}
//carcular balance	
	echo '<td class="derecha">'.number_format($tutto,2).'</td>';
echo '</tr>';	
}
?>
</table>
</div><!-- FIN DEL DETALLES -->








<!-- RESUMENT -->

<br />
<input type="checkbox" value="1" onchange="resument(this,'show_resumen')" class="print"/><label class="print">Mostrar resumen</label>
<div id="show_resumen" style="display:none;">
<h1>Resumen Consumo de Combustible</h1>

<table cellpadding="0" cellspacing="0" class="masther" border="1">
<tr>
	<th>Cantidad</th>
    <th>Unidad <br />Medida</th>
    <th>Descripcion</th>
    <th>Precio <br />Unidad</th>
    <th>ITBS</th>
    <th>Total</th>
</tr>
<?php
$ITBS_p = 0;
$ITBS_t = 0;
$total_p = 0;
$total_g = 0;
while($re = mysql_fetch_array($res_query)){
//buscarndo el ITBS particular por casa producto
	if($re['Tipo_comb']=='Gasolina Regular' or $re['Tipo_comb']=='Gasolina Premium' or $re['Tipo_comb']=='Diesel'){
		$ITBS_p='0';
		$total_p = $re['facturas'];
	}
	else{
		$ITBS_p= $re['facturas'] * 0.16;
		$total_p = $re['facturas'] + $ITBS_p;
	}
//total general total ITBS	
$ITBS_t = $ITBS_t+$ITBS_p;
$total_g = 	$total_g+$total_p;
//mostrarlo la informacion generar
echo '<tr>';
	echo '<td class="derecha">'.@number_format($re['facturas'] / $re['Precio_comb'],2).'</td>';
    echo '<td>GLS</td>';
    echo '<td>'.abreviar_combus($re['Tipo_comb']).'</td>';
    echo '<td>'.$re['Precio_comb'].'</td>';
    echo '<td class="derecha">'.number_format($ITBS_p,2).'</td>';
    echo '<td class="derecha">'.number_format($total_p,2).'</td>';
echo '</tr>';
}
?>
<tr>
	<td colspan="4"  align="right" class="fecha">Consumo del <?php echo $fecha_resumen[0].' '.nombreMes($fecha_resumen[1]);  echo ''.$fecha_resumen[2].' al '.$fecha_resumen[3].' '.nombreMes($fecha_resumen[4]).' '.$fecha_resumen[5]; ?>&nbsp;</td>
    <td class="derecha"><?php echo number_format($ITBS_t,2); ?></td>
    <td class="derecha"><?php echo number_format($total_g,2); ?></td>
</tr>
<tr>
	<td colspan="5" align="right"><strong>Total</strong>
    &nbsp;</td>
    <td class="derecha"><?php echo number_format($total_g,2); ?></td>
</tr>

</table>
</div>

<table id="firma">
	<tr>
    	<td style="border-bottom:1px solid #666666; width:200px; margin:0 50px 0 0;"></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="border-bottom:1px solid #666666; width:200px;"></td>
    </tr>

	<tr>
    	<td align="center">Hecho por</td><td>&nbsp;&nbsp;&nbsp;</td> <td align="center">Recibo por</td>
    </tr>
</table>




