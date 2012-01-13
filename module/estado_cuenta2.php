<script type="text/javascript" src="datepicker/js/datepicker.js"></script>
<link href="datepicker/css/datePicker.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="include/func.js"></script>

<div id="fecha_selector">
<form method="get" class="print">
<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" id="id"/>
<label>Fecha:</label>
	<input type="text" name="fecha" value="<?php echo $_GET['fecha'] ?>" onClick="displayDatePicker('fecha', false, 'ymd', '-');" style="width:150px;" autocomplete="off" id="fecha" /> <label>Hasta</label>
    <input type="text" name="fecha2" value="<?php echo $_GET['fecha2'] ?>" onClick="displayDatePicker('fecha2', false, 'ymd', '-');" style="width:150px;" autocomplete="off" id="fecha2"/>
	<input type="submit" value="Filtral"  class="control" />
</form>
</div>

<?php 
include 'include/funciones.php';
//informacion del cliente
$client = mysql_fetch_array(@mysql_query("SELECT nombre,telefono,direccion,RNC FROM clientes WHERE ID_CLIENTE = '".$_GET['id']."' "));

//variables generales
$tutto = 0;
$tutto_ant = 0;
$tutto_mese = 0;
$tutto_pagos = 0;
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
echo $PAGOS;
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


//buscamos el NCF de la base de datos
$ncf_sql = mysql_fetch_array(mysql_query("SELECT nombre,info FROM inf_esso WHERE ID_INFO = 1"));
$ncf = $ncf_sql[1] + 1;

?>

<input type="hidden" name="rnc_guardar" value="<?php echo $client['RNC']; ?>"  id="rnc_guardar"/>    
<input type="hidden" name="id_user_guardar" value="<?php echo $_SESSION['user']; ?>"  id="id_user_guardar"/>

<div id="factura_envoltura">
<table>
<tr>
<td>
<div id="header1">
	<div id="empresa">
    	<table>
        	<tr>
            	<td><a href="http://localhost/esso/"><img src="images/logo.jpg" id="logo"></a></td>
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
    </div>
    
    <div id="cliente_informacion">
    	<strong>Nombre: </strong> <?php echo $client[0]; ?><br>
    	<strong>RNC: </strong> <?php echo $client['RNC']; ?><br>
    	<strong>Telefono: </strong> <?php echo $client[1]; ?><br>
    	<strong>Direccion: </strong>  <?php echo $client[2]; ?><br>                        
    </div>
</div>
</td>
<td>
<div id="header2">
	<dl>
		<dt>Tipo Factura</dt>
		<dd><input type="text" value="Credito" /></dd>
        
		<dt>Fecha Factura</dt>
		<dd>
<textarea>Consumo del <?php echo $fecha_resumen[0].' '.nombreMes($fecha_resumen[1]);  echo ''.$fecha_resumen[2].' al '.$fecha_resumen[3].' '.nombreMes($fecha_resumen[4]).' '.$fecha_resumen[5]; ?>&nbsp;
</textarea>	
       </dd>

	</dl>
</div>
</td>
</tr>
</table>


<table id="informacion_factura" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<th>Fecha</th>
        <th width="40">No.</th>
        <th>Ficha</th>
        <th width="40">Gls</th>
        <th width="70">Combust.</th>
        <th class="derecha">Precio</th>
        <th class="derecha">Valor</th>
        <th class="derecha">ITBS&nbsp;</th>
        <th width="30">No.Ch</th>
        <th class="derecha">Pagos</th>
        <th class="derecha">Balance</th>
	</tr>
    
<!-- BALANCE ANTERIOR   -->
	<tr>
    	<td colspan="10">Balance al  <?php echo $fecha_estado[0];  echo nombreMes($fecha_estado[1]);  echo 'del '.$fecha_estado[2];?></td>
        <td class="derecha">
			<?php 
				if($tutto_ant < 0 and $tutto_ant > -1){
					$tutto_ant = 0;
				}
			echo number_format($tutto_ant,2);	
			?></td>
	</tr>


<!-- MIENTRAS EXISTAN TRANSACIONES  -->
<?php
$tr=0;
while($mes = mysql_fetch_array($data_query)){
//itbis
if($mes['Tipo_comb']=='Gasolina Regular' or $mes['Tipo_comb']=='Gasolina Premium' or $mes['Tipo_comb']=='Diesel'){
	$tutto = $tutto + $mes['Valor_fact'];
	$tutto = $tutto - $mes['V_cheque'];
	$tutto_pagos = $tutto_pagos + $mes['V_cheque'];
	$tutto_mese = $tutto_mese + $mes['Valor_fact'];	
	$itbs = 0;
}
else{
	$tutto = $tutto + $mes['Valor_fact'] + $mes['Valor_fact'] * 0.16;
	$tutto = $tutto - $mes['V_cheque'];
	$tutto_pagos = $tutto_pagos + $mes['V_cheque'];
	$itbs = $mes['Valor_fact'] * 0.16;
	$total_itbs = $total_itbs + $itbs;
	$tutto_mese = $tutto_mese + $mes['Valor_fact'] + $itbs;			
}

if($tr==0){
	echo '<tr class="dos">';	
	$tr = 1;
}
else{
	echo '<tr>';
	$tr = 0;
}
//fecha con el link de actalizar
if($_SESSION['user']=='Pedro'){
	if(empty($mes['Valor_fact'])){
		echo '<td>'.$mes['fecha'].' <a href="debito_edit.php?id='.$_GET['id'].'&fc='.$mes['ID'].'" class="no"><img src="images/edit.gif" /></a></td>';
	}
	else{
		echo '<td>'.$mes['fecha'].' <a href="credito_edit.php?id='.$_GET['id'].'&fc='.$mes['ID'].'" class="no"><img src="images/edit.gif" /></a></td>';
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
		echo '<td class="derecha">'.$mes['Precio_comb'].'</td>';	
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
//carcular balance	
	
	if($tutto > 0){
		echo '<td class="derecha">'.number_format($tutto,2).'</td>';	
	}
	else{
		echo '<td class="derecha">0.00</td>';	
	}
echo '</tr>';	
}
?>
</table>

<table>
	<tr>
    	<td>
			<textarea id="nota">Notas</textarea>
        </td>
        <td>
        	<table id="informacion_factura" border="0" cellpadding="0" cellspacing="0" style="width:150px;"> 
            	<tr>
                	<td style="width:100px;"><strong>Total: </strong></td>
                    <td class="derecha">&nbsp;
						<?php 
							if($tutto < 0 and $tutto > -1){
								$tutto = 0;
							}
						echo number_format(($tutto - $total_itbs),2);
						?>
                    </td>
                </tr>
             	<tr>
                	<td style="width:100px;"><strong>ITBIS: </strong></td>
                    <td class="derecha"><?php echo number_format($total_itbs,2); ?></td>
                </tr>
             	<tr>
                	<td style="width:100px;"><strong>Total a pagar: </strong></td>
                    <td class="derecha"><strong>&nbsp;<?php echo number_format($tutto,2); ?></strong></td>
                </tr>
 
            </table>
        </td>
    </tr>
</table>
<span id="genera">Factura que genera creditos y lo sustenta Costos y Gastos</span>
<div id="firma">
	<p>Hecho por</p>
   	<p>Recibido por</p>
</div>



<div class="no">
<br />
<input type="button" value="Imprimir" onclick="window.print();" id="print" />  
<input type="button" value="Lista Cliente" onclick="window.open('cliente.php','_self');" id="print" />
</div>
</div>