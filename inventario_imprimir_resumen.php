<?php 
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

<style type="text/css">
table{
	color:#000;
	border:1px solid #CCC;
	border-left:none;
	border-bottom:none;
}
table th{
	border:1px solid #CCC;
	border-top:none;
	border-right:none;
	padding:0 2px 0 2px;
}
table td{
	border:1px solid #CCC;
	border-top:none;
	border-right:none;
	padding:0 2px 0 2px;
}
p{
	text-align:center;
	margin:15px 0 15px 0;
}
</style>

<p>
	ESTACION ESSO PEDRO MANUEL BAEZ<BR />
    Informa existencia de Inventario<BR />
    Fecha: <?php echo date('d/m/Y'); ?>
    
</p>
<script type="text/javascript">
window.onload = print_();

function print_(){
	window.print();	
	window.close();
}
</script>
<table border="0" cellpadding="0" cellspacing="0" class="masther" align="center">
<tr>
	<th width="30">Cod</th>
    <th width="110">Categoria</th>
    <th width="100">Marca</th>
    <th width="180">Nombre</th>
    <th width="40">Exist</th>
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
    	</tr>
		
    <?php
	}
?>
</table>


<?php
include 'include/footer.php';
?>
