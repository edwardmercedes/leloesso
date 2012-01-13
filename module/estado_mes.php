<div id="fecha_impresion">Fecha de Impresi&oacute;n <?php echo date("d/m/Y"); ?></div>
<?php 
//informacion del cliente
$client = @mysql_fetch_array(@mysql_query("SELECT nombre,telefono,direccion,RNC FROM clientes WHERE ID_CLIENTE = '".$_GET['id']."' "));

//variables generales
$tutto = 0;
$tutto_ant = 0;
$tutto_mese = 0;

//trabajar con fechas
$fecha_estado = mysql_fetch_array(mysql_query("SELECT 
DAYOFMONTH(LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))) AS day,
MONTH(LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))) AS mon,
YEAR(LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))) AS year
"));

//-----*-------*---------*--------*---//
$sql_1 ="SELECT Tipo_comb,SUM(Valor_fact) AS facturas,SUM(V_cheque) AS pagos ";
$sql_2 = "FROM registro ";
$sql_3 = "WHERE ID_CLIENTE = '2' AND fecha <=  LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 2 MONTH))";
$sql_4 = "GROUP BY Tipo_comb ";
$sql_5 = "ORDER BY fecha ";
$sql_query = mysql_query($sql_1.$sql_2.$sql_3.$sql_4.$sql_5);//QUERY ESTRUCTURA
while($row = mysql_fetch_array($sql_query)){
	if($row['Tipo_comb']=='Gasolina Regular' or $row['Tipo_comb']=='Gasolina Premium' or $row['Tipo_comb']=='Diesel'){
		$tutto_ant = $tutto_ant + $row['facturas'];
	}
	else{
		$tutto_ant = $tutto_ant + $row['facturas']+$row['facturas'] * 0.16;
	}
}
//-----*-------*---------*--------*---//-----//-----*-------*---------*--------*---//-----

//-----*-------*---------*--------*---//
$Sql_1 = "SELECT ID,DATE_FORMAT(fecha,'%d-%m-%Y') AS fecha,N_fact,ficha,Tipo_comb,Precio_comb,Valor_fact,N_cheque,V_cheque ";
$Sql_2 = "FROM registro ";
$Sql_3 = "WHERE ID_CLIENTE = '2' AND MONTH(fecha) =  MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND YEAR(fecha)=YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) ";
$Sql_4 = "ORDER BY fecha";
$data_query = mysql_query($Sql_1.$Sql_2.$Sql_3.$Sql_4);
//-----*-------*---------*--------*---//-----//-----*-------*---------*--------*---//-----

//-----*-------*---------*--------*---//
$resql_1 = "SELECT ID,SUM(Valor_fact) AS facturas,N_fact,ficha,Tipo_comb,Precio_comb,Valor_fact ";
$resql_2 = "FROM registro ";
$resql_3 = "WHERE ID_CLIENTE = '2' AND MONTH(fecha) =  MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND YEAR(fecha)=YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) ";
$resql_4 = "GROUP BY Precio_comb ";
$resql_5 = "ORDER BY Tipo_comb";
$res_query = mysql_query($resql_1.$resql_2.$resql_3.$resql_4.$resql_5);
//-----*-------*---------*--------*---//

$tutto = $tutto_ant;
?>
<div id="haader_imprint">
	<strong>Estaci&oacute;n Esso Pedro Manuel B.</strong><br />
    Ave. Santa Rosa Esquina Duarte<br />
    (809) 556-2530<br />
    <span id="span_factura"></span><br />
    <span id="span_fiscal"></span><br />
</div>

<div id="informacion">
	<h1><?php echo $client[0]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1>
	<span><strong>Direcci&oacute;n: </strong> <?php echo $client[2]; ?></span> <br />   
    <span><strong>RNC: </strong> <?php echo $client['RNC']; ?></span><br />
    <span><strong>Tel.: </strong><?php echo $client[1]; ?></span>
</div>

<table cellpadding="0" cellspacing="0" class="masther" border="1">
<tr>
	<th>Fecha</th>
    <th>No. Fact</th>
    <th>Ficha</th>
    <th>Gls</th>
    <th>Combust.</th>
    <th>Precio</th>
    <th>Valor Fact</th>
    <th>No.Ch</th>
    <th>Pagos</th>
    <th>Balance</th>
