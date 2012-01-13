<?php
include '../include/class.php';
session_start();

switch($_GET['do']){
	case 'insert':
		$_SESSION['a']->add($_POST['nombre'],$_POST['precio'],$_POST['valor']);
		header("Location: ../contado_index.php");
	break;
	
	case 'edit':
		$_SESSION['a']->edit($_GET['id'],$_POST['nombre'],$_POST['precio'],$_POST['valor']);
		header("Location: ../contado_index.php");
	break;

	case 'delete':
		$_SESSION['a']->delete($_GET['id']);
		header("Location: ../contado_index.php");
	break;
}
?>
