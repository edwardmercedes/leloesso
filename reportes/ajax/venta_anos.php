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
 
<h1>Reporte: Ventas por a&ntilde;os </h1>
<?php
include '../../conf/conn.php';

//* DECLARACION DE VARIABLES
$ventas=0;
$t_ventas=0;

/*
 	* hacemos el query para buscar las facturas y pagos
	* ordemanos el resultado por el mayor a menor
	* conel idcliente buscamos la informacion del cliente
*/
$sql = "
SELECT SUM(Valor_fact)AS fact,YEAR(fecha) AS year
FROM registro 
GROUP BY YEAR(fecha)
ORDER BY SUM(Valor_fact) DESC";

$suma = mysql_query($sql);
while ($row = mysql_fetch_array($suma)){
	$ano = mysql_query("
	SELECT SUM(Valor_fact)AS fact,Tipo_comb
	FROM registro where YEAR(fecha) = '".$row['year']."'
	GROUP BY Tipo_comb
	");
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
<table border="1" cellpadding="0" cellspacing="0" id="table" width="300">
<tr>
	<th width="50">A&ntilde;o</th>
    <th class="derecha">Ventas</th>
    <th class="derecha">Porcentaje</th>
</tr>
<?php 


$suma = mysql_query($sql);
while ($row = mysql_fetch_array($suma)){
	$ano = mysql_query("
	SELECT SUM(Valor_fact)AS fact,Tipo_comb
	FROM registro registro where YEAR(fecha) = '".$row['year']."'
	GROUP BY Tipo_comb
	");
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
		<td>&nbsp;'.$row['year'].'</td>
		<td class="derecha">&nbsp;'.number_format($ventas,2).'</td>
		<td class="derecha">&nbsp;'.number_format(($ventas / $t_ventas)*100,2).' %</td>
	</tr>    
	';
}	


}
?>
<!-- MOSTRANDO LA SUMA -->
<tr>
	<td>&nbsp;</td>
    <td colspan="2" class="derecha"><strong>Total de ventas = <?php echo number_format($t_ventas,2);?></strong></td>
</tr>

</table>
