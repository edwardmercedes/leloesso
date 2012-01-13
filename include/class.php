<?php
class contado{

	var $indice = 0;
	var $combust = array();
	var $precio = array();
	var $valor = array();
	var $ID_CLIENTE;//a nombre 
	var $nombre;//a nombre 
	var $telefono;//a nombre 
	var $direccion;//a nombre 
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
	function add_cliente($ID,$nombre,$rnc,$direccion,$telefono){
		$this->ID_CLIENTE = $ID;
		$this->nombre = $nombre;
		$this->rnc = $rnc;
		$this->direccion = $direccion;
		$this->telefono = $telefono;
	}
	
//agregar NCF
	function add_ncf($ncf){
		$this->ncf = $ncf;
	}	
	
//mostrar todo lo que hay en el objeto	
function show(){
$total = 0;
$T_itbis = 0;

	echo '<table cellpadding="0" cellspacing="0" border="0" width="700" id="lista" class="masther">';
	 echo '<tr>';
	 	echo '<th>Descripcion</th>';
		echo '<th class="derecha">Cantidad</th>';
		echo '<th class="derecha">Precio</th>';
		echo '<th class="derecha">Total</th>';
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
				<a href="edit.php?id='.$i.'" class="print"><img src="images/edit.gif" /></a>
				 <a href="process/objecto.php?do=delete&id='.$i.'" class="print"><img src="images/trash.gif"/></a>
			  </td>';
		echo '<td class="derecha">'.$this->precio[$i].'</td>';
		echo '<td class="derecha">'.$this->valor[$i].'</td>';
		echo '<td class="derecha">'.number_format($itbis + $this->valor[$i],2).'</td>';
	 echo '</tr>';
}//fin if
}//fin del for
echo '</table>';

//final de la tabla totales
echo '

<table cellpadding="0" cellspacing="0" border="0" width="700" class="masther">
	<tr>
    	<td>
            <div style="width:500px;margin:5px 0 0 0;">
                <table style="padding:40px 0 0 0; display:none;">
                	<tr>
                    	<td style="margin:0; border-top:dotted 1px #000; padding:0 40px 0 40px;">Recibido por</td>
                        <td>&nbsp;&nbsp;</td>
                        <td style="margin:0; border-top:dotted 1px #000; padding:0 40px 0 40px;">Despachado por</td>
                    </tr>
                </table>
            </div>
        </td>
        <td align="right">
			<div>
            	<table style="border-bottom:1px dotted #000; padding:0 0 1px 0;" cellpadding="0" cellspacing="0" width="150">
                	<tr>
                    	<td align="left">Sub-Total: </td>
                        <td align="right">'.number_format($total - $T_itbis,2).'</td>
                    </tr>
                	<tr align="left">
                    	<td>ITBIS: </td>
                        <td align="right">'.number_format($T_itbis,2).'</td>
                    </tr>
                	<tr>
                    	<td align="left" style="border-bottom:1px dotted #000;">Total: </td>
                        <td align="right" style="border-bottom:1px dotted #000;">'.number_format($total,2).'</td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>

';

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
	$link = mysql_connect("localhost","root",'');
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
					<span id="span_fiscal">NCF: '.$this->ncf.'</span>
            	 </p>
			   </td>
  		  </tr>	
		</table>
	</div>
	';
}



}//objeto 
?>
