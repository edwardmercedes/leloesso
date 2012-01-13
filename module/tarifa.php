<?php 
$regular = @mysql_fetch_array(@mysql_query("SELECT valor FROM  tarifario WHERE ID_tarifario = 1"));
$premium = @mysql_fetch_array(@mysql_query("SELECT valor FROM  tarifario WHERE ID_tarifario = 2"));
$diesel = @mysql_fetch_array(@mysql_query("SELECT valor FROM  tarifario WHERE ID_tarifario = 3"));
$ncf = @mysql_fetch_array(@mysql_query("SELECT info FROM inf_esso WHERE ID_INFO = 1"));
?>
<h1>Precio Combustible</h1>
<form method="post" action="process/tarifario.php">
<table border="0" cellpadding="0" cellspacing="0" class="masther">

<tr>
	<th>Regular</th>
    <th>Premium</th>
    <th>Diesel</th>
	<th>NCF Sufijo</th>
</tr>

<tr>
	<td><input type="text" name="regular" value="<?php echo $regular[0]; ?>"  style="width:100px;" autocomplete="off"/></td>
	<td><input type="text" name="premium" value="<?php echo $premium[0]; ?>" style="width:100px;" autocomplete="off"/></td>
    <td><input type="text" name="diesel" value="<?php echo $diesel[0]; ?>" style="width:100px;" autocomplete="off"/></td>
	<td><input type="text" name="ncf" value="<?php echo $ncf[0]; ?>" style="width:100px;" autocomplete="off"/></td>
</tr>

</table>
<br />
<input type="submit" value="Guardar" class="control"> | <input type="button" value="Cancelar" onclick="history.back(-1);" class="control">
</form>

<br /><br /><br />
<h1>Lista de Producto</h1>
<a href="tarifario_add.php">Agregar Producto</a>
<table border="0" cellpadding="0" cellspacing="0" class="masther">
<tr>
	<th>Nombre</th>
    <th>Precio</th>
    <th>Acciones</th>
</tr>
<?php
$productos = mysql_query("SELECT ID_tarifario,tipo,valor FROM tarifario WHERE ID_tarifario <> 1 AND ID_tarifario <> 2 AND ID_tarifario <> 3 ");
while($pro = mysql_fetch_array($productos)){
echo '
	<tr>
		<td>'.$pro['tipo'].'</td>
		<td>'.$pro['valor'].'</td>
		<td><a href="tarifario_edit.php?id='.$pro['ID_tarifario'].'" class="editar"><img src="images/edit.gif" /></a></td>
	</tr>
';
}
?>
</table>