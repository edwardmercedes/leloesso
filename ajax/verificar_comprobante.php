<?php 
include '../include/class.php';
session_start();
include '../conf/conn.php';

$sql = mysql_fetch_array(mysql_query("SELECT ID_NCF FROM rnc WHERE ncf = '".$_GET['id']."' "));
if($sql[0]){
	echo '<p style="color:#FF0000;">Este NCF se uso anteriormente, por favor Cambielo</p>';
}
else{
	$_SESSION['a']->add_ncf($_GET['id']);
	echo '<p style="color:#fff;">Se agrego Comprobante Fiscal a la factura</p>';
}
?>