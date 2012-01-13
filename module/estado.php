<?php 
//informacion del cliente
$client = @mysql_fetch_array(@mysql_query("SELECT nombre,telefono,direccion,RNC FROM clientes WHERE ID_CLIENTE = '".$_GET['id']."' "));

//balance anterior
$bal_str="SELECT 
	SUM(Valor_fact) AS credito,SUM(V_cheque) AS debito
	FROM registro 
	WHERE ID_CLIENTE = '".$_GET['id']."' And fecha <=  LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";
$blc = @mysql_fetch_array(@mysql_query($bal_str));

$balance = $blc[0] - $blc[1];

$balance_anterio = $balance ;


$fecha = @mysql_fetch_array(@mysql_query("SELECT UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) "));
//echo date("d",$fecha[0]);
?>

<div id="informacion">
	<h1><?php echo $client[0]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1>
	<span><?php echo $client[2]; ?></span><br />
	<span><?php echo $client[1]; ?></span>
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
	<td colspan="9">Balance al <?php fecha($fecha[0]); ?></td>
    <td class="derecha"><?php echo number_format($balance,2); ?></td>
</tr>
<?php 
$credito_QUERY = @mysql_query("SELECT ID,DATE_FORMAT(fecha,'%d-%m-%Y') AS fecha,N_fact,ficha,Tipo_comb,Precio_comb,Valor_fact,N_cheque,V_cheque,balance FROM registro WHERE ID_CLIENTE ='".$_GET['id']."' And MONTH(CURDATE()) = MONTH(fecha)  ORDER BY fecha ");
while($credito = @mysql_fetch_array($credito_QUERY)){
echo '<tr>';
//la opcion para editar
if($credito['Valor_fact']!=NULL){
	echo '<td>'.$credito['fecha'].' <a href="credito_edit.php?id='.$_GET['id'].'&fc='.$credito['ID'].'" class="editar"><img src="images/edit.gif" /></a></td>';
}
elseif($credito['V_cheque']!=NULL){
	echo '<td>'.$credito['fecha'].' <a href="debito_edit.php?id='.$_GET['id'].'&fc='.$credito['ID'].'" class="editar"><img src="images/edit.gif" /></a></td>';
}
	
	echo '<td>'.$credito['N_fact'].' &nbsp;</td>';
	echo '<td>'.$credito['ficha'].' &nbsp;</td>';
//BUSCANDO LOS GALONES	
	if($credito['Precio_comb']!=NULL and $credito['Valor_fact']!=NULL){
		echo '<td>'.number_format($credito['Valor_fact']/$credito['Precio_comb'],2).' &nbsp;</td>';
	}
	else{
		echo '<td>&nbsp;</td>';
	}
//ABREVIENDO EL TIPO DE COMBUSTIBLE	
	switch($credito['Tipo_comb']){
		case'Gasolina Regular':
			$tipo ='Gasol. Reg.';
		break;
		case 'Gasolina Premium':
			$tipo ='Gasol. Prem.';	
		break;
		default:
			$tipo =$credito['Tipo_comb'];
		break;	
	}
	echo '<td>'.$tipo.' &nbsp;</td>';
	echo '<td class="derecha">'.$credito['Precio_comb'].' &nbsp;</td>';
	echo '<td class="derecha">'.$credito['Valor_fact'].' &nbsp;</td>';
	echo '<td>'.$credito['N_cheque'].' &nbsp;</td>';
	echo '<td class="derecha">'.$credito['V_cheque'].' &nbsp;</td>';
	
//Hacemos el balance	
	if($credito['Valor_fact']!=NULL){
		$balance = $balance + $credito['Valor_fact'];
	}
	elseif($credito['V_cheque']!=NULL){
		$balance = $balance - $credito['V_cheque'];
	}
	echo '<td class="derecha">'.number_format($balance,2).'&nbsp;</td>';	
	
echo '</tr>';
}
?>
</table>



<br />
<h1>Resumen Consumo de Combustible</h1>
<table cellpadding="0" cellspacing="0" class="masther">
<tr>
	<th>Cantidad</th>
    <th>Unidad <br />Medida</th>
    <th>Descripcion</th>
    <th>Precio <br />Unidad</th>
    <th>ITBS</th>
    <th>Total</th>
</tr>
<?php 
$resumen_srt= "SELECT Tipo_comb,Precio_comb, SUM(Valor_fact)as valor FROM registro WHERE ID_CLIENTE ='".$_GET['id']."' And MONTH(CURDATE()) = MONTH(fecha) and Valor_fact > 1 GROUP BY Precio_comb";
$resumen_query = @mysql_query($resumen_srt);
while($row = @mysql_fetch_array($resumen_query)){
$total = $total+$row[2];
$camtidad = 0;
//SINO ES COMBUSTIBLE
if($row[0]!='Gasolina Regular' and $row[0]!='Gasolina Premium' and $row[0]!='Diesel'){
$camtidad = $camtidad + 1;
$itbs = $row[2] * 0.16;
	echo '<tr>';
		echo '<td>'.$camtidad.'</td>';
		echo '<td> </td>';
		echo '<td>'.$row[0].'</td>';
		echo '<td>'.number_format($row[2], 2).'</td>';
		echo '<td>'.number_format($itbs,2).'</td>';
		echo '<td class="derecha">'.number_format($row[2]+$itbs,2).'</td>';
	echo '</tr>';
}
//si es un combustible
else{
	echo '<tr>';
		echo '<td>'.number_format($row[2]/$row[1],3).'</td>';
		echo '<td>GLS</td>';
		echo '<td>'.$row[0].'</td>';
		echo '<td>'.$row[1].'</td>';
		echo '<td>'.E.'</td>';
		echo '<td class="derecha">'.number_format($row[2],2).'</td>';
	echo '</tr>';
}

}
//total
echo '
	<tr>
		<td colspan="5"></td>
	    <td class="derecha">'.number_format($total+$itbs,2).'</td>
	</tr>
';
?>
</table>
<br />
<input type="button" value="Imprimir" onclick="window.print();" id="print" />  
<input type="button" value="Lista Cliente" onclick="window.open('cliente.php','_self');" id="print" />

