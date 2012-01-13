<?php 
include '../conf/conn.php';

mysql_query("
UPDATE registro SET 
	fecha = '".$_POST['fecha']."',
	N_cheque = '".$_POST['n_cheque']."',
	V_cheque = '".$_POST['valor_cheque']."',
	banco = '".$_POST['banco']."'
WHERE ID = '".$_GET['fc']."'
");

header("Location: ../estado_cuenta.php?id=".$_GET['id']." ");
?>
