<?php
class contado{

	var $indice = 0;
	var $combust = array();
	var $precio = array();
	var $valor = array();
	var $ID_CLIENTE;//a nombre 
	var $nombre;//a nombre 
	var $ncf;//numero ncf
	var $rnc;//numero ncf
	
//funciton agregar algo	
	function add($combustible,$precio,$valor){
		$this->combust[$this->indice] = $combustible;
		$this->precio[$this->indice] = $precio;
		$this->valor[$this->indice] = $valor;
		$this->indice = $this->indice + 1;		
	}
	
//agregar datos del cliente
	function add_cliente($ID,$nombre,$rnc){
		$this->ID_CLIENTE = $ID;
		$this->nombre = $nombre;
		$this->rnc = $rnc;
	}
	
//agregar NCF
	function add_ncf($ncf){
		$this->ncf = $ncf;
	}	
	
//mostrar todo lo que hay en el objeto	
function show(){
$total = 0;
$T_itbis = 0;

echo '<strong>Cliente:</strong> '.$this->nombre.'<br>';
echo '<strong>RNC:</strong> '.$this->rnc.'<br>';

	echo '<table border="1" cellpadding="0" cellspacing="0" class="masther">';
	 echo '<tr>';
	 	echo '<th>Combustible</th>';
		echo '<th>Precio</th>';
		echo '<th>Valor</th>';
		echo '<th>ITBIS</th>';
		echo '<th>Total</th>';
	 echo '</tr>';

for($i = 0; $i < $this->indice; $i++){
if($this->precio[$i] > 1){
//procesos
if($this->combust[$i]== 'Gasolina Regular' or $this->combust[$i]== 'Gasolina Premium' or $this->combust[$i]== 'Diesel'){
	$itbis = 0;
	$total = $total + $this->valor[$i];	
}
else{
	$itbis = $this->valor[$i] * 0.16;
	$total = $total + ($itbis + $this->valor[$i]);	
	$T_itbis = $T_itbis + $itbis;
}
	 echo '<tr>';
	 	echo '<td>
				'.$this->combust[$i].' 
				<a href="edit.php?id='.$i.'" class="print"><img src="images/edit.gif" width="5" /></a>
				 <a href="process/objecto.php?do=delete&id='.$i.'" class="print"><img src="images/trash.gif" width="5" /></a>
			  </td>';
		echo '<td>'.$this->precio[$i].'</td>';
		echo '<td>'.$this->valor[$i].'</td>';
		echo '<td>'.number_format($itbis,2).'</td>';
		echo '<td>'.number_format($itbis + $this->valor[$i],2).'</td>';
	 echo '</tr>';
}//fin if
}//fin del for
echo '
	<tr>
	<td colspan="3">Totales</td>
	<td colspan="1"><strong>'.number_format($T_itbis,2).'</strong></td>
	<td colspan="1"><strong>'.number_format($total,2).'</strong></td>
</tr>';
echo '</table>';
}

//formulario para editar objecto
	function edit_form($id){
		echo '
			<form>
				<label>Title</label><input type="text" name="combust" id="combust" value="'.$this->combust[$id].'" /><br />
				<label>Fecha</label><input type="text" name="precio" id="precio" value="'.$this->precio[$id].'" /><br />
				<label>Quien</label><input type="text" name="valor" id="valor" value="'.$this->valor[$id].'" /><br />
				<input type="button" value="Guardar" id="contado_add_form.php?do=2" onclick="contado_edit('.$id.')" />
			</form>		
		';
	}
	
//Editar una entrada enel objecto
	function edit($id,$combus,$precio,$valor){
		$this->combust[$id] = $combus;
		$this->precio[$id] = $precio;
		$this->valor[$id] = $valor;
	}	
	
//llevar el precio a cero
	function delete($id){
		$this->combust[$id] = '';
		$this->precio[$id] = 0;
		$this->valor[$id] = 0;
	}	
		
//GUARDAR EN LA BASE DE DATOS
function guardar(){
// Abrimos la base de datos
	$link = mysql_connect("localhost","root","admin");
	$db = mysql_select_db("esso",$link);
// hacemos un form pro casa uno de los registro
for($i = 0; $i < $this->indice; $i++){
if($this->precio[$i] > 1){
		mysql_query("
			INSERT INTO rnc (ncf,cc,ID_CLIENTE,ID_user,tipo,precio,valor,Fecha_registro)
			VALUES(
			 	'".$this->ncf."',
				'2',
				'".$this->ID_CLIENTE."',
				'".$_SESSION['user']."',
				'".$this->combust[$i]."',
				'".$this->precio[$i]."',
				'".$this->valor[$i]."',
				NOW()
			)
		");
	  }//fin del if
	}//fin for
		
}//fin guardar

//FUNCION PARA IMPRIMIR HEADER
function header_print(){
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
					<span id="span_fiscal">NCF: '.$this->ncf.'123</span>
            	 </p>
			   </td>
  		  </tr>	
		</table>
	</div>
	';
}



}//objeto 
?>
