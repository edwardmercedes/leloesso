<?php 
if(isset($_GET['f1'])!= '' and isset($_GET['f2'])!=''):
	list($inicioAno,$inicioMes,$inicioDia,) = explode('-',$_GET['f1']);
	list($finAno,$finMes,$finDia,) = explode('-',$_GET['f2']);
else:
	list($inicioAno,$inicioMes,$inicioDia,) = explode('-',date('Y-m-d', strtotime('-1 month')));
	list($finAno,$finMes,$finDia,) = explode('-',date('Y-m-d'));
endif;

//sumar un dia al a fecha de fin 
$finMTime = mktime(0, 0, 0, $finMes, $finDia, $finAno) + (24*60*60);
list($finAno,$finMes,$finDia,) = explode('-',date('Y-m-d',$finMTime));


$inicio = $inicioAno.'-'.$inicioMes.'-'.$inicioDia;
$fin = $finAno.'-'.$finMes.'-'.$finDia;

include '../conf/conn.php';
include '../include/funciones.php';

?>
<link type="text/css" href="css.css" rev="stylesheet" rel="stylesheet" />

<div style="text-align:center; width:500px;">
<p>Reporte Numero de Comprobante Fiscal<br>
<?php 
$mostrarFecha = mktime(0, 0, 0, $finMes, $finDia, $finAno) - (24*60*60);

echo $inicioDia.' '.nombreMes($inicioMes).' '.$inicioAno;
echo ' al ';
echo date('d',$mostrarFecha).' '.nombreMes(date('m',$mostrarFecha)).' '.date('Y',$mostrarFecha);
echo '</p>';
?>

</div>

<table border="1" cellpadding="0" cellspacing="0" class="masther">
<tr>
	<th>Fecha</th>
    <th>Cliente</th>
    <th>Numero Comprobante Fiscal</th>
</tr>

<?php
//VAMOS A BUSCAR TODOS LOS NUMEROS DEL COMPROBANTES FISCAL
$sql = "SELECT R.ncf AS ncf, C.nombre AS nombre,DATE_FORMAT(R.Fecha_registro,'%d / %m / %Y')  AS fecha ";
$sql.= 'FROM rnc AS R, clientes AS C ';
$sql.= 'WHERE R.ID_CLIENTE = C.ID_CLIENTE AND ';
$sql.= "R.Fecha_registro BETWEEN '".$inicio."' AND '".$fin."'  ";
$sql.= 'GROUP BY ncf ';
$sql.= "ORDER BY R.Fecha_registro DESC,ncf DESC ";

$numeroComprobanFiscalQuery = mysql_query($sql);	

while($row = mysql_fetch_array($numeroComprobanFiscalQuery)){
	?>
    <tr>
        <td><?php echo $row['fecha'] ?></td>
        <td><?php echo $row['nombre'] ?></td>
        <td><?php echo $row['ncf'] ?></td>
	</tr>
    <?php		
}
?>
</table>