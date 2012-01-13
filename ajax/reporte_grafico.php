<h1>Grafico</h1>
<?php
sleep(1);

include '../conf/conn.php';
//BUSCAR NOMBRES
$nombre_query = mysql_query("SELECT ID_CLIENTE FROM clientes ");

//SUMA GERERAL DE TODOS LOS DATOS PARA BUSCAR EL %
$sql_total = mysql_fetch_array(mysql_query("SELECT SUM(Valor_fact) as facturas FROM registro "));


while($client = mysql_fetch_array($nombre_query)){
//SELECT LOS DATOS EPARADO PARA BUSCAR PORCIENTO
	$sql_query = mysql_query("SELECT SUM(Valor_fact) as facturas FROM registro WHERE ID_CLIENTE ='".$client[0]."' GROUP BY ID_CLIENTE ");
	while($row = mysql_fetch_array($sql_query)){
		$ciento = ($row[0] / $sql_total[0])*100;
		$w = round($ciento*10);
		echo '<p>'.$client[0].' / '.$row[0].' -<span style="width:'.$w.'px; background:#FF0000;display:inline-block;">&nbsp;</span> '.number_format($ciento,2).'%'.'</p>';
	}
}
?>