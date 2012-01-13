<?php
include '../conf/conn.php';
include '../include/class.php';
session_start();

switch($_GET['do'])	{
	case'add':
	//agregamos cliente a la base de datos
	mysql_query("INSERT INTO clientes (nombre,direccion,telefono,RNC,fecha,tipo) 
		VALUES (
			'".$_POST['nombre']."',
			'".$_POST['Direccion']."',
			'".$_POST['Telefono']."',
			'".$_POST['rnc']."',
			NOW(),
			'2'
			)
		");
	//AGREGAMOS EL NOMBRE AL OBJETO		
	$id = mysql_fetch_array(mysql_query("SELECT ID_CLIENTE FROM clientes WHERE RNC = '".$_POST['rnc']."' "));
	$_SESSION['a']->add_cliente($id[0],$_POST['nombre'],$_POST['rnc'],$_POST['Direccion'],$_POST['Telefono']);
	header("Location: ../contado_index.php");
	break;
}
?>