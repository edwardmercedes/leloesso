<?php 
$ncf_sql = mysql_fetch_array(mysql_query("SELECT nombre,info FROM inf_esso WHERE ID_INFO = 1"));
$ncf = $ncf_sql[1] + 1;
?>
<script type="text/javascript" src="c/ajaz.js"></script>

<h1>Esso Informacion</h1>

<form method="post" action="process/cliente.php?do=add">
	<label>N Comprobante Fical:</label> 
    <?php
	    if($_SESSION['a']->ncf){
	?>
    <input type="text" name="fiscal" id="fiscal" value="<?php echo $_SESSION['a']->ncf;?>" autocomplete="off" />
	<?php		
		}
		else{
		?>
	<input type="text" name="fiscal" id="fiscal" value="<?php echo $ncf_sql[0].$ncf;?>" autocomplete="off" />     
        <?php
		}
	?>
    
     	<input type="button" value="-v-" onclick="n_fiscal()" class="control" />
<div id="campos_form">

</div>                  
</form>


<br>
<input type="button" value="Vovel a la factura" onclick="window.open('contado_index.php','_self');">