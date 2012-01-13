<script type="text/javascript" src="datepicker/js/datepicker.js"></script>
<link href="datepicker/css/datePicker.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function llenar(){
	select_ = document.getElementById("tipo");
	input = document.getElementById("text");
	var indiceSeleccionado = select_.selectedIndex;
	var opcionSeleccionada = select_.options[indiceSeleccionado];
	input.value = opcionSeleccionada.id;
}
</script>
<?php 
$client = @mysql_fetch_array(@mysql_query("SELECT nombre FROM clientes WHERE ID_CLIENTE = '".$_GET['id']."' "));
?>
<h1>Factura a: "<strong><?php echo $client[0]; ?></strong>"</h1>

<form method="post" action="process/registro_insert.php?id=<?php echo $_GET['id']; ?>" id="no_vacio_fact">
<table>

<tr>
	<td><label>Fecha:</label></td>
    <td><input type="text" name="fecha" value="<?php echo date('Y/m/d'); ?>" onClick="displayDatePicker('fecha', false, 'ymd', '/');"></td>
</tr>


<tr>
	<td><label>No. Factura:</label></td>
    <td><input type="text" name="n_factura" autocomplete="off"></td>
</tr>


<tr>
	<td><label>Ficha:</label></td>
    <td><input type="text" name="Ficha" autocomplete="off"></td>
</tr>

<tr>
	<td><label>Tipo Combustible:</label></td>
    <td>
    	<select name="combustible" id="tipo" onchange="llenar()">
        <option value="">Elegir Combustible</option>
        <?php 
	        $comb_str = mysql_query("SELECT tipo,valor FROM tarifario");
			while($com_row = mysql_fetch_array($comb_str))
			{
			echo '<option value="'.$com_row[0].'" id="'.$com_row[1].'">'.$com_row[0].'</option>';
			};
		?>
        </select>
    </td>
</tr>


<tr>
	<td><label>Precio Combustible:</label></td>
    <td><input type="text" name="precio_combustible" id="text" autocomplete="off"/></td>
</tr>

<tr>
	<td><label>Valor Factura:</label></td>
    <td><input type="text" name="valor" autocomplete="off"></td>
</tr>

<tr>
	<td></td>
    <td><input type="button" value="Guardar" class="control" onclick="no_vacio_fact()"> | <input type="reset" value="Cancelar" onclick="window.open('cliente.php','_self');" class="control"></td>
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
		<td class="derecha">'.number_format($credito['Valor_fact'],2).' &nbsp;</td>
		<td>'.$credito['N_cheque'].' &nbsp;</td>
		<td class="derecha">'.number_format($credito['V_cheque'],2).' &nbsp;</td>
	</tr>
';
}
?>
</table>
