<?php
//fijo el date de hoy
$date_month = date('m');
$date_year = date('Y');
$date_day = date('d');
$filename = "$date_year-$date_month-$date_day".'.sql';

// Cabeceras para forzar al navegador a guardar el archivo 
header("Pragma: no-cache"); 
header("Expires: 0"); 
header("Content-Transfer-Encoding: binary"); 
header("Content-type: application/force-download"); 
header("Content-Disposition: attachment; filename=$filename"); 
 
$usuario="root";  // Usuario de la base de datos, un ejemplo podria ser 'root' 
$passwd="admin";  // Contraseña asignada al usuario 
$bd="esso";  // Nombre de la Base de Datos a exportar 
 
// Funciones para exportar la base de datos 
$executa = "C:\AppServ\mysql\bin\mysqldump.exe -u $usuario --password=$passwd --opt $bd"; 
system($executa, $resultado); 
 
// Comprobar si se ha realizado bien, si no es así, mostrará un mensaje de error 
if ($resultado) { echo "<H1>Error ejecutando comando: $executa</H1>\n"; } 
?>