<?php
$e = mysql_fetch_array(mysql_query("SELECT tipo,valor FROM  tarifario WHERE ID_tarifario = '".$_GET['id']."' "));
?>
<h1>Editar al Tarifario</h1>
<form method="post" action="process/tarifario2.php?do=edit&id=<?php echo $_GET['id']; ?>">
<table>
<tr>
	<td><label>Nombre:</label></td>
    <td><input type="text" name="nombre" value="<?php echo $e[0]; ?>" autocomplete="off"/></td>
</tr>
<tr>
	<td><label>Precio:</label></td>
    <td><input type="text" name="precio" value="<?php echo $e[1]; ?>" autocomplete="off"/></td>
</tr>

<tr>
	<td></td>
    <td><input type="submit" value="Guardar" class="control"/> | <input type="button" value="Cancelar" onclick="window.open('tarifario.php','_self');" class="control"/></td>
</tr>
</table>
</form>