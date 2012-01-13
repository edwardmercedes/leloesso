<?php
session_start();
if(!$_SESSION['a']){
	$_SESSION['a'] = new contado;
}

//consulta tarifario
$str = mysql_query("SELECT tipo,valor FROM tarifario");
?>

<script type="text/javascript">
function llenar(){
	select_ = document.getElementById("cobus");
	input = document.getElementById("precio");
	tipo = document.getElementById("tipo");
	var indiceSeleccionado = select_.selectedIndex;
	var opcionSeleccionada = select_.options[indiceSeleccionado];
	input.value = opcionSeleccionada.value;
	tipo.value = opcionSeleccionada.text;
}
</script>

<form method="post" action="process/objecto.php?do=insert">
	<table>
    	<tr>
        	<td><label>Tipo:</label></td>
            <td>
            	<select name="combus" onchange="llenar()" id="cobus">
                	<option value="">Elige</option>
                   <?php
                   	while($row = mysql_fetch_array($str)){
						echo '<option value="'.$row[1].'">'.$row[0].'</option>';
					}
				   ?> 
                </select>	
	            <input type="hidden" name="nombre" id="tipo" />
            </td>
        </tr>

    	<tr>
        	<td><label>Precio</label></td>
            <td><input type="text" name="precio" id="precio" autocomplete="off"/></td>
        </tr>

    	<tr>
        	<td><label>Valor:</label></td>
            <td><input type="text" name="valor" autocomplete="off"/></td>
        </tr>

    	<tr>
        	<td></td>
            <td><input type="submit" value="Agregar" class="control" /></td>
        </tr>        
    </table>
</form>
<input type="button" value="Volver a la factura" onclick="window.open('contado_index.php','_self');">