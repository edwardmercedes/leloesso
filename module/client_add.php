<h1>Informacion del  Nuevo Cliente</h1>
<form method="post" action="process/client_insert.php?do=insert">
<table>

<tr>
	<td><label>Nombre:</label></td>
    <td><input type="text" name="nombre" autocomplete="off"></td>
</tr>

<tr>
	<td><label>Direccion:</label></td>
    <td><input type="text" name="direccion" autocomplete="off"></td>
</tr>

<tr>
	<td><label>Telefeno:</label></td>
    <td><input type="text" name="Telefono" autocomplete="off"></td>
</tr>

<tr>
	<td><label>Celular:</label></td>
    <td><input type="text" name="cell" autocomplete="off"></td>
</tr>

<tr>
	<td><label>Pers. Contacto:</label></td>
    <td><input type="text" name="contact" autocomplete="off"></td>
</tr>

<tr>
	<td><label>RNC:</label></td>
    <td><input type="text" name="rnc" autocomplete="off"></td>
</tr>

<tr>
	<td><label>Comentario:</label></td>
    <td><textarea name="comentario"></textarea></td>
</tr>

<tr>
	<td></td>
    <td><input type="submit" value="Registrar" class="control"> |  <input type="button" value="Cancelar" onclick="window.open('cliente.php','_self');" class="control"></td>
</tr>

</table>
</form>