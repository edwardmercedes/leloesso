<div id="datepick">
  <label>A&ntilde;o: </label> 
  	<select id="select_ano" onchange="un_ano(this.value)">
    <?php
    	if($_GET['ano']){
			echo '<option value="'.$_GET['ano'].'">'.$_GET['ano'].'&nbsp;</option>';
		}
		else{
			echo '<option value="'.date("Y").'">'.date("Y").'&nbsp;</option>';
		}
	?>
    	
        <option value="2009">2009&nbsp;</option>
        <option value="2010">2010&nbsp;</option>
        <option value="2011">2011&nbsp;</option>
        <option value="2012">2012&nbsp;</option>
        <option value="2013">2013&nbsp;</option>
    </select>
  <!-- <input type="button" value="Go" id="go" onclick="dosfecha();"> -->
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


if($_GET['ano']){
	echo '<h1>Reporte: Ventas Por mes en a&ntilde;o '.$_GET['ano'].'</h1>';
}
else{
	echo '<h1>Reporte: Ventas Por mes</h1>';
}

//* DECLARACION DE VARIABLES
$ventas=0;
$t_ventas=0;

/*
 	* hacemos el query para buscar las facturas y pagos
	* ordemanos el resultado por el mayor a menor
	* conel idcliente buscamos la informacion del cliente
*/
if($_GET['ano']){
	$sql = "
	SELECT SUM(Valor_fact)AS fact,MONTH(fecha) AS year
	FROM registro 
	WHERE YEAR(fecha) = '".$_GET['ano']."'
	GROUP BY MONTH(fecha)
	ORDER BY MONTH(fecha) ";
}
else{
	$sql = "
	SELECT SUM(Valor_fact)AS fact,MONTH(fecha) AS year
	FROM registro 
	GROUP BY MONTH(fecha)
	ORDER BY MONTH(fecha) ";
}


$suma = mysql_query($sql);
while ($row = mysql_fetch_array($suma)){
	if($_GET['ano']){
		$ano = mysql_query("
		SELECT SUM(Valor_fact)AS fact,Tipo_comb
		FROM registro 
		WHERE MONTH(fecha) = '".$row['year']."' AND YEAR(fecha) = '".$_GET['ano']."'
		GROUP BY Tipo_comb
		");		
	}
	else{
		$ano = mysql_query("
		SELECT SUM(Valor_fact)AS fact,Tipo_comb
		FROM registro 
		WHERE MONTH(fecha) = '".$row['year']."'
		GROUP BY Tipo_comb
		");	
	}
	
	while($fac = mysql_fetch_array($ano)){
		if($fac['Tipo_comb'] == 'Gasolina Regular' or $fac['Tipo_comb'] == 'Gasolina Premium' or $fac['Tipo_comb'] == 'Diesel'){
			$t_ventas= $t_ventas + $fac['fact'];
			
		}
		else{
			$t_ventas= $t_ventas + $fac['fact'] + ($fac['fact']*0.16);		
		}
	}
}
?>
<table border="1" cellpadding="0" cellspacing="0" id="table" width="400">
<tr>
	<th width="100">Mes</th>
    <th class="derecha">Ventas</th>
    <th class="derecha">Porcentaje</th>
</tr>
<?php 


$suma = mysql_query($sql);
while ($row = mysql_fetch_array($suma)){
	if($_GET['ano']){
		$ano = mysql_query("
		SELECT SUM(Valor_fact)AS fact,Tipo_comb
		FROM registro registro 
		WHERE MONTH(fecha) = '".$row['year']."' AND YEAR(fecha) = '".$_GET['ano']."'
		GROUP BY Tipo_comb
		");
	}
	else{
		$ano = mysql_query("
		SELECT SUM(Valor_fact)AS fact,Tipo_comb
		FROM registro registro 
		WHERE MONTH(fecha) = '".$row['year']."'
		GROUP BY Tipo_comb
		");
	}
		
	$ventas=0;
	while($fac = mysql_fetch_array($ano)){
		if($fac['Tipo_comb'] == 'Gasolina Regular' or $fac['Tipo_comb'] == 'Gasolina Premium' or $fac['Tipo_comb'] == 'Diesel'){
			$ventas= $ventas + $fac['fact'];
		}
		else{
			$ventas= $ventas + $fac['fact'] + ($fac['fact']*0.16);		
		}
	}

if($row['year']  > 0){
	echo '
	<tr>
		<td>&nbsp;'.nombreMes($row['year']).'</td>
		<td class="derecha">&nbsp;'.number_format($ventas,2).'</td>
		<td class="derecha">&nbsp;'.number_format(($ventas / $t_ventas)*100,2).' %</td>
	</tr>    
	';
}	


}
?>
<!-- MOSTRANDO LA SUMA -->
<tr>
	<td></td>
    <td colspan="2"><strong>Total de ventas = <?php echo number_format($t_ventas,2);?></strong></td>
</tr>

</table>
