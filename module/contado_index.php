<?php 
$ncf_sql = mysql_fetch_array(mysql_query("SELECT nombre,info FROM inf_esso WHERE ID_INFO = 1"));
$ncf = $ncf_sql[1] + 1;

if($_SESSION['a']->ncf == ''){
	$_SESSION['a']->add_ncf($ncf_sql[0].$ncf);
}
?>
<table cellpadding="0" cellspacing="0" border="0" width="700">
	<tr>
    	<td width="400" align="left">
        	<div>
            <table>
            	<tr>
                	<td>Nombre: </td>
                    <td>
						<input value="<?php echo $_SESSION['a']->nombre; ?>" onkeyup="nombreFacturaContadoget(this.value)" id="nombreFacturaContadoInput" />
                        <div id="facturaContadonombreDrop">

                        </div>
                    </td>
                </tr>
            	<tr>
                	<td>Direccion : </td>
                    <td><input value="<?php echo $_SESSION['a']->direccion; ?>" id="nombreFacturaContadoInputDireccion" /></td>
                </tr>
            	<tr>
                    <td>Telefono.: </td>
                    <td><input value="<?php echo $_SESSION['a']->telefono; ?>" id="nombreFacturaContadoInputTelefono" /></td>
                </tr>
            </table>
            </div>
        </td>
        <td>&nbsp;</td>
        <td width="200" align="right">
           	<div  align="left" style="float:right;">
 	           <table>
               		<tr>
                        <td>NCF: </td>
                        <td>
                            <?php
	   							 if($_SESSION['a']->ncf){
									 ?>
                                      <input value="<?php echo $_SESSION['a']->ncf; ?>" id="nombreFacturaContadoInputNCF" onblur="nombreFacturaContadoNcf(this)" />
                                     <?php
								 }
								 else{
									 ?>
                                      <input value="<?php echo $ncf_sql[0].$ncf; ?>" id="nombreFacturaContadoInputNCF" onblur="nombreFacturaContadoNcf(this)"/>
                                     <?php
								}
							?>
                        </td>
                    </tr>
               		<tr>
                        <td>Fecha: </td>
                        <td><input value="<?php echo date("m/d/Y"); ?>" id="nombreFacturaContadoInputfecha" /></td>
                    </tr>
               		<tr>
                        <td>RNC: </td>
                        <td><input value="<?php echo $_SESSION['a']->rnc; ?>" id="nombreFacturaContadoInputRNC" /></td>
                    </tr>
               </table>
            </div>
        </td>
    </tr>
</table>
<?php  
	if($_SESSION['a']->nombre == ''){
		?>
        <P id="sinoaparececliente">
            Los datos del cliente todavia no han sido confirmado, para confirmar por favor seleccione esta opcion <input type="checkbox" />
        </P>	
	<?php
	}
?>

<?php
//$_SESSION['a']->header_print();
$_SESSION['a']->show();
?>
<script type="text/javascript" src="c/ajaz.js"></script>
<div id="detalles">

</div>

<div class="print"><!-- no print -->
<br />
<input type="button" value="Agregar" onclick="window.open('add.php','_self');"> | 
<input type="button" value="Datos Cliente" onclick="window.open('datos.php','_self');" /> |
<input type="button" value="NFC" onclick="window.open('esso.php','_self');" /> |
<input type="button" value="Imprimir" onclick="print_contado()" />
</div>


<form id="control">
    <input type="hidden" name="Nombre Cliente" value="<?php echo $_SESSION['a']->nombre;?>" />
    <input type="hidden" name="NCF" value="<?php echo $_SESSION['a']->ncf;?>" />
    <input type="hidden" name="Valor de la Factura" value="<?php if($_SESSION['a']->indice > 0)echo $_SESSION['a']->indice;?>" />
</form>