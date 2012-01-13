<?php
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=nombrequetendraelarchivo.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<html>
<head>
</head>

<body>
<h1>php to execel</h1>

<?php
$link = mysql_connect("localhost","root","admin");
$db =mysql_select_db("esso",$link);

$res=mysql_query("select * from login order by ID_user ");
$numreg=mysql_num_rows($res);
?>

<table align="center" border="1">
	<tr>
    	<td class="estilo14">Proveedor</td>
        <td class="estilo14">Folio</td>
        <td class="estilo14">Ciudad</td>
        <td class="estilo14">Direcci&oacute;n</td>
        <td class="estilo14">Campa&ntilde;a</td>
        <td class="estilo14">Anomal&iacute;a</td>
    </tr>
<?php
	while ($row=mysql_fetch_array($res)){
		echo '<tr>';
		    echo '<td class="estilo14">'.$row[0].'</td>';
			echo '<td class="estilo14">'.$row[1].'</td>';
			echo '<td class="estilo14">'.$row[2].'</td>';
			echo '<td class="estilo14">'.$row[3].'</td>';
			echo '<td class="estilo14">'.$row[4].'</td>';
			echo '<td class="estilo14">'.$row[5].'</td>';
		echo '</tr>';
	}
    ?>    
</table>
</body>
</html>
    