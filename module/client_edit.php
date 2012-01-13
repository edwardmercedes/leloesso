<?php 
$row = @mysql_fetch_array(@mysql_query("SELECT * FROM clientes WHERE ID_CLIENTE = '".$_GET['id']."' "));
?>
<h1>Editar Informacion de ::  <?php echo $row['nombre']; ?></h1>
<form method="post" action="process/client_insert.php?do=edit&id=<?php echo $_GET['id'] ?>">
<table>

<tr>
	<td><label>Nombre:</label></td>
    <td><input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" autocomplete="off"></td>
</tr>

<tr>
	<td><label>Direccion:</label></td>
    <td><input type="text" name="direccion" value="<?php echo $row['direccion']; ?>" autocomplete="off" ></td>
</tr>

<tr>
	<td><label>Telefeno:</label></td>
    <td><input type="text" name="Telefono" value="<?php echo $row['telefono']; ?>" autocomplete="off"></td>
</tr>

<tr>
	<td><label>Celular:</label></td>
    <td><input type="text" name="cell" value="<?php echo $row['celular']; ?>" autocomplete="off"></td>
</tr>

<tr>
	<td><label>Pers. Contacto:</label></td>
    <td><input type="text" name="contact" value="<?php echo $row['contacto']; ?>" autocomplete="off"></td>
</tr>

<tr>
	<td><label>RNC:</label></td>
    <td><input type="text" name="rnc" value="<?php echo $row['RNC']; ?>" autocomplete="off"></td>
</tr>

<tr>
	<td><label>Email:</label></td>
    <td><input type="text" name="email" value="<?php echo $row['email']; ?>" autocomplete="off"></td>
</tr>

<tr>
	<td><label>Comentario:</label></td>
    <td><textarea name="comentario"><?php echo $row['Comentario']; ?></textarea></td>
</tr>

<tr>
	<td></td>
    <td><input type="submit" value="Salvar" class="control"> |  <input type="button" value="Cancelar" onclick="window.open('cliente.php','_self');" class="control"></td>
</tr>

</table>
</form>