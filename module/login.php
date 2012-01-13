<br>
<div id="form_login"> 
<form method="post" action="process/login.php?do=login" id="login_form">
<table>
	<tr>
    	<td><label>Usuario:</label></td>
        <td><input type="text" name="Username" autocomplete="off"/></td>
    </tr>
    
	<tr>
    	<td><label>Contraseña:</label></td>
        <td><input type="password" name="Password" autocomplete="off"/></td>
    </tr>

	<tr>
    	<td> </td>
        <td><input type="button" value="Login" class="control" onclick="login();"></td>
    </tr>    
</table>
</form>
</div>