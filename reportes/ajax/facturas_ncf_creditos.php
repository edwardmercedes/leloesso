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


<dl id="dl_informacion">
<?php
include '../../conf/conn.php';
include '../include/funciones.php';

/*
	*Title reporte
*/
if($_GET['fin']){
	$date_format = explode("-",$_GET['fin']);
	echo '<h1>Reporte: Facturas comprobantes fiscales a creditos al '.$date_format[2].' de '.nombreMes($date_format[1]).' a&ntilde;o '.$date_format[0].'</h1>';
}
else{
	echo '<h1>Reporte General: Facturas comprobantes fiscales a creditos</h1>';
}

echo '<br>';

//select la lista de cliente que son a creditos
if($_GET['fin']){
$sql_cliente = mysql_query("
	SELECT clientes.ID_CLIENTE,clientes.nombre 
	FROM clientes,rnc 
	WHERE clientes.tipo <> '2' AND clientes.ID_CLIENTE = rnc.ID_CLIENTE  AND fecha BETWEEN '".$_GET['inicio']."' AND DATE_ADD('".$_GET['fin']."', INTERVAL 1 DAY)
	GROUP BY ID_CLIENTE 
	ORDER BY clientes.nombre 
	");
}
else{
$sql_cliente = mysql_query("
		SELECT clientes.ID_CLIENTE,clientes.nombre 
		FROM clientes,rnc 
		WHERE clientes.tipo <> '2' AND clientes.ID_CLIENTE = rnc.ID_CLIENTE 
		GROUP BY ID_CLIENTE 
		ORDER BY clientes.nombre 
		");
}

while($cliente_row = mysql_fetch_array($sql_cliente)){//0.1

	echo '<dt>'.$cliente_row['nombre'].'</dt>';
	echo '
		<dd>
		<table>
		<tr>
			<th>Fecha</th>
			<th>NCF</th>
			<th>Monto</th>
		</tr>
	';
	$fac = mysql_query("SELECT ncf,F_unicio,F_final,DATE_FORMAT(Fecha_registro,'%d-%m-%Y') as Fecha_registro FROM rnc WHERE ID_CLIENTE = '".$cliente_row['ID_CLIENTE']."' ");
	while($fac_row = mysql_fetch_array($fac)){
		
		$monto_sql = mysql_query("SELECT Tipo_comb,Valor_fact FROM registro WHERE ID_CLIENTE = '".$cliente_row['ID_CLIENTE']."' ");
		while($monto = mysql_fetch_array($monto_sql)){
			if($monto['Tipo_comb']=='Gasolina Regular' or $monto['Tipo_comb']=='Gasolina Premium' or $monto['Tipo_comb']=='Diesel'){
				$valor = $valor + $monto['Valor_fact'];
			}
			else{
				$valor = $valor + $monto['Valor_fact'] + ($monto['Valor_fact'] * 0.16);
			}
		}
		
		echo '<tr>';
			echo '<td>'.$fac_row['Fecha_registro'].'</td>';
			echo '<td>'.$fac_row['ncf'].'</td>';
			echo '<td>'.$valor.'</td>';
		echo '</tr>';
	}
	echo '</dd></table>';
		
}//0.1
?>
</dl>
