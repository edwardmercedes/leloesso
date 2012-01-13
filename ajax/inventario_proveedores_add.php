<form action="process/add_inventario.php?table=inventario_proveedores" method="post">
<fieldset>
<legend>Agregar Proveedores</legend>
<table>
	<tr>
    	<td><label>Nombre:</label></td>
        <td><input type="text" name="nombre" /></td>
    </tr>

	<tr>
    	<td><label>Telefono:</label></td>
        <td><input type="text" name="telefono" /></td>
    </tr>

	<tr>
    	<td><label>Direccion:</label></td>
        <td><input type="text" name="direccion" /></td>
    </tr>

	<tr>
    	<td><label>Email:</label></td>
        <td><input type="text" name="email" /></td>
    </tr>

    
	<tr>
    	<td></td>
        <td><input type="submit" value="Agregar" class="control"/></td>
    </tr>

</table>
</fieldset>
</form>