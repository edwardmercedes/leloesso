<?php 
session_start();
include '../conf/conn.php';

mysql_query("
UPDATE registro SET 
	fecha = '".$_POST['fecha']."',
	N_fact ='".$_POST['n_factura']."',
	ficha = '".$_POST['Ficha']."',
	Tipo_comb = '".$_POST['combustible']."',
	Precio_comb = '".$_POST['precio_combustible']."',
	Valor_fact = '".$_POST['valor']."',
	ID_user = '".$_SESSION['user']."'
WHERE ID = '".$_GET['fc']."'
");

header("Location: ../estado_cuenta.php?id=".$_GET['id']." ");
?>
