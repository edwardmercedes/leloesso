<?php 
include 'include/head.php';
include 'conf/conn.php';

//ARTICULOS DEL SISTEMA detalles del item
$sql = '
SELECT 
	inventario_articulo.id_item AS id,
	inventario_articulo.articulo AS nombre,
	inventario_categoria.categoria AS categoria,
	inventario_marcas.nombre AS marca
	
FROM 
	inventario_articulo,
	inventario_categoria,
	inventario_marcas
WHERE 
	inventario_articulo.id_categoria = inventario_categoria.id_categoria AND
	inventario_articulo.id_marca = inventario_marcas.id_marca AND
	inventario_articulo.id_item = "'.$_GET['id'].'"
';
$items_sql = mysql_query($sql);
$items_sql = mysql_fetch_array(mysql_query($sql));

//EXISTENCIA DEL ITEM
$sql = "
SELECT 
	SUM(inventario_entrada.cantidad) AS entrada
FROM 
	inventario_entrada
WHERE 
	inventario_entrada.id_articulo = '".$_GET['id']."' 
";
$existencia_e = mysql_fetch_array(mysql_query($sql));
$sql = "
SELECT 
	SUM(inventario_salida.cantidad) AS salida
FROM 
	inventario_salida
WHERE 
	inventario_salida.id_articulo = '".$_GET['id']."'
";
$existencia_s = mysql_fetch_array(mysql_query($sql));


//ULTIMA SALIDA ULTIMA ENTRADA
$sql = "
SELECT 
	DATE_FORMAT(inventario_entrada.fecha,'%d/%m/%y') AS entrada_fecha,
	DATE_FORMAT(inventario_salida.fecha,'%d/%m/%y') AS salida_fecha
FROM 
	inventario_salida,
	inventario_entrada
WHERE 
	inventario_entrada.id_articulo = '".$_GET['id']."' AND
	inventario_salida.id_articulo = '".$_GET['id']."'
ORDER BY 
	entrada_fecha,salida_fecha
LIMIT 1	
";
$ultimo = mysql_fetch_array(mysql_query($sql));

//PROVEEDORES
$sql = "
SELECT 
	id_proveedor,nombre
FROM 
	inventario_proveedores
ORDER BY 
	nombre
";
$proveedores = mysql_query($sql);
?>

<script src="include/func.js" type="text/javascript"></script>

<fieldset>
<legend>Entrada al inventario: </legend>

<table>
	<tr>
    	<td width="250" valign="top">
        <fieldset>
        	<legend>Detalles del item</legend>
     	<table>
            	<tr>
                	<td><label>Nombre:</label> </td>
                    <td><strong><?php echo $items_sql['nombre']?></strong></td>
                </tr>
            	<tr>
                	<td><label>Marca:</label> </td>
                    <td><?php echo $items_sql['marca']?></td>
                </tr>
            	<tr>
                	<td><label>Categoria:</label> </td>
                    <td><?php echo $items_sql['categoria']?></td>
                </tr> 
            	<tr>
                	<td><label>Existencia:</label> </td>
                    <td><?php echo $existencia_e[0] - $existencia_s[0] ?></td>
                </tr>                                
            	<tr>
                	<td><label>Ultima Entrada:</label> </td>
                    <td><?php echo $ultimo[0] ?></td>
                </tr>                                
            	<tr>
                	<td><label>Ultima Salida:</label> </td>
                    <td><?php echo $ultimo[1] ?></td>
                </tr>                                

            </table>
        </fieldset>
        </td>
        
        <td valign="top" width="300">
        	<fieldset>
            <legend>Formulario de entrada </legend>
            
            <form id="agregar_inventario" method="post" action="process/add_inventario.php?table=inventario_entrada&url=../inventario.php">
            <input type="hidden" name="id_articulo" value="<?php echo $_GET['id'] ?>" />
            <input type="hidden" name="usuario" value="<?php echo $_SESSION['user'] ?>" />
                <table>
                    <tr>
                        <td>Cantidad:</td>
                        <td><input type="text" name="cantidad" style="width:50px;" autocomplete="off"/></td>
                    </tr>
                    <tr>
                        <td>Costo:</td>
                        <td><input type="text" name="costo"  style="width:50px;" autocomplete="off"/> <em>Precio de compra</em></td>
                    </tr>
                    <tr>
                        <td>Precio:</td>
                        <td><input type="text" name="precio" style="width:50px;" autocomplete="off"/>
                        <em>Precio de venta</em></td>
                    </tr>
                    <tr>
                        <td>Proveedor:</td>
                        <td>
                        	<select name="id_proedor">
                            	<option value="">Elegir</option>
                                <?php
								while($proveedor = mysql_fetch_array($proveedores)){
									echo '<option value="'.$proveedor[0].'">'.$proveedor[1].'</option>';
								}
								?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                    	<td></td>
                        <td>
                        <input type="button" value="Agregar" onclick="novacio_from('agregar_inventario')" class="control"/>
                        <input type="button" value="Cancelar" onclick="window.location='inventario.php'" class="control"/>
                        </td>
                    </tr>

                </table>
			</form>                
            </fieldset>
        </td>
        
        </td>
    </tr>
</table>


<?php
include 'include/footer.php';
?>
