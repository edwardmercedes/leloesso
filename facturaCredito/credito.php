<script type="text/javascript">
window.onload=function(){
 cambiarFecha();
 print_();
}

function cambiarFecha(){
	div = document.getElementById('dos');
	nombre = prompt("Fecha para la factura: ", '<?php echo $_GET['impresion'] ?>');
	div.innerHTML = 'Fecha: ' + nombre;
}
function print_(){
	window.print();	
	window.close();
}
</script>
<?php 
include '../conf/conn.php';
include '../include/funciones.php';

//informacion del cliente
$client = @mysql_fetch_array(@mysql_query("SELECT nombre,telefono,direccion,RNC FROM clientes WHERE ID_CLIENTE = '".$_GET['id']."' "));

//variables generales
$tutto = 0;
$tutto_ant = 0;
$tutto_mese = 0;
$itbs = 0;
$total_itbs = 0;

//trabajar con fechas
$fecha_estado = mysql_fetch_array(mysql_query("SELECT 
DAYOFMONTH(DATE_SUB('".$_GET['fecha']."', INTERVAL 1 DAY)) AS day,
MONTH(DATE_SUB('".$_GET['fecha']."', INTERVAL 1 DAY)) AS mon,
YEAR(DATE_SUB('".$_GET['fecha']."', INTERVAL 1 DAY)) AS year
"));
//trabajar con fechas
$fecha_resumen = mysql_fetch_array(mysql_query("SELECT 
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
	$fecha = $row['fecha'];
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
?>
<style>
table#header{
	font-size:15px;
}
table{
	font-size:11px;
}
table#data{
	text-align:left;
}
table#data .derecha{
	text-align:right;
}
.smal{
	font-size:11px;
}


</style>
<br><br>
<table cellpadding="0" cellspacing="0" border="0" id="header">
	<tr>
		<td valign="top">
			<p>
                Cliente: <strong><?php echo $client[0]; ?> </strong><br>
                <span>Direcci&oacute;n: <?php echo $client[2]; ?></span> <br />   
                <span class="smal">RNC: <?php echo $client['RNC']; ?></span>
                <span class="smal">Tel.: <?php echo $client[1]; ?></span>
			</p>
		</td>
		<td width="100">&nbsp;&nbsp;</td>
		<td valign="top" align="right">
            <p >
                <strong>ESTACION ESSO / PEDRO MANUEL B.</strong> <br />
                <strong>Direcci&oacute;n. </strong> Ave. Santa Rosa Esquina Duarte<br />
                <span class="smal">RNC: 130655537</span>	
                <span class="smal">Tel. </strong>(809) 556-2530</span><br />
                <span id="span_fiscal"></span>
                <span id="span_factura"></span>					
            </p>
		</td>
	</tr>

    <tr>
    	<td colspan="3" height="30"></td>
    </tr>    
    <tr>
    	<td><p class="smal">NCF: <?php echo $_GET['ncf']; ?></p></td>
        <td></td>
        <td align="right"><div id="dos" class="smal">Fecha: <?php echo $_GET['impresion'] ?></div></td>
    </tr>
    <tr>
    	<td colspan="3">-----------------------------------------------------------------------------------------------------------------------------------------</td>
    </tr>	
</table>

<br>
 
<table cellpadding="0" cellspacing="0" border="0" id="data">
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
			echo '<td>'.$re['Tipo_comb'].'</td>';
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
    	<td colspan="6">
        ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
    </tr>
<tr>
	<td>
<?php 
if($fecha_resumen[2] == $fecha_resumen[5]){
	echo $fecha_resumen[0].' de '. nombreMes($fecha_resumen[1]).' al ' .$fecha_resumen[3]. ' '.nombreMes($fecha_resumen[4]).' '.$fecha_resumen[5];			
}
else{
echo $fecha_resumen[0].' de '. nombreMes($fecha_resumen[1]).' '.$fecha_resumen[2].' al ' .$fecha_resumen[3]. ' '.nombreMes($fecha_resumen[4]).' '.$fecha_resumen[5];	
}
?>
</td>
	<td colspan="3">
Total</td>
    <td class="derecha"><strong>&nbsp;</td>
    <td class="derecha"><strong><?php echo number_format($total_g,2); ?></strong></td>
</tr>

</table>
<br><br>
<table id="firma" align="center">
	<tr>
    	<td colspan="2" width="700" align="right">.</td>
    </tr>
    <tr>
    	<td align="center">------------------------------</td>
        <td align="center">------------------------------</td>
    </tr>
    <tr>
    	<td align="center">Recibido por:</td>
        <td align="center">Preparado por:</td>
    </tr>
</table>