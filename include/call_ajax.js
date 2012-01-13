/*----------------------------------------------------------
 MAGEJAR LAS FUNCIONES AJAX DE TIPO GET
----------------------------------------------------------*/
function cargarContenido_get(url,tagId){
	var tag;
	tag = document.getElementById(tagId);
	ajax=crearXMLHttpRequest();
	ajax.open("GET",url,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			tag.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
return false;
}//----------------------------------------- FIN FUNCTION [cargarContenido_get] 





/*----------------------------------------------------------
 MANEJAR LA INFORMACION EN UN FORMULARIO... 
 ----------------------------------------------------------*/
function form(name){
	sql='';
	formm='';

	formm = document.getElementById(name);
	
	numberElements = formm.elements.length;
		
	for(i=0; i < numberElements; i++){
		if(formm.elements[i].type=='checkbox'){
			if(formm.elements[i].checked){
				sql += formm.elements[i].name + "=" + encodeURIComponent(formm.elements[i].value)+"&";			
			}
		}
		else{
			sql += formm.elements[i].name + "=" + encodeURIComponent(formm.elements[i].value)+"&";		
		}
	}//fin for
	$n_str = sql.length;
	sql = sql.substring($n_str - 1,0); 
	return sql;
}

function clearform(name){
	form = document.getElementById(name);
	numberElements = form.elements.length;
	for(i=0; i < numberElements; i++){
			form.elements[i].value='';
	}
}//----------------------------------------- FIN FUNCTION [form]



function delete_(){
	a = confirm("Esta operacion nesecita de su aprovacion, Seguro que desea borrar?");
	if(a==true){
		return true;
	}
	else{
	 return false;
	}
}