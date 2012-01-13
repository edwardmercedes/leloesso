<?php 
include '../conf/conn.php';

switch($_GET['do']){

//EN CASO QUE SEA INSERTAR UN CLIENT
case 'insert':	
mysql_query("INSERT INTO clientes
	(nombre,direccion,telefono,celular,contacto,RNC,fecha,Comentario) VALUES
	(
		'".$_POST['nombre']."',
		'".$_POST['direccion']."',
		'".$_POST['Telefono']."',
		'".$_POST['cell']."',
		'".$_POST['contact']."',
		'".$_POST['rnc']."',
		NOW(),
		'".$_POST['comentario']."'
	);
");
break;

//EN CASO QUE SEA EDITAR UN CLIENT
case 'edit':	
	$srt = "
	UPDATE clientes SET 
		nombre = '".$_POST['nombre']."',
		direccion = '".$_POST['direccion']."',
		telefono = '".$_POST['Telefono']."',
		celular = '".$_POST['cell']."',
		contacto = '".$_POST['contact']."',
		RNC = '".$_POST['rnc']."',
		Comentario = '".$_POST['comentario']."',
		email = '".$_POST['email']."'
	WHERE ID_CLIENTE = '".$_GET['id']."'
	";
	mysql_query($srt);
break;

}

header("Location: ../home.php");

?>