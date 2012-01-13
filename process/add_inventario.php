<?php
include '../conf/conn.php';
	$campos='';
	$valores = '';
	
	foreach($_POST as $key => $valor){
		if(!empty($key) and !empty($valor)){
				$campos.=$key.',';
				$valores.="'".$valor."'".',';
		}
	}
	$campos = substr($campos,0,-1);
	$valores = substr($valores,0,-1);
	
	$sql = "INSERT INTO ".$_GET['table']." (".$campos.") VALUES(".$valores.")";
	mysql_query($sql);

if($_GET['url']){
	header('Location: '.$_GET['url'].' ');	
}
else{
	header('Location: '.$_SERVER['HTTP_REFERER'].' ');	
}	
?>