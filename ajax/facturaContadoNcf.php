<?php 
include '../include/class.php';
session_start();
include '../conf/conn.php';

$sql = mysql_fetch_array(mysql_query("SELECT ID_NCF FROM rnc WHERE ncf = '".$_GET['id']."' "));
if($sql[0]){
	echo 'no';
}
else{
	$_SESSION['a']->add_ncf($_GET['id']);
}
?>