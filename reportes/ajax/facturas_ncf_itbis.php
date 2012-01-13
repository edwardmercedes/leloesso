<div id="datepick">
    	<label>Inicio: </label> <input type="text" id="inicio" value="<?php echo $_GET['inicio']; ?>" name="inicio" onClick="displayDatePicker('inicio', false, 'ymd', '-');"> 
        <label>Final: </label> <input type="text" id="final"  value="<?php echo $_GET['fin']; ?>" name="final" onClick="displayDatePicker('final', false, 'ymd', '-');"> 
        <input type="button" value="Go" id="go" onclick="dosfecha();">
</div> 

<table id="informacion_esso">
   <tr>
     <td valign="top"><img src="images/logo.jpg" id="logo"></td>
     <td>
<div id="testo_empresa">
<strong>ESTACION ESSO / PEDRO MANUEL BAEZ B.</strong><br>
Ave. Santa Rosa #64, esquina Duarte<br>
Tel. (809) - 556-2530&nbsp;&nbsp;&nbsp;
RNC: 130655537<br>
</div>
    </td>
   </tr>
 </table>


<dl id="dl_informacion">
<?php
include '../../conf/conn.php';
include '../include/funciones.php';

/*
	*Title reporte
*/
	echo '<h1 align="center">FACTURA CON NCF CON ITBIS</h1>';
	echo '<p align="center">Reporte generado: '.date("m/d/Y").'</p>';
?>

<dd>
	<table cellpadding="0" cellspacing="0" border="1">
		<tr>
        	<th>ID</th>
            <th>NCF</th>
            <th>Cliente</th>
            <th>RNC</th>
            <th>Factura</th>
            <th>ITBIS</th>
            <th>Fecha</th>
        </tr>
    </table>
</dd>


</dl>
