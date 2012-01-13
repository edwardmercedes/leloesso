<script type="text/javascript" src="datepicker/js/datepicker.js"></script>
<link href="datepicker/css/datePicker.css" rel="stylesheet" type="text/css">

<form method="get" class="print">
<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
<label>Fecha:</label>
	<input type="text" name="fecha" value="<?php echo $_GET['fecha'] ?>" onClick="displayDatePicker('fecha', false, 'ymd', '-');" style="width:150px;" autocomplete="off"/> <label>Hasta</label>
    <input type="text" name="fecha2" value="<?php echo $_GET['fecha2'] ?>" onClick="displayDatePicker('fecha2', false, 'ymd', '-');" style="width:150px;" autocomplete="off"/>
	<input type="submit" value="Reporte"  class="control" />
</form>
<?php
//variables globales
$total = 0;//usados
$total_facturas = 0;//usados
$total_facturas_mes = 0;//usados
$total_pagos = 0;//usados
$itbis= 0;
$itbis_total= 0;

//NOMBRE DE CLIENTES
$client= mysql_fetch_array(mysql_query("SELECT ID_CLIENTE,nombre,RNC,telefono FROM clientes  WHERE ID_CLIENTE = '".$_GET['id']."' "));

/*
	SELECIONAR BALANCE ANTERIOR
*/ 
$sql_1 ="SELECT Tipo_comb,SUM(Valor_fact) AS facturas,SUM(V_cheque) AS pagos ";
$sql_2 = "FROM registro ";
$sql_3 = "WHERE ID_CLIENTE = '".$_GET['id']."' AND fecha < '".$_GET['fecha']."' ";
$sql_4 = "GROUP BY Tipo_comb ";
$sql_5 = "ORDER BY fecha ";
$sql_query = mysql_query($sql_1.$sql_2.$sql_3.$sql_4.$sql_5);//QUERY ESTRUCTURA
while($row = mysql_fetch_array($sql_query)){
	if($row['Tipo_comb']=='Gasolina Regular' or $row['Tipo_comb']=='Gasolina Premium' or $row['Tipo_comb']=='Diesel'){
		$tutto_ant = $tutto_ant + $row['facturas'] - $row['pagos'];
	}
	else{
		$tutto_ant = $tutto_ant + $row['facturas']+$row['facturas'] * 0.16;
		$tutto_ant = $tutto_ant - $row['pagos'];
	}
}
$total_facturas = $tutto_ant;
/*
	SELECIONAR BALANCE ANTERIOR - FIN
*/

	
/*
	SELECIONAR BALANCE ENTRE FECHA
*/
$sql_1 ="SELECT DATE_FORMAT(fecha,'%d-%m-%Y') AS fecha,fecha as orden,N_fact,ficha,Tipo_comb,Precio_comb,Valor_fact,N_cheque,V_cheque ";
$sql_2 = "FROM registro ";
if($_GET['fecha']!= '' and $_GET['fecha2']!= ''){
	$sql_3 = "WHERE ID_CLIENTE = '".$_GET['id']."' AND fecha BETWEEN '".$_GET['fecha']."' AND '".$_GET['fecha2']."' ";
}
else{
	$sql_3 = "WHERE ID_CLIENTE = '".$_GET['id']."' ";
}
$sql_4 = "ORDER BY orden ";
$reporque = mysql_query($sql_1.$sql_2.$sql_3.$sql_4);
/*
	SELECIONAR BALANCE ENTRE FECHA - FIN
*/

//For printi Const_header que recive el titulo del documento
//Const_header("Reporte Client",'');

?>
	<div id="fecha_impresion"><?php echo date("d/m/Y"); ?> </div>
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
                    <h1>Cliente:</strong> <?php echo $client['nombre']; ?></h1>
                    <span>Direcci&oacute;n: <?php echo $client['direccion']; ?></span> <br />   
                    <span>RNC: <?php echo $client['RNC']; ?></span><br />
                    <span>Tel.: <?php echo $client['telefono']; ?></span>
                </div>
            </td>
               
  		  </tr>	
	</table>
	</div>
    
    
