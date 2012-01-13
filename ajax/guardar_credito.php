<?php 
include '../conf/conn.php';

$ncf_sql = mysql_fetch_array(mysql_query("SELECT nombre,info FROM inf_esso WHERE ID_INFO = 1"));
$ncf = $ncf_sql[1] + 1;

mysql_query("UPDATE inf_esso SET info = '".$ncf."' WHERE ID_INFO = 1 ");


mysql_query("
	INSERT INTO rnc (ncf,cc,ID_CLIENTE,ID_user,F_unicio,F_final,Fecha_registro)
	VALUES(
	 	'".$_GET['nrc']."',
		'1',
		'".$_GET['id_cliente']."',
		'".$_GET['id_user']."',
		'".$_GET['fecha']."',
		'".$_GET['fecha2']."',
		NOW()
	)
");
?>
