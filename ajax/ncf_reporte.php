<?php 
include '../include/class.php';
include '../conf/conn.php';

/*
    * CONTRUIMOS LA CONDIGO SQL
	* UN ARRAY CON LOS GET Y LO CONDICIONAMOS EN FILTROS + AND
	* LE QUITAMOS EL AND AL ULTIMO CONDICION
	
*/
$filtros='';
foreach($_GET as $indice => $valor) {
	if ($valor!=''){
		$filtros.="$indice='$valor' AND ";
	}
}	
if ($filtros!='') {
	$filtros=substr($filtros,0,strlen($filtros)-5); //se quita ultimo -AND-
}
/* TENEMOS EL FILTRO PREPARADO Y LISTO PARA EJECUTAR*/
//HACEMOS LA CONSULTA SQL
$sql_select = "SELECT ID_NCF,ID_CLIENTE,ncf,cc,DATE_FORMAT(Fecha_registro, '%m %d %Y') as fecha,Fecha_registro ";
$sql_from = "FROM rnc ";
if($filtros!=''){
	$sql_where = "WHERE ".$filtros." ";
}
else{
	$sql_where = '';
}
$sql_group = "GROUP BY ncf ";
$sql_order = "ORDER BY Fecha_registro Desc, ncf LIMIT 20";

$nrc_sql = mysql_query($sql_select.$sql_from.$sql_where.$sql_group.$sql_order);
?>

<table cellpadding="0" cellspacing="0" border="1" class="masther" width="717">
	<tr>
    	<th>Fecha</th>
    	<th>Cliente</th>
        <th>NCF</th>
        <th>RNC</th>
        <th>Credito</th>
		<th class="print">Funciones</th>
    </tr>
<?php
while($row = mysql_fetch_array($nrc_sql)){
//selec CLIENTE
$cliente = mysql_fetch_array(mysql_query("SELECT nombre,RNC FROM clientes WHERE ID_CLIENTE = '".$row['ID_CLIENTE']."' "));
//TIPO DE FACTURA CREDITO CONTADO
if($row['cc']==1){
	$tipo_cafactura = '<img src="images/productoagregado.gif" />';
}
else{
	$tipo_cafactura = '<img src="images/productonoagregado.gif" />';
}
echo '<tr>';
	echo'<td>'.$row['fecha'].'</td>';
	echo'<td>'.$cliente['nombre'].'</td>';
    echo'<td>'.$row['ncf'].'</td>';
    echo'<td>'.$cliente['RNC'].'</td>';
    echo'<td>'.$tipo_cafactura.'</td>';
	if($row['cc']==1){
		echo'<td class="print"></td>';	
	}
	else{
		?>
		<td class="print"><a href="#" onclick="abrirPopUp('pre_2.php?id=<?php echo $row['ncf'] ?>','500','300','Factura al contado')">Imprimir</a></td>
        <?php
	}
echo '</tr>';
}
?>    

</table>  
