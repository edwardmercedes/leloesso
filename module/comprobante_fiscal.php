<script type="text/javascript" src="datepicker/js/datepicker.js"></script>

<link href="datepicker/css/datePicker.css" rel="stylesheet" type="text/css">
<form method="get" class="print">
<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" id="id"/>
<label>Fecha:</label>
	<input type="text" name="fecha" value="<?php echo $_GET['fecha'] ?>" onClick="displayDatePicker('fecha', false, 'ymd', '-');" style="width:150px;" autocomplete="off" id="fecha" /> <label>Hasta</label>
    <input type="text" name="fecha2" value="<?php echo $_GET['fecha2'] ?>" onClick="displayDatePicker('fecha2', false, 'ymd', '-');" style="width:150px;" autocomplete="off" id="fecha2"/>
	<input type="submit" value="Filtral"  class="control" />
</form>
<?php 
//informacion del cliente
$client = @mysql_fetch_array(@mysql_query("SELECT nombre,telefono,direccion,RNC FROM clientes WHERE ID_CLIENTE = '".$_GET['id']."' "));

//variables generales
$tutto = 0;
$tutto_ant = 0;
$tutto_mese = 0;
$itbs = 0;
$total_itbs = 0;

//trabajar con fechas
$fecha_estado = @mysql_fetch_array(@mysql_query("SELECT 
DAYOFMONTH(DATE_SUB('".$_GET['fecha']."', INTERVAL 1 DAY)) AS day,
MONTH(DATE_SUB('".$_GET['fecha']."', INTERVAL 1 DAY)) AS mon,
YEAR(DATE_SUB('".$_GET['fecha']."', INTERVAL 1 DAY)) AS year
"));
//trabajar con fechas
$fecha_resumen = @mysql_fetch_array(@mysql_query("SELECT 
DAYOFMONTH('".$_GET['fecha']."') AS day,
MONTH('".$_GET['fecha']."') AS mon,
YEAR('".$_GET['fecha']."') AS year,
DAYOFMONTH('".$_GET['fecha2']."') AS day2,
MONTH('".$_GET['fecha2']."') AS mon2,
YEAR('".$_GET['fecha2']."') AS year2
"));

//-----*-------*---------*--------*---//
$sql_1 ="SELECT Tipo_comb,SUM(Valor_fact) AS facturas, SUM(V_cheque) AS pagos ";
$sql_2 = "FROM registro ";
$sql_3 = "WHERE ID_CLIENTE = '".$_GET['id']."' AND fecha < '".$_GET['fecha']."' ";
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
//-----*-------*---------*--------*---//-----//-----*-------*---------*--------*---//-----

//-----*-------*---------*--------*---//
$Sql_1 = "SELECT ID,DATE_FORMAT(fecha,'%d-%m-%Y') AS fecha,fecha as orden,N_fact,ficha,Tipo_comb,Precio_comb,Valor_fact,N_cheque,V_cheque,banco ";
$Sql_2 = "FROM registro ";
$Sql_3 = "WHERE ID_CLIENTE = '".$_GET['id']."' AND fecha BETWEEN '".$_GET['fecha']."' AND DATE_ADD('".$_GET['fecha2']."', INTERVAL 1 DAY) ";
$Sql_4 = "ORDER BY orden ";
$data_query = mysql_query($Sql_1.$Sql_2.$Sql_3.$Sql_4);
//-----*-------*---------*--------*---//-----//-----*-------*---------*--------*---//-----

//-----*-------*---------*--------*---//
$resql_1 = "SELECT ID,SUM(Valor_fact) AS facturas,N_fact,ficha,Tipo_comb,Precio_comb,Valor_fact ";
$resql_2 = "FROM registro ";
$resql_3 = "WHERE ID_CLIENTE = '".$_GET['id']."' AND fecha BETWEEN '".$_GET['fecha']."' AND DATE_ADD('".$_GET['fecha2']."', INTERVAL 1 DAY) ";
$resql_4 = "GROUP BY Precio_comb ";
$resql_5 = "ORDER BY Tipo_comb";
$res_query = mysql_query($resql_1.$resql_2.$resql_3.$resql_4.$resql_5);
//-----*-------*---------*--------*---//

$tutto = $tutto_ant;

//llamamos la funcion header for printi Const_header que recive el titulo del documento
?>

<p id="fechaprint">Fecha <input type="text" value="<?php echo date("d/m/Y"); ?>"></p>

	<div id="haader_imprint">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
    			<td valign="top"> <img src="images/esso.jpg"/> &nbsp;&nbsp;</td>
        		<td>
          		  <p>
					<strong>ESTACION ESSO / PEDRO MANUEL B.</strong> <br />
					<strong>Direcci&oacute;n. </strong> Ave. Santa Rosa Esquina Duarte<br />
					<strong>RNC: </strong>130655537	
					<strong>Tel. </strong>(809) 556-2530<br />
                    <span id="span_fiscal"></span>
					<span id="span_factura"></span>					
            	 </p>
			   </td>
			<td width="50">&nbsp;&nbsp;</td>
          	<td>
                <!-- Informacion del cliente para impresion -->
                <div id="informacion">
                    <h1>Cliente:</strong> <?php echo $client[0]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1>
                    <span>Direcci&oacute;n: <?php echo $client[2]; ?></span> <br />   
                    <span>RNC: <?php echo $client['RNC']; ?></span><br />
                    <span>Tel.: <?php echo $client[1]; ?></span>
                </div>
            </td>
               
  		  </tr>	
	</table>
	</div>


<input type="hidden" name="rnc_guardar" value="<?php echo $client['RNC']; ?>"  id="rnc_guardar"/>    
<input type="hidden" name="id_user_guardar" value="<?php echo $_SESSION['user']; ?>"  id="id_user_guardar"/>    

<!-- 
<table cellpadding="0" cellspacing="0" class="masther" border="1">
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
<br />
<input type="checkbox" value="1" onchange="resument(this,'show_resumen')" class="print"/><label class="print">Mostrar resumen</label>
<div id="show_resumen" style="display:none;">
-->


<table cellpadding="0" cellspacing="0" class="masther" border="0">
<tr>
	<th>Cantidad</th>
    <th>Unidad Medida</th>
    <th>Descripcion</th>
    <th>Precio Unidad</th>
    <th class="derecha">ITBS</th>
    <th class="derecha">Total</th>
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
if(!empty($re['facturas'])){
		echo '<tr>';
			echo '<td>'.@number_format($re['facturas'] / $re['Precio_comb'],2).'</td>';
			echo '<td>Galones</td>';
			echo '<td>'.abreviar_combus($re['Tipo_comb']).'</td>';
			echo '<td>'.$re['Precio_comb'].'</td>';
			echo '<td class="derecha">'.number_format($ITBS_p,2).'</td>';
			echo '<td class="derecha">'.number_format($total_p,2).'</td>';
		echo '</tr>';
	}
}
?>
<tr>
	<td colspan="4"  align="right" class="fecha">&nbsp;</td>
    <td class="derecha"><strong><?php echo number_format($ITBS_t,2); ?></strong></td>
    <td class="derecha"><strong><?php echo number_format($total_g,2); ?></strong></td>
</tr>

<tr>
	<td colspan="4">Total</td>
    <td class="derecha"><strong>&nbsp;</td>
    <td class="derecha"><strong><?php echo number_format($total_g,2); ?></strong></td>
</tr>

</table>

<h1 id="fecha_delconsumo">Consumo  del  
	<?php echo $fecha_resumen[0].' de '. nombreMes($fecha_resumen[1]).' '.$fecha_resumen[2].' al ' .$fecha_resumen[3]. ' '.nombreMes($fecha_resumen[4]).' '.$fecha_resumen[5]; ?>
</h1>


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

<?php 
//buscamos el NCF de la base de datos
$ncf_sql = mysql_fetch_array(mysql_query("SELECT nombre,info FROM inf_esso WHERE ID_INFO = 1"));
$ncf = $ncf_sql[1] + 1;
?>       


<div id="numero_factu">
	<table>
    	<tr>
        	<td><label>Factura #: </label></td>
            <td><input type="text" id="factura"/></td>
       </tr>
       	<tr>
        	<td><label>Comprobante #: </label></td>
            <td><input type="text" id="fiscal" value="A01001001010000<?php echo $ncf; ?>"/></td>
        </tr>
       	<tr>
        	<td></td>
            <td><input type="button" value="Agregar" onclick="factura()" /></td>
        </tr>
    </table>
</div>
<br />
<input type="button" value="Imprimir" onclick="print_estado_credito()" id="print" />  
<input type="button" value="Lista Cliente" onclick="window.open('cliente.php','_self');" id="print" />