</tr>
<tr>
<td colspan="9"> </td>
<td colspan="9"><?php echo $tutto_ant;?></td>
</tr>
<?php
while($mes = mysql_fetch_array($data_query)){
	$tutto = $tutto + $mes['Valor_fact'];
	$tutto = $tutto - $mes['V_cheque'];
	$tutto_mese = $tutto_mese + $mes['Valor_fact'];
echo '<tr>';
//fecha con el link de actalizar
	if(empty($mes['Valor_fact'])){
		echo '<td>'.$mes['fecha'].' <a href="debito_edit.php?id='.$_GET['id'].'&fc='.$mes['ID'].'" class="editar"><img src="images/edit.gif" /></a></td>';
	}
	else{
		echo '<td>'.$mes['fecha'].' <a href="credito_edit.php?id='.$_GET['id'].'&fc='.$mes['ID'].'" class="editar"><img src="images/edit.gif" /></a></td>';
	}	
//numero factura simple
	echo '<td>'.$mes['N_fact'].'</td>';
//Numero ficha simple 
	echo '<td>'.$mes['ficha'].'</td>';
//Numeros de galones	
	echo '<td>'.number_format($mes['Valor_fact'] / $mes['Precio_comb'],2).'</td>';
//Tipo de combustible
	echo '<td>'.$mes['Tipo_comb'].'</td>';
//precio combustible	
	echo '<td>'.$mes['Precio_comb'].'</td>';
//Valor factura	
	echo '<td class="derecha">'.number_format($mes['Valor_fact'],2).'</td>';
//Numero de chaque		
	echo '<td>'.$mes['N_cheque'].' &nbsp;</td>';
//Pagos	
	echo '<td>'.$mes['V_cheque'].' &nbsp;</td>';
//carcular balance	
	echo '<td>'.$tutto.'</td>';
echo '</tr>';	
}
?>
</table>
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
		$ITBS_p='E';
		$total_p = $re['facturas'];
	}
	else{
		$ITBS_p= $re['facturas'] * 0.16;
		$total_p = $total_p + $re['facturas'] + $ITBS_p;
	}
//total general total ITBS	
$ITBS_t = $ITBS_t+$ITBS_p;
$total_g = 	$total_g+$total_p;
//mostrarlo la informacion generar
echo '<tr>';
	echo '<td class="derecha">'.number_format($re['facturas'] / $re['Precio_comb'],2).'</td>';
    echo '<td>GLS</td>';
    echo '<td>'.$re['Tipo_comb'].'</td>';
    echo '<td>'.$re['Precio_comb'].'</td>';
    echo '<td class="derecha">'.number_format($ITBS_p,2).'</td>';
    echo '<td class="derecha">'.number_format($total_p,2).'</td>';
echo '</tr>';
}
?>
<tr>
	<td colspan="4"  align="right">Consumo del mes de <?php echo nombreMes($fecha_estado[1]);  echo 'del '.$fecha_estado[2];?>&nbsp;</td>
    <td class="derecha"><?php echo number_format($ITBS_t,2); ?></td>
    <td class="derecha"><?php echo number_format($total_g,2); ?></td>
</tr>
<tr>
	<td colspan="5" align="right">Balance al   
    	<?php 
		 echo $fecha_estado[0];
       	 echo nombreMes($fecha_estado[1]);
		 
		 echo 'del '.$fecha_estado[2];
		?>
    &nbsp;</td>
    <td class="derecha"><?php echo number_format($total_g+$tutto_ant,2); ?></td>
</tr>

</table>

<table id="firma">
	<tr>
    	<td style="border-bottom:1px solid #666666; width:200px; margin:0 50px 0 0;"></td>
        <td style="border-bottom:1px solid #666666; width:200px;"></td>
    </tr>

	<tr>
    	<td align="center">Estacion Esso Pedro Manuel B.</td> <td align="center">Cliente</td>
    </tr>
</table>

<div id="numero_factu">
	<table>
    	<tr>
        	<td><label>Factura #: </label></td>
            <td><input type="text" id="factura" autocomplete="off"/></td>
       </tr>
       	<tr>
        	<td><label>Comprobante #: </label></td>
            <td><input type="text" id="fiscal" autocomplete="off"/></td>
        </tr>
       	<tr>
        	<td></td>
            <td><input type="button" value="Agregar" onclick="factura()" /></td>
        </tr>
    </table>
</div>

<br />
<input type="button" value="Imprimir" onclick="window.print();" id="print" />  
<input type="button" value="Lista Cliente" onclick="window.open('cliente.php','_self');" id="print" />