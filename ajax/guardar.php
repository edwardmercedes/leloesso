<?php 
include '../include/class.php';
session_start();
include '../conf/conn.php';

$ncf_sql = mysql_fetch_array(mysql_query("SELECT nombre,info FROM inf_esso WHERE ID_INFO = 1"));
$ncf = $ncf_sql[1] + 1;

mysql_query("UPDATE inf_esso SET info = '".$ncf."' WHERE ID_INFO = 1 ");

$_SESSION['a']->guardar();
unset($_SESSION['a']);

header("Location: ../contado_index.php");
?>
