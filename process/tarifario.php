<?php 
include '../conf/conn.php';

mysql_query("UPDATE tarifario SET valor='".$_POST['regular']."' WHERE ID_tarifario = 1");
mysql_query("UPDATE tarifario SET valor='".$_POST['premium']."' WHERE ID_tarifario = 2 ");
mysql_query("UPDATE tarifario SET valor='".$_POST['diesel']."' WHERE ID_tarifario = 3");

mysql_query("UPDATE inf_esso SET info='".$_POST['ncf']."' WHERE ID_INFO = 1 ");

header("Location: ../index.php");

?>