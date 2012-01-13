<?php 
$sql = array();

$link = mysql_connect("localhost","root","admin");
$db = mysql_select_db("es",$link);


$q = "INSERT INTO registro (fecha,N_fact,ficha,Tipo_comb,Precio_comb,Valor_fact,N_cheque,V_cheque,banco,balance,ID_CLIENTE,ID_user,STATU) ";


$sql_select = "SELECT * FROM registro WHERE ID_CLIENTE = 22";
$query = mysql_query($sql_select);
$cont = 1;
while($row = mysql_fetch_array($query)){
	
	$l = $row['fecha'].','.$row['N_fact'].','.$row['ficha'].','.$row['Tipo_comb'].','.$row['Precio_comb'].','.$row['Valor_fact'].','.$row['N_cheque'].','.$row['V_cheque'].','.$row['banco'].','.$row['balance'].',391,'.$row['ID_user'].','.$row['STATU'];
	
	$sql[] = $q.$l;
	
$cont++;
}

foreach($sql as $a){
	echo $a.'<br><br>';
}
?>