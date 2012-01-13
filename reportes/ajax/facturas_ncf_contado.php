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
	echo '<h1>Reporte: Facturas comprobantes fiscales al contando al '.$date_format[2].' de '.nombreMes($date_format[1]).' a&ntilde;o '.$date_format[0].'</h1>';
}
else{
	echo '<h1>Reporte General: Facturas comprobantes fiscales al contado</h1>';
}


if($_GET['fin'] and $_GET['inicio']){
//select la lista de cliente que son a creditos
$sql_cliente = mysql_query("
	SELECT clientes.ID_CLIENTE,clientes.nombre 
	FROM clientes,rnc 
	WHERE clientes.tipo = '2' AND clientes.ID_CLIENTE = rnc.ID_CLIENTE  AND fecha BETWEEN '".$_GET['inicio']."' AND DATE_ADD('".$_GET['fin']."', INTERVAL 1 DAY)
	GROUP BY ID_CLIENTE 
	ORDER BY clientes.nombre ");
}
else{
//select la lista de cliente que son a creditos
$sql_cliente = mysql_query("
	SELECT clientes.ID_CLIENTE,clientes.nombre 
	FROM clientes,rnc 
	WHERE clientes.tipo = '2' AND clientes.ID_CLIENTE = rnc.ID_CLIENTE 
	GROUP BY ID_CLIENTE 
	ORDER BY clientes.nombre ");
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
		$fac = mysql_query("SELECT ncf,tipo,valor,Fecha_registro FROM rnc WHERE ID_CLIENTE = '".$cliente_row['ID_CLIENTE']."' ");
		while($fac_row = mysql_fetch_array($fac)){
			
				if($fac_row['tipo']=='Gasolina Regular' or $fac_row['tipo']=='Gasolina Premium' or $fac_row['tipo']=='Diesel'){
					$valor = $valor + $fac_row['valor'];
				}
				else{
					$valor = $valor + $fac_row['valor'] + ($fac_row['valor'] * 0.16);
				}
				$ncf = $fac_row['ncf'];
				$fecha = $fac_row['Fecha_registro'];
		}
		echo '<tr>';
			echo '<td>'.$fecha.'</td>';
			echo '<td>'.$ncf.'</td>';
			echo '<td>'.$valor.'</td>';
		echo '</tr>';
	echo '</dd></table>';
}//0.1
?>
</dl>
