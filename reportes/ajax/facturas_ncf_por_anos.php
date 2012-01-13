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


<h1>Reporte: Facturas de comprobantes Fiscal por a&ntilde;o </h1>
<dl id="dl_informacion">
<?php
include '../../conf/conn.php';

//agrupamos los anos 
$sql_no = mysql_query("SELECT YEAR(Fecha_registro) AS year FROM rnc GROUP BY YEAR(Fecha_registro) ORDER BY Fecha_registro ");
while($year_row = mysql_fetch_array($sql_no)){

	echo '<dt>'.$year_row['year'].'</dt><br>';

	$ncf_sql = mysql_query("SELECT ncf,cc,ID_CLIENTE,DATE_FORMAT(Fecha_registro,'%m/%d/%y') as fecha FROM rnc WHERE YEAR(Fecha_registro) = '".$year_row['year']."' GROUP BY ncf ORDER BY ncf");
	echo '<dd>';					
		echo '<table>';
			echo '<tr>';
				echo '<th>NCF</th>';
				echo '<th>Credito</th>';
				echo '<th>Cliente</th>';
				echo '<th>RNC</th>';
				echo '<th>Fecha</th>';
			echo '</tr>';
	while($ncf_row = mysql_fetch_array($ncf_sql)){
		//informacion del cliente
		$cliente_sql = mysql_fetch_array(mysql_query("SELECT nombre,RNC FROM clientes WHERE ID_CLIENTE = '".$ncf_row['ID_CLIENTE']."' "));
		echo '<tr>';
			echo '<td>'.$ncf_row['ncf'].'</td>';
			echo '<td>'.$ncf_row['cc'].'</td>';
			echo '<td>'.$cliente_sql['nombre'].'</td>';
			echo '<td>'.$cliente_sql['RNC'].'</td>';
			echo '<td>'.$ncf_row['fecha'].'</td>';
		echo '</tr>';
	}
	echo '</table>';
	echo '</dd>';							
}

?>
</dl>

