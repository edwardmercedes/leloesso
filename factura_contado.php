<?php
$link = mysql_connect('localhost','root','admin');
$db = mysql_select_db("esso",$link);


//CONSULTA MYSQL selecionada por un ncf 
$sql = "
 	SELECT 
		rnc.ID_NCF AS id_ncf,
		rnc.ncf AS ncf,
		rnc.cc AS cc,
		rnc.ID_CLIENTE AS id_cliente,
		DATE_FORMAT(rnc.Fecha_registro, '%m/%d/%Y  %H:%m:%s') as fecha,
		clientes.nombre AS nombre,
		clientes.direccion AS direccion,
		clientes.telefono AS tel,
		clientes.RNC AS rnc

	FROM rnc,clientes 

	WHERE 
		rnc.ncf = '".$_GET['id']."'  AND
	  	clientes.ID_CLIENTE = rnc.ID_CLIENTE	
";

$factura = mysql_fetch_array(mysql_query($sql));
?>

cliente: <?php echo $factura['nombre'] ?> <br />
RNC: <?php echo $factura['rnc'] ?> <br />
NCF: <?php echo $factura['ncf'] ?> <br />
Fecha: <?php echo $factura['fecha'] ?> <br />


