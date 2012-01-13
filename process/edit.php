<?php
include '../conf/conn.php';
	$campos='';
	$valores = '';
	
	foreach($_POST as $key => $valor){
		if(!empty($key) and !empty($valor)){
				$campos.=$key."='".$valor."'," ;
		}
	}
	$campos = substr($campos,0,-1);
		
	$sql = "UPDATE ".$_GET['table']." SET ".$campos." WHERE ".$_GET['campo_id']." = '".$_GET['id']."' ";
	
	mysql_query($sql);

if($_GET['lo']!=''){
	header('Location: '.$_GET['lo'].'');	
}	
else{
	header('Location: '.$_SERVER['HTTP_REFERER'].'');	
}
?>