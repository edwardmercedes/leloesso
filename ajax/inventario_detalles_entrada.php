<?php 
include '../conf/conn.php';
include '../include/funciones.php';

//BUSCANDO LOS DETALLES DE SALIDA
$sql = "
SELECT 
	id_entrada,
	cantidad,
	costo,
  	precio,
	DATE_FORMAT(fecha,'%d/%m/%Y') as date
FROM 
	inventario_entrada
";

//si tengo año y mes
if($_GET['ano']!='' and $_GET['mes']!=''){
	$sql.= "
		WHERE 	
		id_articulo	= '".$_GET['id']."' AND
		DATE_FORMAT(fecha,'%Y') = '".$_GET['ano']."'  AND
		DATE_FORMAT(fecha,'%m') = '".$_GET['mes']."'
	";	
}
//uno de los dos ano o mes
elseif($_GET['ano']!='' or $_GET['mes']!=''){//ve si hay uno lleno
	
	if($_GET['ano']!=''){ //si solo tengo el agno
			$sql.= "
			WHERE 	
				id_articulo	= '".$_GET['id']."' AND
				DATE_FORMAT(fecha,'%Y') = '".$_GET['ano']."'
			";		
	}
	else{ //si nolo tenog el mes
		$sql.= "
			WHERE 	
			id_articulo	= '".$_GET['id']."' AND
			 DATE_FORMAT(fecha,'%m') = '".$_GET['mes']."'
		";			
	}
}
else{
	$sql.= "
		WHERE 	
		id_articulo	= '".$_GET['id']."'
	";	
}
//fin de agno y mes

	
$sql.= "	
ORDER BY  fecha
";

$datetalle = mysql_query($sql);

//SELECT AÑO
$sql = "SELECT DATE_FORMAT(fecha,'%Y') AS ano FROM inventario_salida GROUP BY ano ORDER BY ano DESC";
$anos = mysql_query($sql);

//SELECT Mes
$sql = "SELECT DATE_FORMAT(fecha,'%m') AS mes FROM inventario_salida GROUP BY mes ";
$meses = mysql_query($sql);
?>


<?php 
if($_GET['s']){
	
}
else{?>
	

<fieldset>
	<legend>Perzonalizar detalles de Entrada</legend>
    <form method="get" id="perzonalizar">
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
    <table>
    	<tr>
        	<td>A&ntilde;o:</td>
            <td>
            	<select name="ano" style="width:100px;">
                <option value="">Todos</option>
                    <?php 
					while($ano = mysql_fetch_array($anos)){
						echo '<option value="'.$ano[0].'">'.$ano[0].'</option>';	
					}
					?>
                </select>
            </td>
            <td width="50">&nbsp;</td>
        	<td>Mes:</td>
            
            <td>
            	<select name="mes" style="width:100px;">
                	<option value="">Todos</option>
                    <?php 
					while($mes = mysql_fetch_array($meses)){
						echo '<option value="'.$mes[0].'">'.nombreMes($mes[0]).'</option>';	
					}
					?>
                </select>
            </td>
             <td width="50">&nbsp;</td>
			<td><input type="button" value="Perzonalizar" class="control" onclick="pesonar('perzonalizar','e')" /></td>
        </tr>
    </table>
  </form>
</fieldset>


<h2 style="color:#FFF;">Detalles de Entrada de inventario</h2>
<?php    
}
?>
<div id="cargar_dos">
<table border="0" cellpadding="0" cellspacing="0" class="masther">
	<tr>
    	<th>Codigo <br /> Entada</th>
        <th>Fecha</th>              
        <th>Cantidad</th>
        <th>Precio Unid.</th>
        <th>SubTotal</th>
        <th>ITBIS</th>
        <th>TOTAL</th>
    </tr>   
<?php 
	while($row = mysql_fetch_array($datetalle)){
		$total_registro = $row['precio'] * $row['cantidad'];
		$itbis_registro = $total_registro * 0.16;
		
		//totales
		$cantidad_t = $cantidad_t + $row['cantidad'];
		$sub_t = $sub_t + $total_registro;
		$itbis_t = $itbis_t + $itbis_registro;
		$total_t = $total_t + $total_registro;
	?>
		
        <tr>
            <td>100-<?php echo $row['id_entrada'] ?></td>
            <td><?php echo $row['date'] ?></td>  
            <td><?php echo $row['cantidad'] ?></td>
            <td><?php echo number_format($row['precio'],2) ?></td>
            <td><?php echo number_format($total_registro,2)?></td>
            <td><?php echo number_format($itbis_registro,2) ?></td>
            <td><?php echo number_format($total_registro + $itbis_registro,2) ?></td>
        </tr>     
                
    <?php	
	}
?>    

        <tr>
            <td colspan="2"><strong>Sumatoria</strong></td>
            <td><strong><?php echo $cantidad_t; ?></strong></td>
            <td><strong></strong></td>
            <td><strong><?php echo number_format($sub_t,2); ?></strong></td>
            <td><strong><?php echo number_format($itbis_t,2); ?></strong></td>
            <td><strong><?php echo number_format($total_t + $itbis_t,2) ?></strong></td>
        </tr>     
</table>
</div>