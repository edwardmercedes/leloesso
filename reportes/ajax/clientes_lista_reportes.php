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


<?php
include '../../conf/conn.php';
include '../include/funciones.php';

//buscamos la lista de los clientes 
$client_query = mysql_query("SELECT nombre,direccion,telefono,celular,RNC,Comentario,email FROM clientes WHERE estado <> 0 AND tipo <> 2 ORDER BY nombre ");	
?>

<h1 align="center">Reporte General Lista Clientes</h1>
<p align="center">En fecha: <?php echo date("d/m/Y") ?></p>

<dl id="dl_informacion">
<?php 
$cont = 0;
	while($row = mysql_fetch_array($client_query)){
		
		$cont = $cont + 1;
	?>



        <dt><?php echo $cont ?> - <?php echo $row['nombre'] ?></dt>
        <dd>
            Celular: <?php echo $row['celular'] ?> <br />
            Telefono: <?php echo $row['telefono'] ?> <br />
            Email: <?php echo $row['email'] ?><br />
            RNC: <?php echo $row['RNC'] ?> <br />
            Comentario: <?php echo $row['Comentario'] ?> <br />
        </dd>

	
<?php    	
	}
?>

</dl>
