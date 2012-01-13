<?php 
if(isset($_GET['f1'])!= '' and isset($_GET['f2'])!=''):
	list($inicioAno,$inicioMes,$inicioDia,) = explode('-',$_GET['f1']);
	list($finAno,$finMes,$finDia,) = explode('-',$_GET['f2']);
else:
	list($inicioAno,$inicioMes,$inicioDia,) = explode('-',date('Y-m-d', strtotime('-1 month')));
	list($finAno,$finMes,$finDia,) = explode('-',date('Y-m-d'));
endif;

//sumar un dia al a fecha de fin 
$finMTime = mktime(0, 0, 0, $finMes, $finDia, $finAno) + (24*60*60);
list($finAno,$finMes,$finDia,) = explode('-',date('Y-m-d',$finMTime));

$inicio = $inicioAno.'-'.$inicioMes.'-'.$inicioDia;
$fin = $finAno.'-'.$finMes.'-'.$finDia;

include '../conf/conn.php';
include '../include/funciones.php';

?>
<link type="text/css" href="css.css" rev="stylesheet" rel="stylesheet" />

<div style="text-align:center; width:500px;">
<p>REPORTE DE CUENTAS INCOBRABLES<br>
<?php 
$mostrarFecha = mktime(0, 0, 0, $finMes, $finDia, $finAno) - (24*60*60);

echo $inicioDia.' '.nombreMes($inicioMes).' '.$inicioAno;
echo ' al ';
echo date('d',$mostrarFecha).' '.nombreMes(date('m',$mostrarFecha)).' '.date('Y',$mostrarFecha);
echo '</p>';
?>

</div>

<table border="1" cellpadding="0" cellspacing="0" class="masther">
<tr>
	<th>COD</th>
    <th>Nombre</th>
    <th>Telefono</th>
    <th>Factura</th>
    <th>Pagos</th>
    <th>Balance</th>
    <th>Meses </th>
</tr>


<?php
//VAMOS A BUCAR LA LISTA DE LOS CLIENTES
$sql = 'SELECT ID_CLIENTE,nombre,telefono FROM clientes WHERE tipo <> 2 AND estado <> 1 ORDER BY nombre ';
$client_query = mysql_query($sql);	

$totalDeFacturas = 0;
$totalDePagos = 0;
$totalDeBalance = 0;
$registro = 0;

while($cliente = mysql_fetch_array($client_query)):
	$facturas = 0;
	$pagos = 0;
	$clienteFacturas = 0;
	$clientepagos = 0;
	$clienteUltimaFechaPago = '';


	#LA ULTIMA FECHA DE PAGO
	$ultimaFechaPago = 'SELECT  DATE(fecha) as fecha ';
	$ultimaFechaPago .= 'FROM registro ';
	$ultimaFechaPago .= 'WHERE ID_CLIENTE = '.$cliente['ID_CLIENTE'].' AND ';
	$ultimaFechaPago .= "fecha < '".$fin."'  ";
	$ultimaFechaPago .= 'ORDER BY fecha DESC ';
	$ultimaFechaPago .= 'LIMIT 1 ';
	$ultimaFechaPagoQuery = @mysql_query($ultimaFechaPago);	
	while($row = @mysql_fetch_array($ultimaFechaPagoQuery)):
		$clienteUltimaFechaPago = $row['fecha'];
	endwhile;
	
	#MESES SIN PAGAR
	list($hoyAno,$hoyMes,$hoyDia) = explode('-',date('Y-m-d'));
	list($ultimoAno,$ultimoMes,$ultimoDia) = explode('-',$clienteUltimaFechaPago);
	$fechaHoy = mktime(0,0,0,$hoyMes,$hoyDia,$hoyAno);
	$ultimopago = @mktime(0,0,0,$ultimoMes,$ultimoDia,$ultimoAno);
	$resultado = round(($fechaHoy - $ultimopago) / (30 * 60 * 60 * 24));

