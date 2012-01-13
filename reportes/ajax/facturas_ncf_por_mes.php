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

<dl id="dl_informacion">
<?php
include '../../conf/conn.php';
include '../include/funciones.php';

if($_GET['ano']){
	echo '<h1>Reporte: Facturas por mes en el a&ntilde;o '.$_GET['ano'].'</h1>';
}
else{
	echo '<h1>Reporte General: Facturas por mes</h1>';
}

//agrupamos los anos 
if($_GET['ano']){
$sql_no = mysql_query("
	SELECT MONTH(Fecha_registro) AS mes 
	FROM rnc 
	WHERE YEAR(Fecha_registro) = '".$_GET['ano']."'
	GROUP BY MONTH(Fecha_registro) 
	ORDER BY Fecha_registro ");
}
else{
$sql_no = mysql_query("
	SELECT MONTH(Fecha_registro) AS mes 
	FROM rnc 
	GROUP BY MONTH(Fecha_registro) 
	ORDER BY Fecha_registro ");
}



while($year_row = mysql_fetch_array($sql_no)){

	echo '<dt>'.nombreMes($year_row['mes']).'</dt><br>';
	if($_GET['ano']){
		$ncf_sql = mysql_query("
			SELECT ncf,cc,ID_CLIENTE,DATE_FORMAT(Fecha_registro,'%m/%d/%y') as fecha 
			FROM rnc 
			WHERE MONTH(Fecha_registro) = '".$year_row['mes']."' AND YEAR(Fecha_registro) = '".$_GET['ano']."'
			GROUP BY ncf 
			ORDER BY ncf");
	}
	else{
		$ncf_sql = mysql_query("
			SELECT ncf,cc,ID_CLIENTE,DATE_FORMAT(Fecha_registro,'%m/%d/%y') as fecha 
			FROM rnc 
			WHERE MONTH(Fecha_registro) = '".$year_row['mes']."' 
			GROUP BY ncf 
			ORDER BY ncf");
	}

	
	
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
