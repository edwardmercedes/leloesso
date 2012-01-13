<?php
include '../conf/conn.php';

switch($_GET['do']){

case 'login':
$USER = @mysql_fetch_array(mysql_query("SELECT username,pass,Nombre FROM login WHERE username = '".$_POST['Username']."' and nivel <> 0 "));

	if($USER['pass'] != $_POST['Password']){
		header ('Location: ../index.php');
	}
	else{
		session_start();
		$_SESSION['user'] = $USER['Nombre'];
		header ('Location: ../home.php');
	}
break;
	
case 'close':
	session_start(); 
	$_SESSION = array(); 
	session_destroy(); 
	header ("Location: ../index.php");		
break;
}	

?>