<div class="print">
	<h1>Cliente: <?php echo $client['nombre']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1>
</div>

<!-- TIPO DE INFORMACION  -->
<div id="tipo_information">

<!--========= PRINT ============--->
<table border="0" cellpadding="0" cellspacing="0" class="masther" width="700">
<tr>
	<th>Fecha</th>
    <th>Ficha</th>
    <th>Combust.</th>
    <th class="derecha">Precio</th>
	<th class="derecha">Factura</th>
	<th>N. Fact</th>
	<th class="derecha">V. Cheque</th>
	<th>N. Cheque</th>
	<th>Banco</th>
	<th class="derecha">ITBIS</th>
	<th class="derecha">Balance</th>
</tr>
<?PHP 
while($re = mysql_fetch_array($reporque)){
//itbs
if($re['Tipo_comb']=='Gasolina Regular' or $re['Tipo_comb']=='Gasolina Premium' or $re['Tipo_comb']=='Diesel'){
	$itbis = '';
}
else{
	$itbis = $re['Valor_fact'] * 0.16;
}
$itbis_total = $itbis_total + $itbis;
//carculo acumulativos
$total_facturas = $total_facturas + $re['Valor_fact'];
$total_pagos = $total_pagos + $re['V_cheque'];
$total_facturas_mes = $total_facturas_mes + $re['Valor_fact'];
//precio combustible
echo '<tr>';
	echo '<td>'.$re['fecha'].'&nbsp;</td>';
    echo '<td>'.$re['ficha'].'&nbsp;</td>';
    echo '<td>'.abreviar_combus($re['Tipo_comb']).'&nbsp;</td>';
//precio combustible
	if(!empty($re['Precio_comb'])){
	    echo '<td>'.number_format($re['Precio_comb'],2).'</td>';	
	}	
	else{
	    echo '<td>&nbsp;</td>';		
	}
//valor de factura	
	if(!empty($re['Valor_fact'])){
		echo '<td class="derecha">'.number_format($re['Valor_fact'],2).'</td>';
	}
	else{
		echo '<td>&nbsp;</td>';
	}
//Numero de factura	
	echo '<td>'.$re['N_fact'].' &nbsp;</td>';
//VALOR DE CHEQUES
	if(!empty($re['V_cheque'])){
		echo '<td>'.number_format($re['V_cheque'],2).'</td>';
	}
	else{
		echo '<td>&nbsp; </td>';
	}
//Numero cheque	
	echo '<td>'.$re['N_cheque'].'&nbsp;</td>';
//banco del cheque	
	echo '<td>'.$re['banco'].'&nbsp;</td>';
//ITBIS
	if(!empty($itbis)){
		echo '<td class="derecha">'.number_format($itbis,2).'</td>';
	}	
	else{
		echo '<td>&nbsp;</td>';
	}
//	balance
	echo '<td class="derecha">'.number_format(($total_facturas + $itbis)- $total_pagos,2).'</td>';
echo '</tr>';
}
?>
<tr>
	<th colspan="4">Totales</th>
    <th class="derecha"><?php echo number_format($total_facturas_mes,2); ?></th>
    <th>&nbsp;</th>
	<th class="derecha"><?php echo number_format($total_pagos,2); ?></th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
<!-- itbis carcuar total -->    
	<th class="derecha">
		<?php 
			if(!empty($itbis_total)){
				echo number_format($itbis_total,2); 
			}
			else{
				echo "&nbsp;";
			}
		?>	
     </th>
        
	<th class="derecha"><?php echo number_format(($total_facturas + $itbis_total) - $total_pagos,2); ?></th>
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

<br />
<input type="button" value="Imprimir" onclick="window.print();" id="print" />  
<input type="button" value="Lista Cliente" onclick="window.open('cliente.php','_self');" id="print" />
