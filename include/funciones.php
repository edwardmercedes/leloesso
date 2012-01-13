<?php 
//RECIDE NUMERO DE MES DEVUELVE NOMBRE DEL MES
function nombreMes($m){
	switch($m){
		case '01':
			$mes = ' Enero ';
		break;
		case '02':
			$mes = ' Febrero ';
		break;
		case '03':
			$mes = ' Marzo ';
		break;
		case '04':
			$mes = ' Abrir ';
		break;
		case '05':
			$mes = ' Mayo ';
		break;
		case '06':
			$mes = ' Junio ';
		break;
		case '07':
			$mes = ' Julio ';
		break;
		case '08':
			$mes = ' Agosto ';
		break;
		case '09':
			$mes = ' Septiembre ';
		break;
		case '10':
			$mes = ' Octubre ';
		break;
		case '11':
			$mes = ' Nobiembre ';
		break;
		case '12':
			$mes = ' Diciembre ';
		break;
	}
	return $mes;
}

//ABREVIAR EL TIPO DE COMBUSTIBLE
function abreviar_combus($tipo){
	switch($tipo){
		case 'Gasolina Regular':
			$combus='Gasol. Reg.';
		break;
		case 'Gasolina Premium':
			$combus='Gasol. Pre.';
		break;
		default:
			$combus=$tipo;
		break;
	}
	return $combus;
	echo $combus;
}

//FUNCION PARA IMPRIMIR HEADER
function Const_header($title,$sub){
	echo '
	<div id="fecha_impresion">'.date("d/m/Y").' </div>
	<div id="haader_imprint" align="center">
		<table cellpadding="0" cellspacing="0" border="0" align="center">
			<tr>
    			<td valign="top"><img src="images/esso.jpg"/></td>
        		<td>
          		  <p>
					<strong>ESTACION ESSO / PEDRO MANUEL B.</strong> <br />
					<strong>Direcci&oacute;n. </strong> Ave. Santa Rosa Esquina Duarte<br />
					<strong>RNC: </strong>130655537	
					<strong>Tel. </strong>(809) 556-2530<br />
					<span id="span_factura"></span><br />
					<span id="span_fiscal"></span>
            	 </p>
			   </td>
  		  </tr>	
		  <tr>
    			<td valign="top"></td>
		        <td valign="top" align="left"><strong>'.$title.': &nbsp;&nbsp;</strong> del '.$sub.'</td>
		 </tr>    
		</table>
	</div>
	';
}
?>
