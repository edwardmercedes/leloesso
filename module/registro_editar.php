<?php 
$client = @mysql_fetch_array(@mysql_query("SELECT nombre FROM clientes WHERE ID_CLIENTE = '".$_GET['id']."' "));
$row = mysql_fetch_array(mysql_query("
SELECT fecha,N_fact,ficha,Tipo_comb,Precio_comb,Valor_fact FROM registro WHERE ID = '".$_GET['fc']."'
"));

?>
<h1>Editar Credito a: "<strong><?php echo $client[0]; ?></strong>"</h1>

<form method="post" action="process/registro_edit.php?id=<?php echo $_GET['id']; ?>&fc=<?php echo $_GET['fc']; ?>">
<table>

<tr>
	<td><label>Fecha:</label></td>
    <td><input type="text" name="fecha" value="<?php echo $row['fecha']; ?>" autocomplete="off"> </td>
</tr>


<tr>
	<td><label>No. Factura:</label></td>
    <td><input type="text" name="n_factura" value="<?php echo $row['N_fact']; ?>" autocomplete="off"></td>
</tr>


<tr>
	<td><label>Ficha:</label></td>
    <td><input type="text" name="Ficha" value="<?php echo $row['ficha']; ?>" autocomplete="off"></td>
</tr>

<tr>
	<td><label>Combustible:</label></td>
    <td>
    	<select name="combustible">
        <option value="<?php echo $row['Tipo_comb']; ?>"><?php echo $row['Tipo_comb']; ?></option>
        <?php 
	        $comb_str = mysql_query("SELECT tipo FROM tarifario WHERE tipo <> '".$row['Tipo_comb']."' ");
			while($com_row = mysql_fetch_array($comb_str))
			{
			echo '<option value="'.$com_row[0].'">'.$com_row[0].'</option>';
			};
		?>
        </select>
    </td>
</tr>


<tr>
	<td><label>Precio Comb.:</label></td>
    <td>
    	<select name="precio_combustible">
        <option value="<?php echo $row['Precio_comb']; ?>"><?php echo $row['Precio_comb']; ?></option>
        <?php 
	        $valor_str = mysql_query("SELECT valor FROM tarifario WHERE valor <> '".$row['Precio_comb']."' ");
			while($valor_row = mysql_fetch_array($valor_str))
			{
			echo '<option value="'.$valor_row[0].'">'.$valor_row[0].'</option>';
			};
		?>
        </select>
    </td>
</tr>

<tr>
	<td><label>Valor Fact:</label></td>
    <td><input type="text" name="valor" value="<?php echo $row['Valor_fact']; ?>" autocomplete="off"></td>
</tr>

<tr>
	<td></td>
    <td><input type="submit" value="Guardar" class="control"> | <input type="reset" value="Cancelar" onclick="history.back(-1);" class="control"></td>
</tr>

</table>
</form>


<h1>Ultimos Creditos de: "<?php echo $client[0]; ?>"</h1>
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
$credito_QUERY = mysql_query("SELECT fecha,N_fact,ficha,Tipo_comb,Precio_comb,Valor_fact,N_cheque,V_cheque,balance FROM registro WHERE ID_CLIENTE ='".$_GET['id']."' ORDER BY fecha desc LIMIT 5");
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