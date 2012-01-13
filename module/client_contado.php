<script src="include/func.js" type="text/javascript"></script>
<?php
session_start();
//COMPROVAMOS LA EXISTENCIA DE SESSION
if(!$_SESSION['lelo']){
	$_SESSION['lelo'] = new contado;
}

//$_SESSION['lelo']->show();


//session_destroy();

?>
<input type="button" value="Agregar al Factura" id="contado_add_form.php?do=1" onclick="contado(this.id)"/>
<input type="button" value="Ver Factura" id="contado_show.php" onclick="contado(this.id)"/>
<div id="contado">
</div>