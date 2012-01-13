<?php 
include '../conf/conn.php';

//buscamos de la base de datos la categoria
$categoria_sql = mysql_query('SELECT categoria,id_categoria FROM inventario_categoria ORDER BY categoria');

//buscamos de la base de datos las marcas
$marcas_sql = mysql_query('SELECT id_marca,nombre FROM inventario_marcas ORDER BY nombre');
?>
<form action="process/add_inventario.php?table=inventario_articulo" method="post">
<fieldset>
<legend>Agregar articulo al inventario</legend>
<table>
	<tr>
    	<td><label>Articulo:</label></td>
        <td><input type="text" name="articulo" /></td>
    </tr>
    
	<tr>
    	<td><label>Categoria:</label></td>
        <td>
            <select name="id_categoria">
                <option value="">Elegir</option>
                <?php 
				while($row = mysql_fetch_array($categoria_sql)){
						echo '<option value="'.$row['id_categoria'].'">'.$row['categoria'].'</option>';
					}
				?>
            </select>
        </td>
    </tr>

	<tr>
    	<td><label>Marca:</label></td>
        <td>
			<select name="id_marca">
                <option value="">Elegir</option>
                <?php 
				while($row = mysql_fetch_array($marcas_sql)){
						echo '<option value="'.$row['id_marca'].'">'.$row['nombre'].'</option>';
					}
				?>
            </select>
		</td>
    </tr>
    
	<tr>
    	<td></td>
        <td><input type="submit" value="Agregar" class="control"/></td>
    </tr>

</table>
</fieldset>
</form>