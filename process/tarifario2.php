<?php 
include '../conf/conn.php';

switch($_GET['do']){
case'insert':
	mysql_query("INSERT INTO tarifario (tipo,valor) VALUES('".$_POST['nombre']."','".$_POST['precio']."')");
break;

case'edit':
	mysql_query("UPDATE tarifario SET
	tipo = '".$_POST['nombre']."',
	valor = '".$_POST['precio']."'
	WHERE ID_tarifario = '".$_GET['id']."'
	");
break;
}

header("Location: ../tarifario.php");
?>