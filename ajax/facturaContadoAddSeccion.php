<?php
include '../include/class.php';
session_start(); 
include '../conf/conn.php';
	


$sql = mysql_fetch_array(mysql_query("SELECT ID_CLIENTE,nombre,RNC,direccion,telefono FROM clientes WHERE RNC = '".$_GET['id']."' "));


if($sql['RNC']== $_GET['id']){
	$_SESSION['a']->add_cliente($sql['ID_CLIENTE'],$sql['nombre'],$sql['RNC'],$sql['direccion'],$sql['telefono']);
}
?>