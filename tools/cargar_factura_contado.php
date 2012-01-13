<script type="text/javascript" src="include/func.js"></script>
<?php 
$total_g = '';
$total = '';
$itbs = '';
$itbs_t = '';


$cc = mysql_fetch_array(mysql_query("SELECT ID_NCF,ncf,cc,ID_CLIENTE,DATE_FORMAT(Fecha_registro, '%m/%d/%Y') as fecha FROM rnc WHERE ncf = '".$_GET['id']."' "));

//informacion del cliente
$client = @mysql_fetch_array(@mysql_query("SELECT nombre,telefono,direccion,RNC FROM clientes WHERE ID_CLIENTE = '".$cc['ID_CLIENTE']."' "));

//lista de la informacion de la factura
$fac_ = mysql_query("SELECT tipo,precio,valor FROM rnc WHERE ncf = '".$_GET['id']."' ");

?>
<!-- Informacion del cliente para impresion -->
<div id="informacion">
	<h1><strong>Cliente:</strong> <?php echo $client['nombre']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1>
	<span><strong>Direcci&oacute;n: </strong> <?php echo $client[2]; ?></span> <br />   
    <span><strong>RNC: </strong> <?php echo $client['RNC']; ?></span><br />
    <span><strong>Tel.: </strong><?php echo $client[1]; ?></span><br />
    <span><strong>NCF.: </strong><?php echo $_GET['id']; ?></span><br /><br />
    
    <span>NOTA:</span><br>Re-impresi&oacute;n de factura, <?php echo date("m/d/Y"); ?>, la factura original fue impresa en fecha de <?php echo $cc['fecha']; ?>
</div>

<table border="1" cellpadding="0" cellspacing="0" class="masther" id="table_contado" width="500">
<tr>
    <th>Combustible</th>
    <th>Precio</th>
    <th>Valor</th>
    <th>ITBIS</th>
    <th>Total</th>
</tr>
<?php
while($fact = mysql_fetch_array($fac_)){
	if($fact['tipo']=='Gasolina Regular' or $fact['tipo']=='Gasolina Premium' or $fact['tipo']=='Diesel'){
		$total = $total + $fact['valor'];
		$itbs = 0;
	}
	else{
		$itbs = $fact['valor'] * 0.16;
		$total = $total + $fact['valor'] + $itbs;
		$itbs_t = $itbs_t + $itbs;
	}

	echo '<tr>';
		echo '<td>'.$fact['tipo'].'</a></td>';
		echo '<td>'.$fact['precio'].'</td>';
		echo '<td>'.$fact['valor'].'</td>';
		echo '<td>'.number_format($itbs,2).'</td>';
		echo '<td>'.number_format($itbs + $fact['valor'],2).'</td>';
	echo '</tr>';
}
?>
<tr>
	<td colspan="3">Totales</td>
	<td colspan="1"><strong><?php echo number_format($itbs_t,2); ?></strong></td>
	<td colspan="1"><strong><?php echo number_format($total,2)?></strong></td>
</tr>
</table>


<BR /><BR />
<table id="firma">
	<tr>
    	<td style="border-bottom:1px solid #666666; width:200px; margin:0 50px 0 0;"></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="border-bottom:1px solid #666666; width:200px;"></td>
    </tr>

	<tr>
    	<td align="center">Hecho por</td><td>&nbsp;&nbsp;&nbsp;</td> <td align="center">Recibo por</td>
    </tr>
</table>