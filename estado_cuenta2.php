<?php 
session_start();
//VAMOS A BUSCAR EL TITULO DE LA PAGINA
$titulo = $_SERVER['SCRIPT_NAME'];
$n_pag = basename($titulo, ".php");

if(!$_SESSION['user']){
	if($n_pag!='index'){
		header("Location: index.php");
	}
}
else{
	if($n_pag=='index'){
		header("Location: home.php");
	}
}
?>
<link rel="stylesheet" href="css/screnn2.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/print2.css" type="text/css" media="print" />
<?php 
//include 'include/head.php';
include 'conf/conn.php';
include 'module/estado_cuenta2.php';
include 'include/footer.php';
?>
