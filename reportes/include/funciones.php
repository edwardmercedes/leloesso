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

?>