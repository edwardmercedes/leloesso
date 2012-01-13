<?php 
include '../conf/conn.php';
include '../include/funciones.php';

//BUSCAMOS EL ULTIMO PAGO
$sql = 'SELECT C.nombre AS nombre, R.fecha as fecha, R.N_cheque AS numChaque, R.V_cheque AS valor, R.banco AS tipo, R.ID AS id ';
$sql .= 'FROM registro AS R, clientes AS C  ';
$sql .= 'WHERE R.ID_CLIENTE = '.$_GET['id'].' AND C.ID_CLIENTE = R.ID_CLIENTE AND V_cheque >= 1 ';
$sql .= 'ORDER BY R.fecha DESC';
$recibo = mysql_fetch_array(mysql_query($sql));

//BALANCE PENDIENTE
$sql = 'SELECT Valor_fact as factura, V_cheque AS pagos, Tipo_comb AS tipo ';
$sql .= 'FROM registro ';
$sql .= 'WHERE ID_CLIENTE = '.$_GET['id'].' ';
$balanceQuery = mysql_query($sql);
$facturas = 0;
$pagos = 0;

while($row = mysql_fetch_array($balanceQuery)){
	if($row['tipo'] == 'Diesel' or $row['tipo'] == 'Gasolina Regular' or $row['tipo'] == 'Gasolina Premium'){
		$facturas = $facturas + $row['factura'];	
	}
	else{
		$facturas = $facturas + ($row['factura'] + $row['factura'] * 0.16);	
	}
	$pagos =  $pagos + $row['pagos'];
}

	$balance = $facturas - $pagos;
?>

<script type="text/javascript">
window.onload = print_();

function print_(){
	window.print();	
	window.close();
}
</script>
<style type="text/css">
*{
	margin:0;
	padding:0;
	font-family:Verdana, Geneva, sans-serif;
}
P{
	font-size:11px;
	margin:0 0 15px 0;
	line-height:15px;
}
table{
	font-size:11px;
}
</style>
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
    	<td height="10" colspan="2" align="center">
        <p><strong>ESTACION ESSO PEDRO MANUEL BAEZ</strong><br />
            Avenida Santa Rosa Esquina Duarte<br />
            Tel: 809-556-2530  RNC: 130655537<br />
            N.Ref: <?php echo $recibo['id'] ?></p>
        </td>
	</tr>  
    <tr>
    	<td height="10"></td>
   </tr>
	<tr>
    	<td height="10" colspan="2" align="center">
			<p><strong>RECIBO DE INGRESO</strong></p>
        </td>
	</tr>     
    <tr>
    	<td height="10" colspan="2">-----------------------------------------------</td>
    </tr>
	<tr>
    	<td>Cliente: </td>
        <td align="right" class="nombre_cliente"><?php echo $recibo['nombre'] ?></td>
    </tr>
    <tr>
    	<td height="10"></td>
    </tr>
	<tr>
    	<td>Valor: </td>
        <td align="right"><?php echo $recibo['valor'] ?></td>
    </tr>
    <tr>
    	<td height="10"></td>
    </tr>
<?php 
	if($recibo['Tipo'] == 'Efectivo' ){
		?>
            <tr>
                <td>Pago: </td>
                <td align="right">Efectivo</td>
            </tr>
        <?php	
	}
	elseif($recibo['Tipo'] == 'Tarjeta'){ 
		?>
            <tr>
                <td>Pago: </td>
                <td align="right">Tarjeta</td>
            </tr>
        <?php	
	}
	else{ //si el pago es cheque
		?>
            <tr>
                <td>Pago: </td>
                <td align="right">Cheque (<?php echo $recibo['numChaque'] ?>)</td>
            </tr>
        <?php	
		
	}
?>
	<tr>
    	<td height="10" colspan="2">-----------------------------------------------</td>
    </tr>    
    <tr>
    	<td><p>Bce. Pendiente:</p> </td>
        <td align="right"><?php echo number_format($balance,2); ?></td>
    </tr>    
 	<tr>
    	<td height="80"></td>
	</tr>     
      
    
	<tr>
    	<td height="10" colspan="2" align="center">-------------------------------------</td>
    </tr>
	<tr>
    	<td height="10" colspan="2" align="center">Recibido por:</td>
	</tr>     
</table>