//si el mes sin pagar es mayor de dos has los carculos
	if($resultado > 2):
	
	
		//BUSCAR FACTURAS DE LOS CLIENTES 
		$facturaSe = 'SELECT SUM(Valor_fact) AS Tfactura,Tipo_comb AS tipo ';
		$facturaSe .= 'FROM registro ';
		$facturaSe .= 'WHERE ID_CLIENTE = '.$cliente['ID_CLIENTE'].' AND ';
		$facturaSe .= "fecha < '".$fin."'  ";
		$facturaSe .= 'GROUP BY Tipo_comb ';
		$factura_query = mysql_query($facturaSe);	
	
		while($tf = mysql_fetch_array($factura_query)):
			if($tf['tipo']=='Gasolina Regular' or $tf['tipo']=='Gasolina Premium' or $tf['tipo']=='Diesel'):
				$clienteFacturas = $clienteFacturas + $tf['Tfactura'];
			else:
				$clienteFacturas = $clienteFacturas + $tf['Tfactura'] + ($tf['Tfactura'] * 0.16 );
			endif;
		endwhile;


		//BUSCAR PAGOS DE LOS CLIENTES 
		$facturaSe = 'SELECT SUM(V_cheque) AS Tpago ';
		$facturaSe .= 'FROM registro ';
		$facturaSe .= 'WHERE ID_CLIENTE = '.$cliente['ID_CLIENTE'].' AND ';
		$facturaSe .= "fecha < '".$fin."'  ";
		$factura_query = @mysql_query($facturaSe);	
	
		while($tf = @mysql_fetch_array($factura_query)):
				$clientepagos = $clientepagos + $tf['Tpago'];
		endwhile;
		$totalDeBalance = $totalDeBalance + $clienteFacturas - $clientepagos;




		//si el balance del ciente es  mayor que cero
		if( ($clienteFacturas - $clientepagos) >= 1):
		
			//BUSCAR FACTURAS DE LOS CLIENTES 
			$facturaSql = 'SELECT SUM(Valor_fact) AS fact, Tipo_comb AS tipo ';
			$facturaSql .= 'FROM registro ';
			$facturaSql .= 'WHERE ID_CLIENTE = '.$cliente['ID_CLIENTE'].' AND ';
			$facturaSql .= "fecha BETWEEN '".$inicio."' AND '".$fin."'  ";
			$facturaSql .= ' GROUP BY Tipo_comb ';
			$factura_query = mysql_query($facturaSql);
			
			while($factura = mysql_fetch_array($factura_query)):
				if($factura['tipo']=='Gasolina Regular' or $factura['tipo']=='Gasolina Premium' or $factura['tipo']=='Diesel'):
					$facturas = $facturas + $factura['fact'];
				else:
					$facturas = $facturas + $factura['fact'] + ($factura['fact'] * 0.16 );
				endif;
			endwhile;	
			$totalDeFacturas = $totalDeFacturas + $facturas;
	
			//BUSCAR PAGOS DE LOS CLIENTES 
			$facturaSql = 'SELECT SUM(V_cheque) AS pago ';
			$facturaSql .= 'FROM registro ';
			$facturaSql .= 'WHERE ID_CLIENTE = '.$cliente['ID_CLIENTE'].' AND ';
			$facturaSql .= "fecha BETWEEN '".$inicio."' AND '".$fin."'  ";
			$factura_query = mysql_query($facturaSql);	
			while($factura = mysql_fetch_array($factura_query)):
				$pagos = $pagos + $factura['pago'];
			endwhile;
			$totalDePagos = $totalDePagos + $pagos;

		?>
         <tr>
            <td><?php echo $cliente['ID_CLIENTE']; ?></td>
            <td><?php echo $cliente['nombre'] ?></td>
            <td><?php echo $cliente['telefono'] ?></td>
            <td><?php echo number_format($facturas,2) ?></td>
            <td><?php echo number_format($pagos,2) ?></td>
            <td><?php echo number_format($clienteFacturas - $clientepagos,2) ?></td>
            <td><?php echo $resultado ?> </td>
        </tr>
        <?php
					
		endif; //si el balance del ciente es  mayor que cero

	endif;//si el mes mayor de 2

endwhile;
?>

    <tr>
        <td>&nbsp;</td>
        <td>Totales</td>
        <td>&nbsp;</td>
        <td><strong><?php echo number_format($totalDeFacturas,2) ?></strong></td>
        <td><strong><?php echo number_format($totalDePagos,2) ?></strong></td>
        <td><strong><?php echo number_format($totalDeBalance,2) ?></strong></td>
    </tr>
    
</table>