<?php 
include '../conf/conn.php';
$bal = @mysql_fetch_array(@mysql_query("SELECT balance FROM registro WHERE ID_CLIENTE = '".$_GET['id']."' ORDER BY fecha DESC LIMIT 1 "));
$balance = $bal[0] - $_POST['valor_cheque'];

mysql_query("INSERT INTO registro
	(fecha,N_cheque,V_cheque,banco,ID_CLIENTE,ID_user) 
	VALUES(
		'".$_POST['fecha']." ".date("H:i:s")."',
		'".$_POST['n_cheque']."',
		'".$_POST['valor_cheque']."',
		'".$_POST['banco']."',
		'".$_GET['id']."',
		'".$_SESSION['user']."'
	);
");
header("Location: ../index.php");
?>