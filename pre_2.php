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
		DATE_FORMAT(rnc.Fecha_registro, '%m/%d/%Y') as fecha,
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

$registro = mysql_query("SELECT tipo,precio,valor FROM rnc WHERE ncf = '".$_GET['id']."'  ");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

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
}
table{
	font-size:11px;
}
.nombre_cliente{
	font-size:13px;
}
</style>
</head>
<body>
<p align="center">
<strong>ESTACION ESSO PEDRO MANUEL BAEZ</strong><br />
Avenida Santa Rosa Esquina Duarte<br />
Tel: 556-2530  RNC:130655537<br />
Factura Contado<br />
Credito Fiscal<br />
</p>       

<table cellpadding="0" cellspacing="0" border="0">
	<tr>
    	<td height="10" colspan="2">-----------------------------------------------</td>
    </tr>
	<tr>
    	<td>CLIENTE: </td>
        <td align="right" class="nombre_cliente"><strong><?php echo $factura['nombre'] ?></strong></td>
    </tr>
    <tr>
    	<td height="10"></td>
    </tr>
	<tr>
    	<td>RNC:</td>
        <td align="right"><?php echo $factura['rnc'] ?></td>
    </tr>
    <tr>
    	<td height="10"></td>
    </tr>

	<tr>
    	<td>TEL.:</td>
        <td align="right"><?php echo $factura['tel'] ?></td>
    </tr>    
	<tr>
    	<td height="35"></td>
    </tr>
    
	<tr>
    	<td>NCF:</td>
        <td align="right"><strong><?php echo $factura['ncf'] ?></strong></td>
    </tr>
    <tr>
    	<td height="10"></td>
    </tr>
    
	<tr>
    	<td>Fecha:</td>
        <td align="right"><?php echo $factura['fecha'] ?></td>
    </tr>
	<tr>
    	<td height="20"></td>
    </tr>
</table>

<table cellpadding="0" cellspacing="0" border="0">
	<tr>
        <td colspan="4" height="2">-----------------------------------------------</td>
    </tr>
	<tr>
    	<td>DESCR</td>
        <td width="10">CANT</td>
        <td align="right">PRECIO</td>
        <td align="right">TOTAL</td>
    </tr>
	<tr>
        <td colspan="4" height="2">-----------------------------------------------</td>
    </tr>
    
<?php
while ($fila = mysql_fetch_array($registro)){
	if ($fila['tipo'] == 'Diesel' or $fila['tipo'] == 'Gasolina Premium' or $fila['tipo'] == 'Gasolina Regular'){
		$itbis = $itbis;
		$total = $total + $fila['valor'];
		$registro_itbis = 0;
	}
	else{
		$itbis = $itbis + ($fila['valor'] * 0.16);
		$total = $total + $fila['valor'];		
		$registro_itbis = $fila['valor'] * 0.16;
	}
	?>
	 
	<tr>
    	<td><?php echo apre_combustible($fila['tipo'])?> </td>
        <td align="center"><?php echo number_format($fila['valor'] / $fila['precio'],2) ?></td>
        <td align="right"><?php echo $fila['precio'] ?></td>
        <td align="right"><?php echo number_format($fila['valor'] + $registro_itbis,2)?></td>
    </tr>
    
<?php    
}	
?>    	


	<tr>
    	<td height="35"></td>
    </tr>

	<tr>
    	<td align="right"></td>
    	<td align="right">ITBIS:</td>
        <td colspan="2" align="right">
			<?php 
			if($itbis < 1 ){
				echo 'E ';	
			}
			else{
				echo number_format($itbis,2);	
			}
			?>
        </td>
    </tr>
	<tr>
	    <td align="right"></td>
    	<td align="right">TOTAL:</td>
        <td colspan="2" align="right"><?php echo number_format($itbis + $total,2) ?></td>
    </tr>
    
	<tr>
    	<td height="20"></td>
    </tr>
    
	<tr>
        <td colspan="4" height="1">-----------------------------------------------</td>
    </tr>    
    
	<tr>
    	<td height="10"></td>
    </tr>
        
	<tr>
    	<td align="center" colspan="4" class="nombre_cliente">Gracias por preferir<BR />Nuestros servicios!!</td>
    </tr>
    
	<tr>
    	<td height="30"></td>
    </tr>

	<tr>
    	<td align="center" colspan="4">La Romana Republica Dominicana</td>
    </tr>
    
	<tr>
    	<td height="30"></td>
    </tr>    
</table>
</body>
</html>

<?php
//HACIENDO LAS ABREVIADIONES
function apre_combustible($tipo){
	switch($tipo){
		case 'Diesel':
			$texto = 'Diesel';
		break;

		case 'Gasolina Premium':
			$texto = 'Gasolina Prem.';
		break;
		
		case 'Gasolina Regular':
			$texto = 'Gasolina Reg.';
		break;

		default:
			$texto = $tipo;
		break;			
	}
	return $texto;
}

//TOTAL DE COMBUSTIBLE
function galones($tipo,$unidad,$precio){
	switch($tipo){
		case 'Diesel':
			$gls = number_format($precio / $unidad,2);
		break;

		case 'Gasolina Premium':
			$gls = number_format($precio / $unidad,2);
		break;
		
		case 'Gasolina Regular':
			$gls = number_format($precio / $unidad,2);
		break;

		default:
			$gls = '';
		break;			
	}
	return $gls;
}
?>