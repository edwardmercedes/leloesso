<?php
include 'include/class.php';
session_start();
//VAMOS A BUSCAR EL TITULO DE LA PAGINA
$titulo = $_SERVER['SCRIPT_NAME'];
$n_pag = basename($titulo, ".php");

if(!isset($_SESSION['user'])){
	if($n_pag!='index'){
		header("Location: index.php");
	}
}
else{
	if($n_pag=='index'){
		header("Location: home.php");
	}

}
if(!$_SESSION['a']){
	$_SESSION['a'] = new contado;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Estacion Esso :: Pedro Manuel Baez</title>
<link href="css/screnn.css" rel="stylesheet" type="text/css" media="screen"/>
<?php
$i = basename($_SERVER['PHP_SELF'],'.php');
if($i=='contado_index'){
echo '<link href="css/contado.css" rel="stylesheet" type="text/css" media="print"> ';	
}
else{
	echo '<link href="css/print.css" rel="stylesheet" type="text/css" media="print"> ';
}

?>

<script type="text/javascript" src="include/func.js"></script>
</head>
<body>


<?php
include 'include/funciones.php';

if(isset($_SESSION['user'])){
	?>
    <div id="header">
    	<h1>PEDRO MANUEL BAEZ<br /><span>ESTACION ESSO</span> </h1>
	   	<p>Usuario: <strong> <?php echo $_SESSION['user'] ?> </strong> <a href="process/login.php?do=close">(salir)</a></p>
        <a href="index.php" class="logo" title="Ir al home"></a>
    </div>
	<?php 
	include 'include/menu.php';
}
?>
