<?php 
//si no existe ncf
if(!$_GET['id']){?>
<script type="text/javascript">
	window.open('ncf_reporte.php','_self')
</script>
<?php
}
//SI EXISTE EL NCF

//vamos aver si es al contado o a credito
$cc = mysql_fetch_array(mysql_query("SELECT cc FROM rnc WHERE ncf = '".$_GET['id']."' "));
if($cc[0]==1){
	include 'tools/cargar_factura_credito.php';
}
else{
	include 'tools/cargar_factura_contado.php';
}
?>
