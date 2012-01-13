<?php 
include '../include/class.php';
session_start();

include '../conf/conn.php';


$sql = mysql_fetch_array(mysql_query("SELECT ID_CLIENTE,nombre,RNC,direccion,telefono FROM clientes WHERE RNC = '".$_GET['id']."' "));

if($sql['RNC']==$_GET['id']){
	$_SESSION['a']->add_cliente($sql['ID_CLIENTE'],$sql['nombre'],$sql['RNC'],$sql['direccion'],$sql['telefono']);
	echo '<p style="color:#FFF">RNC ya existe. <strong>Cliente: </strong> '.$sql['nombre'].'</p>';
}
else{
echo '
	<table>
    	<tr>
        	<td><label>Nombre:</label></td>
            <td><input type="text" name="nombre" autocomplete="off"/></td>
        </tr>
    	<tr>
        	<td><label>Direccion:</label></td>
            <td><input type="text" name="Direccion" autocomplete="off"/></td>
        </tr>

    	<tr>
        	<td><label>Telefono:</label></td>
            <td><input type="text" name="Telefono" autocomplete="off" /></td>
        </tr>

    	<tr>
        	<td></td>
            <td><input type="submit" value="Agregar Cliente" class="control"/></td>
        </tr>  
    </table>
';
}
?>
