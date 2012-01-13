<?php 
include 'include/head.php';
include 'conf/conn.php';

//ARTICULOS DEL SISTEMA
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
	inventario_articulo.id_marca = inventario_marcas.id_marca
ORDER BY marca,nombre
';
$items_sql = mysql_query($sql);
?>

<script src="include/func.js" type="text/javascript"></script>

<div id="funciones">
<a href="#" onclick="cargarContenido_get('ajax/inventario_articulo_add','cargar')">+ Articulo</a>
<a href="#" onclick="cargarContenido_get('ajax/inventario_proveedores_add','cargar')">+ Proveedores</a>
<a href="#" onclick="cargarContenido_get('ajax/inventario_cat_add.php','cargar')">+ Categoria</a> 
<a href="#" onclick="cargarContenido_get('ajax/inventario_mar_add','cargar')">+ Marca</a>
<a href="#" onclick="abrirPopUp('inventario_imprimir_resumen.php','10','10','Inventario')">Imprimir Resumen</a>
</div>

<div id="cargar" style="width:300px;">

</div>

<!-- llenar con los ajax-->
<div id="list_clients">
<table border="0" cellpadding="0" cellspacing="0" class="masther">
<tr>
	<th>Cod</th>
    <th>Categoria</th>
    <th>Marca</th>
    <th>Nombre</th>
    <th>Existencia</th>
    <th></th>
</tr>
<?php 
	while($item = mysql_fetch_array($items_sql)){
//EXISTENCIA DEL ITEM
$sql = "
	SELECT SUM(inventario_entrada.cantidad) AS entrada 
	FROM inventario_entrada 
	WHERE inventario_entrada.id_articulo = '".$item['id']."' ";
$existencia_e = mysql_fetch_array(mysql_query($sql));

$sql = "
SELECT SUM(inventario_salida.cantidad) AS salida
FROM inventario_salida
WHERE inventario_salida.id_articulo = '".$item['id']."'
";
$existencia_s = mysql_fetch_array(mysql_query($sql));		

?>
    
        <tr>
            <td><?php echo $item['id']; ?></td>
            <td><?php echo $item['categoria']; ?></td>
            <td><?php echo $item['marca']; ?></td>
            <td><?php echo $item['nombre']; ?></td>
            <td>
            <?php 
				echo $existencia_e[0] - $existencia_s[0];
			?>
            </td>
            <td>
            <a href="inventario_entrada.php?id=<?php echo $item['id']; ?>">Entrada</a> | 
            <a href="inventario_salida.php?id=<?php echo $item['id']; ?>">Salida</a> | 
            <a href="inventario_detalles.php?id=<?php echo $item['id']; ?>">Detalles</a>  
            </td>
    	</tr>
		
    <?php
	}
?>
</table>
</div>


<?php
include 'include/footer.php';
?>
