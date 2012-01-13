<script type="text/javascript" src="c/ajaz.js"></script>
<script type="text/javascript">
function llenar(){
	select_ = document.getElementById("select_lista");
	input = document.getElementById("rnc");
	var indiceSeleccionado = select_.selectedIndex;
	var opcionSeleccionada = select_.options[indiceSeleccionado];
	input.value = opcionSeleccionada.value;
}
</script>

<h1>RNC Informacion</h1>
<form method="post" action="process/cliente.php?do=add">
	<label>RNC: </label> 
		<input type="text" name="rnc" id="rnc" value="<?php if($_SESSION['a']->rnc){ echo $_SESSION['a']->rnc;}?>" autocomplete="off"/> 
        <input type="button" value="-v-" onclick="add_cliente()" class="control"/>
<div id="campos_form">

</div>                  
</form>
<br>
<input type="button" value="Volver a la Factura" onclick="window.open('contado_index.php','_self');" autocomplete="off">
<br><br><br><br>
<label>Nombre Cliente: </label> <input type="text" onkeyup="select_lista_cliente(this.value)" autocomplete="off"/> <br />


<label>Eliga Cliente: </label>
<div id="lista_cliente">

<select name="lista_client" id="select_lista" onchange="llenar()" >
	<option value="LIS">Lista de los clientes</option>
	<option value="56346">Lista</option>
</select>

</div>

