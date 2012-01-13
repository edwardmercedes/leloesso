<script type="text/javascript" src="datepicker/js/datepicker.js"></script>
<link href="datepicker/css/datePicker.css" rel="stylesheet" type="text/css">
<?php 
$client = @mysql_fetch_array(@mysql_query("SELECT nombre FROM clientes WHERE ID_CLIENTE = '".$_GET['id']."' "));
$banco_query = mysql_query("SELECT Nombre FROM bancos");
?>

<!-- <h1>Debito a: "<strong><?php echo $client[0]; ?></strong>"</h1>-->

<form method="post" action="process/debito.php?id=<?php echo $_GET['id']; ?>" id="form_vacio">
<table>

<tr>
	<td><label>Fecha:</label></td>
    <td><input type="text" id="fecha" name="fecha" value="<?php echo date('Y/m/d'); ?>" onClick="displayDatePicker('fecha', false, 'ymd', '/');" autocomplete="off"></td>
</tr>

<tr>
	<td><label>Valor cheque:</label></td>
    <td><input type="text" name="valor_cheque" autocomplete="off"></td>
</tr>

<tr>
	<td><label>No. Cheque:</label></td>
    <td><input type="text" name="n_cheque" autocomplete="off"></td>
</tr>

<tr>
	<td><label>Banco:</label></td>
    <td>
    	<select name="banco" style="width:147px;">
	        <option value="">Eliga Banco</option>
    	   	<?PHP 
			while($banco = @mysql_fetch_array($banco_query)){
				echo '<option value="'.$banco[0].'">'.$banco[0].'</option>';
			}
			?>
    	</select>
     </td>
</tr>


<tr>
	<td></td>
    <td><input type="button" value="Guardar" class="control" onclick="no_vacio_pagos()"> | <input type="reset" value="Cancelar" onclick="window.open('cliente.php','_self');" class="control"></td>
</tr>

</table>
</form>

<p><br /></p>

<h1>Ultimos Movimientos de: "<?php echo $client[0]; ?>"</h1>
<table border="0" cellpadding="0" cellspacing="0" class="masther">
<tr>
	<th>Fecha</th>
    <th>No. Factura</th>
    <th>Ficha</th>
    <th>Combustible</th>
    <th>Precio Comb.</th>
    <th>Valor Factura</th>
    <th>No. Cheque</th>
    <th>Valor Cheque</th>
</tr>

<?php 
$credito_QUERY = mysql_query("SELECT fecha,N_fact,ficha,Tipo_comb,Precio_comb,Valor_fact,N_cheque,V_cheque FROM registro WHERE ID_CLIENTE ='".$_GET['id']."' ORDER BY fecha desc LIMIT 10");
while($credito = mysql_fetch_array($credito_QUERY)){
echo '
	<tr>
		<td>'.$credito['fecha'].' &nbsp;</td>
		<td>'.$credito['N_fact'].' &nbsp;</td>
		<td>'.$credito['ficha'].' &nbsp;</td>
		<td>'.$credito['Tipo_comb'].' &nbsp;</td>
		<td>'.$credito['Precio_comb'].' &nbsp;</td>
		<td>'.$credito['Valor_fact'].' &nbsp;</td>
		<td>'.$credito['N_cheque'].' &nbsp;</td>
		<td>'.$credito['V_cheque'].' &nbsp;</td>
	</tr>
';
}
?>
</table>
