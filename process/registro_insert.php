<?php 
include '../conf/conn.php';
$bal = @mysql_fetch_array(@mysql_query("SELECT balance FROM registro WHERE ID_CLIENTE = '".$_GET['id']."' ORDER BY fecha DESC LIMIT 1 "));
$balance = $bal[0] + $_POST['valor'];

mysql_query("INSERT INTO registro
	(fecha,N_fact,ficha,Tipo_comb,Precio_comb,Valor_fact,balance,ID_CLIENTE,ID_user) 
	VALUES(
		'".$_POST['fecha']." ".date("H:i:s")."',
		'".$_POST['n_factura']."',
		'".$_POST['Ficha']."',
		'".$_POST['combustible']."',
		'".$_POST['precio_combustible']."',
		'".$_POST['valor']."',
		'".$balance."',
		'".$_GET['id']."',
		'".$_SESSION['user']."'
	);
");
header("Location: ../index.php");
?>