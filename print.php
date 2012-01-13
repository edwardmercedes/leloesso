<?php 
$link = mysql_connect('localhost','root','admin');
$db = mysql_select_db("esso",$link);


$datos = mysql_query("SELECT * FROM clientes WHERE tipo = 2 ");

while($row = mysql_fetch_array($datos)){
	echo $row['telefono'];
}

//mysql_query("DELETE FROM rnc WHERE cc = 2 ");
?>