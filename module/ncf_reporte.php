<script type="text/javascript" src="include/func.js"></script>
<?php 
/*
 * buscar valores de la db
 * llenar select
*/
$usuario_sql = mysql_query("SELECT ID_user,Nombre FROM login");//llenar los usuario select
$nrc_sql = mysql_query("SELECT ID_NCF,ID_CLIENTE,ncf,cc,DATE_FORMAT(Fecha_registro, '%m %d %Y') as fecha,Fecha_registro,F_unicio,F_final FROM rnc GROUP BY ncf ORDER BY Fecha_registro DESC,ncf DESC LIMIT 20");
?>
<fieldset class="print" id="ncf_fieldset">
<legend>Criterios para buscar Facturas</legend>
<form id="form">
<table>
<tr>
	<td><label>NCF: </label><input type="text" id="ncf" name="ncf" onkeyup="buscar_ncf()" autocomplete="off" style="width:150px;"/></td>
	<td><label>Codigo Cliente: </label><input type="text" id="cliente" name="ID_CLIENTE" onkeyup="buscar_ncf()" autocomplete="off" style="width:150px;"/></td>
   	<td><label>Tipo fact: </label> 
       	<select onchange="buscar_ncf()" name="cc" style="width:150px;">
	        <option value="">No importa</option>
    		<option value="2">Contado</option>
            <option value="1">Credito</option>
	    </select>
    </td>
  	<td><label>Por usuario: </label>
    	<select onchange="buscar_ncf()" name="ID_user" style="width:150px;">
        <option value="">No definido</option>
        <?PHP
        	while ($usuario_row = mysql_fetch_array($usuario_sql)){
				echo '<option value="'.$usuario_row[1].'">'.$usuario_row[1].'</option>';
			}
		?>
	    </select>
    </td>   
</tr>
</table>
<br />
</form>        

<label>Nombre de cliente :</label><input type="text" id="input_cliente" onkeyup="ncf_lista_cliente(this.value)"/>
	<div id="ncf_lista_cliente">

	</div>
</fieldset>

<?php
//llamamos la funcion header for printi Const_header que recive el titulo del documento
Const_header("Reporte Numero Comprobantes Fiscal","");
?>




<div id="informacion_ncf_lista">
<table cellpadding="0" cellspacing="0" border="1" class="masther" width="717">
	<tr>
    	<th>Fecha</th>
    	<th>Cliente</th>
        <th>NCF</th>
        <th>RNC</th>
        <th>Credito</th>
		<th class="print">Funciones</th>
    </tr>
<?php
while($row = mysql_fetch_array($nrc_sql)){
//selec CLIENTE
$cliente = mysql_fetch_array(mysql_query("SELECT nombre,RNC,ID_CLIENTE FROM clientes WHERE ID_CLIENTE = '".$row['ID_CLIENTE']."' "));
//TIPO DE FACTURA CREDITO CONTADO
if($row['cc']==1){
	$tipo_cafactura = '<img src="images/productoagregado.gif" />';
}
else{
	$tipo_cafactura = '<img src="images/productonoagregado.gif" />';
}
echo '<tr>';
	echo'<td>'.$row['fecha'].'</td>';
	echo'<td>'.$cliente['nombre'].'</td>';
    echo'<td>'.$row['ncf'].'</td>';
    echo'<td>'.$cliente['RNC'].'</td>';
    echo'<td>'.$tipo_cafactura.'</td>';
	if($row['cc']==1){
		?>
		<td class="print"><a href="#" onclick="abrirPopUp('facturaCredito/credito.php?id=<?php echo $cliente['ID_CLIENTE'] ?>&fecha=<?php echo $row['F_unicio'] ?>&fecha2=<?php echo $row['F_final'] ?>&ncf=<?php echo $row['ncf'] ?>&impresion=<?php echo $row['fecha'] ?>','20','20','Factura Creditos')"><img src="images/pinrt.jpg" height="25" /></a></td>
	<?php
    }
	else{
		?>
		<td class="print"><a href="#" onclick="abrirPopUp('pre_2.php?id=<?php echo $row['ncf'] ?>','500','300','Factura Contado')"><img src="images/pinrt.jpg" height="25" /></a></td>
        <?php
	}
	
echo '</tr>';
}
?>    

</table>  
</div>
