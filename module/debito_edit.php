<?php 
$client = @mysql_fetch_array(@mysql_query("SELECT nombre FROM clientes WHERE ID_CLIENTE = '".$_GET['id']."' "));

$row = mysql_fetch_array(mysql_query("SELECT fecha,N_cheque,V_cheque,banco FROM registro WHERE ID = '".$_GET['fc']."'"));

//bancos
$banco_query = mysql_query("SELECT Nombre FROM bancos WHERE Nombre <> '".$row['banco']."' ");
$banco = mysql_fetch_array(mysql_query("SELECT Nombre FROM bancos WHERE Nombre = '".$row['banco']."' "));
?>
<h1>Debito a: "<strong><?php echo $client[0]; ?></strong>"</h1>

<form method="post" action="process/debito_edit.php?id=<?php echo $_GET['id']; ?>&fc=<?php echo $_GET['fc']; ?>">
<table>

<tr>
	<td><label>Fecha:</label></td>
    <td><input type="text" name="fecha" value="<?php echo $row['fecha']; ?>" autocomplete="off"></td>
</tr>


<tr>
	<td><label>No. Cheque:</label></td>
    <td><input type="text" name="n_cheque" value="<?php echo $row['N_cheque']; ?>" autocomplete="off"></td>
</tr>


<tr>
	<td><label>Valor cheque:</label></td>
    <td><input type="text" name="valor_cheque" value="<?php echo $row['V_cheque']; ?>"autocomplete="off" ></td>
</tr>

<tr>
	<td><label>Banco:</label></td>
    <td>
    	<select name="banco" style="width:147px;">
        <?PHP 
	       echo '<option value="'.$banco[0].'">'.$banco[0].'</option>';
   	   	
			while($banco = @mysql_fetch_array($banco_query)){
				echo '<option value="'.$banco[0].'">'.$banco[0].'</option>';
			}
			?>
    	</select>
     </td>
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
    <th>Balance</th>
</tr>

<?php 
$credito_QUERY = mysql_query("SELECT fecha,N_fact,ficha,Tipo_comb,Precio_comb,Valor_fact,N_cheque,V_cheque,balance FROM registro WHERE ID_CLIENTE ='".$_GET['id']."' ORDER BY fecha ");
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
		<td>'.$credito['balance'].'&nbsp;</td>
	</tr>
';
}
?>
</table>