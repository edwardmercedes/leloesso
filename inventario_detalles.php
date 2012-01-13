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
<script type="text/javascript">
function pesonar(form_id,pag){
	
	ulr =form(form_id);
	if(pag=='s'){
		cargarContenido_get('ajax/inventario_detalles_salida.php?s=true&'+ulr,'cargar_dos');	
	}
	else{
		cargarContenido_get('ajax/inventario_detalles_entrada.php?s=true&'+ulr,'cargar_dos');	
	}
}
</script>

<input type="button" value="<< Ir al inventario" style="border:1px solid #060084;padding:5px 2px;background:#D4D0C8;" onclick="window.location='inventario.php'" class="control"/>

<fieldset>
<legend>Detalles informativos del Item</legend>
<table class="master">
	<tr>
    	<td align="right">Codigo:</td>
        <td><strong><?php echo $items_sql['id'] ?></strong></td>
        <td width="20"></td>
    	<td align="right">Nombre:</td>
        <td><strong><?php echo $items_sql['nombre'] ?></strong></td>
        <td width="20"></td>        
    	<td align="right">Marca:</td>
        <td><strong><?php echo $items_sql['marca'] ?></strong></td>
        <td width="20"></td>        
    	<td align="right">Categoria:</td>
        <td><strong><?php echo $items_sql['categoria'] ?></strong></td>
        <td width="20"></td>        
    	<td align="right">Existencia:</td>
        <td><?php echo $existencia_e[0] - $existencia_s[0] ?></td>
    </tr>    
</table>
</fieldset>

<div id="funciones">
<a href="#" onclick="cargarContenido_get('ajax/inventario_detalles_salida.php?id=<?php echo $items_sql['id']; ?>','cargar')">Detalles de Salidas</a>
<a href="#" onclick="cargarContenido_get('ajax/inventario_detalles_entrada.php?id=<?php echo $items_sql['id']; ?>','cargar')">Detalles de Entradas</a>

<a href="#" onclick="cargarContenido_get('ajax/inventario_articulo_edit.php?id=<?php echo $items_sql['id']; ?>','cargar')">Modificar Item</a>

</div>

<div id="cargar" style="width:300px;">

</div>

<?php
include 'include/footer.php';
?>
