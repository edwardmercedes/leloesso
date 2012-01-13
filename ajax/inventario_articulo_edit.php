<?php 
include '../conf/conn.php';

//ARTICULOS DEL SISTEMA detalles del item
$sql = '
SELECT 
		id_marca,id_categoria,articulo
FROM 
		inventario_articulo
WHERE 
		id_item = "'.$_GET['id'].'"
';
$items_sql = mysql_query($sql);
$articulo = mysql_fetch_array(mysql_query($sql));

//buscamos de la base de datos la categoria
$categoria_sql = mysql_query("SELECT categoria,id_categoria FROM inventario_categoria WHERE id_categoria <> '". $articulo['id_categoria']."' ORDER BY categoria");

$cact = mysql_fetch_array(mysql_query("SELECT categoria FROM inventario_categoria WHERE id_categoria = '". $articulo['id_categoria']."' "));

//buscamos de la base de datos las marcas
$marcas_sql = mysql_query("SELECT id_marca,nombre FROM inventario_marcas WHERE id_marca <> '". $articulo['id_marca']."' ORDER BY nombre");
$ac_mar = mysql_fetch_array(mysql_query("SELECT nombre FROM inventario_marcas WHERE id_marca = '". $articulo['id_marca']."' "));
?>
<form action="process/edit.php?table=inventario_articulo&campo_id=id_item&id=<?php echo $_GET['id'] ?>&lo=../inventario.php" method="post">
<fieldset>
<legend>Modificar Articulo</legend>
<table>
	<tr>
    	<td><label>Articulo:</label></td>
        <td><input type="text" name="articulo" value="<?php echo $articulo['articulo']; ?>" /></td>
    </tr>
    
	<tr>
    	<td><label>Categoria:</label></td>
        <td>
            <select name="id_categoria">
                <option value="<?php echo $articulo['id_categoria']; ?>"><?php echo $cact[0] ?></option>
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
                <option value="<?php echo $articulo['id_marca']; ?>"><?php echo $ac_mar[0] ?></option>
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
        <td>
        	<input type="submit" value="Guardar" class="control"/>
            <input type="button" value="Cancelar" onclick="window.location='inventario.php'" class="control"/>
        </td>
    </tr>

</table>
</fieldset>
</form>