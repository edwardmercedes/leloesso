<?php
//ini_set('display_errors', '0');
//error_reporting(E_ALL | E_STRICT);
include '../../conf/conn.php';
include '../include/funciones.php';


if(isset($_GET['inicio'])!= '' and isset($_GET['fin'])!=''):
	list($inicioAno,$inicioMes,$inicioDia,) = explode('-',$_GET['inicio']);
	list($finAno,$finMes,$finDia,) = explode('-',$_GET['fin']);
else:
	list($inicioAno,$inicioMes,$inicioDia,) = explode('-',date('Y-m-d', strtotime('-1 month')));
	list($finAno,$finMes,$finDia,) = explode('-',date('Y-m-d'));
endif;


echo '<p>Reporte Clientes a Creditos—<br>';
echo $inicioDia.' '.nombreMes($inicioMes).' '.$inicioAno;
echo ' al ';
echo $finDia.' '.nombreMes($finMes).' '.$finAno;
echo '</p>';


$inicio = $inicioAno.'-'.$inicioMes.'-'.$inicioDia;
$fin = $finAno.'-'.$finMes.'-'.$finDia;

//VAMOS A BUCAR LA LISTA DE LOS CLIENTES
$sql = 'SELECT ID_CLIENTE,nombre,telefono FROM clientes WHERE tipo <> 2 AND estado <> 1 ORDER BY nombre ';
$client_query = mysql_query($sql);	

while($cliente = mysql_fetch_array($client_query)):
	$facturas = 0;
	$pagos = 0;
	$clienteFacturas = 0;
	$clientepagos = 0;
	$clienteUltimaFechaPago = '';

	//BUSCAR FACTURAS DE LOS CLIENTES 
	$facturaSql = 'SELECT SUM(Valor_fact) AS fact, SUM(V_cheque) AS pago, Tipo_comb AS tipo ';
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
		$pagos = $pagos + $factura['pago'];

	endwhile;	

	//BUSCAR FACTURAS DE LOS CLIENTES 
	$facturaSql = 'SELECT SUM(Valor_fact) AS Tfactura, SUM(V_cheque) AS Tpago, Tipo_comb AS tipo ';
	$facturaSql .= 'FROM registro ';
	$facturaSql .= 'WHERE ID_CLIENTE = '.$cliente['ID_CLIENTE'].' ';
	$factura_query = mysql_query($facturaSql);	

	while($tf = mysql_fetch_array($factura_query)):
		if($tf['tipo']=='Gasolina Regular' or $tf['tipo']=='Gasolina Premium' or $tf['tipo']=='Diesel'):
			$clienteFacturas = $clienteFacturas + $tf['Tfactura'];
		else:
			$clienteFacturas = $clienteFacturas + $tf['Tfactura'] + ($tf['Tfactura'] * 0.16 );
		endif;
			$clientepagos = $clientepagos + $tf['Tpago'];
	endwhile;

	#LA ULTIMA FECHA DE PAGO
	$ultimaFechaPago = 'SELECT  DATE(fecha) as fecha ';
	$ultimaFechaPago .= 'FROM registro ';
	$ultimaFechaPago .= 'WHERE ID_CLIENTE = '.$cliente['ID_CLIENTE'].' ';
	$ultimaFechaPago .= 'ORDER BY fecha DESC ';
	$ultimaFechaPago .= 'LIMIT 1 ';
	$ultimaFechaPagoQuery = mysql_query($ultimaFechaPago);	
	while($row = mysql_fetch_array($ultimaFechaPagoQuery)):
		$clienteUltimaFechaPago = $row['fecha'];
	endwhile;
	
	#MESES SIN PAGAR
	list($hoyAno,$hoyMes,$hoyDia) = explode('-',date('Y-m-d'));
	list($ultimoAno,$ultimoMes,$ultimoDia) = explode('-',$clienteUltimaFechaPago);
	$fechaHoy = mktime(0,0,0,$hoyMes,$hoyDia,$hoyAno);
	$ultimopago = mktime(0,0,0,$ultimoMes,$ultimoDia,$ultimoAno);
	$resultado = round(($fechaHoy - $ultimopago) / (30 * 60 * 60 * 24));

	//echo $clienteFacturas.'**';


	#EMPEZAMOS A MOSTRAR DATOS
	echo str_pad($cliente['ID_CLIENTE'], 5, '.', STR_PAD_RIGHT).' ';
	echo $cliente['nombre'].' ';
	echo $cliente['telefono'] .' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	echo number_format($clienteFacturas,3).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	echo number_format($clientepagos,3).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

	if($resultado >=3):
		echo '<span style="color:#f00;">'.$resultado.'</span>';
	else:
		echo '<span style="color:#000;">'.$resultado.'</span>';
	endif;
	echo '<br>';


	//echo str_pad($cliente['ID_CLIENTE'], 5, '.', STR_PAD_RIGHT).' ';

endwhile;






?>