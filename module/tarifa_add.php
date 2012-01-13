<h1>Agregar al Tarifario</h1>
<form method="post" action="process/tarifario2.php?do=insert">
<table>
<tr>
	<td><label>Nombre:</label></td>
    <td><input type="text" name="nombre" autocomplete="off"/></td>
</tr>
<tr>
	<td><label>Precio:</label></td>
    <td><input type="text" name="precio" autocomplete="off"/></td>
</tr>

<tr>
	<td></td>
    <td><input type="submit" value="Agregar" class="control"/> | <input type="button" value="Cancelar" onclick="window.open('tarifario.php','_self');" class="control"/></td>
</tr>
</table>
</form>