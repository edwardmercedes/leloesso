<?php
$link = mysql_connect("localhost","root","admin");
$db = mysql_select_db("cdc",$link);

$da = mysql_fetch_array(mysql_query("SELECT DATE_ADD(curdate(), INTERVAL 2 DAY) "));
echo $da[0];

?>