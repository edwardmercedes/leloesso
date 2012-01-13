<script type="text/javascript" src="datepicker/js/datepicker.js"></script>
<link href="datepicker/css/datePicker.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="include/func.js"></script>

<form method="get" class="print" name="fechas_reporte">
<label>Fecha de Inicio:</label>
	<input type="text" name="fecha" value="<?php echo $_GET['fecha'] ?>" onClick="displayDatePicker('fecha', false, 'ymd', '-');" style="width:100px;" autocomplete="off"/> 
    <label>Hasta</label>
    <input type="text" name="fecha2" value="<?php echo $_GET['fecha2'] ?>" onClick="displayDatePicker('fecha2', false, 'ymd', '-');" style="width:100px;" autocomplete="off"/>
	<p>
    <label>Clientes a Creditos </label><input type="radio" value="report_balance.php" name="tipo_repor" checked="checked" class="radio"/>
    <label>&nbsp;&nbsp;&nbsp;Cuentas Incobrables </label><input type="radio" value="report_incobrables.php" name="tipo_repor" class="radio"/>
    <label>&nbsp;&nbsp;&nbsp;Comprobantes Fiscales </label><input type="radio" value="report_ncf.php" name="tipo_repor" class="radio"/>
    
    </p>
<P>
	<input type="button" value="Click aqui para Crear Reporte"  class="botoncito" onclick="tipo_gerenal_report()" style="width:300px;" />
</P>
</form>
<!--
AQUI VAMOS A CAMBIAR LA INFORMACION
 -->

<div id="tipo_reporte_general">


</div>

