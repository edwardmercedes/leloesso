<?php 
include '../include/class.php';
switch($_GET['do']){
//mostrar formulario
	case 1:
		echo '
		<form>
			<label>Combustible:</label><input type="text" name="combust" id="combust" /><br />
		    <label>Precio:</label><input type="text" name="precio" id="precio" /><br />
		    <label>Valor Fact:</label><input type="text" name="valor" id="valor" /><br />
			<input type="button" value="Agregar a la factura" id="contado_add_form.php?do=2" onclick="contado_add()" />
		</form>		
		';
	break;
	
//agregando a factura objeto
	case 2:
		session_start();
		$_SESSION['lelo']->add($_GET['comb'],$_GET['precio'],$_GET['valor']);
	break;

//editar del objecto formulario
	case 3:
		session_start();
		$form = $_SESSION['lelo']->edit_form($_GET['id']);
	break;
////editar del objecto
	case 4:
		session_start();
		$_SESSION['lelo']->edit($_GET['id'],$_GET['comb'],$_GET['precio'],$_GET['valor']);
		echo "<p>Actualizado</p>";
	break;	
//mostrar todo actualizado
	case 5:
		session_start();
		$_SESSION['lelo']->show();
	break;		
//borra uno
	case 6:
		session_start();
		$_SESSION['lelo']->delete($_GET['id']);
	break;		
}
sleep(1);
?>
