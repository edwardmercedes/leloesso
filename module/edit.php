<?php
//consulta tarifario
$str = mysql_query("SELECT tipo,valor FROM tarifario WHERE tipo <> '".$_SESSION['a']->combust[$_GET['id']]."' ");
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

<form method="post" action="process/objecto.php?do=edit&id=<?php echo $_GET['id']; ?>">
	<table>
    	<tr>
        	<td><label>Tipo:</label></td>
            <td>
               	<select name="combus" onchange="llenar()" id="cobus">
                	<option value="<?php echo $_SESSION['a']->combust[$_GET['id']]; ?>"><?php echo $_SESSION['a']->combust[$_GET['id']]; ?></option>
                   <?php
                   	while($row = mysql_fetch_array($str)){
						echo '<option value="'.$row[1].'">'.$row[0].'</option>';
					}
				   ?> 
                </select>	
            	<input type="hidden" name="nombre" value="<?php echo $_SESSION['a']->combust[$_GET['id']]; ?>" id="tipo"/>
            </td>
        </tr>

    	<tr>
        	<td><label>Precio</label></td>
            <td><input type="text" name="precio" value="<?php echo $_SESSION['a']->precio[$_GET['id']]; ?>" id="precio" autocomplete="off"/></td>
        </tr>

    	<tr>
        	<td><label>Valor:</label></td>
            <td><input type="text" name="valor" value="<?php echo $_SESSION['a']->valor[$_GET['id']]; ?>" autocomplete="off"/></td>
        </tr>

    	<tr>
        	<td></td>
            <td><input type="submit"  value="Guardar" class="control"/></td>
        </tr>        
    </table>
</form>
<input type="button" value="index" onclick="window.open('contado_index.php','_self');">
