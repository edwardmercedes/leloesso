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

//valores de un formulario
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



function delete_(){
	a = confirm("Esta operacion nesecita de su aprovacion, Seguro que desea borrar?");
	if(a==true){
		return true;
	}
	else{
	 return false;
	}
}

function novacio_from(name){
	form = document.getElementById(name);
	numberElements = form.elements.length;
	for(i=0; i < numberElements; i++){
		if(form.elements[i].type=='hidden' || form.elements[i].type=='button'){
			
		}
		else{
			if(form.elements[i].value==''){
				alert("Hay campos vacios, por favor llenalo");
			 	return false;	
			}
		}
	}
	form.submit();
}//----------------------------------------- FIN FUNCTION [form]



function login(){
	login_form = document.getElementById("login_form");		
	if(login_form.Username.value == ''){
		alert("El nombre de usuario es obligatorio");
		login_form.Username.focus();
		return false;
	}
	if(login_form.Password.value == ''){
		alert("La clave es obligatoria");
		login_form.Password.focus();
		return false;
	}
	login_form.submit();
}
//numero de factural
function factura(){
	factura =document.getElementById("factura");
	fiscal =document.getElementById("fiscal");
	if(factura.value==''){
		alert("No se agrego le Numero de la Factura");	
		document.getElementById("span_factura").innerHTML='';
	}
	else{
		document.getElementById("span_factura").innerHTML='N0.Factura: '+factura.value;
	}
	if(fiscal.value==''){
		alert("No se agrego le Numero de Comprobante");	
		document.getElementById("span_fiscal").innerHTML='';
	}
	else{
		document.getElementById("span_fiscal").innerHTML='NCF: '+fiscal.value;
	}
return false;	
}
function resument(e,div){
	mostar_object=document.getElementById(div);
	if(e.checked){
	mostar_object.style.display="block";
	}
	else{
	mostar_object.style.display="none";	
	}
	
}
/*----------------------- -----------------------*/
// 				AJAX FUNCIONES ESPECIALES
/*----------------------- -----------------------*/


/*
---------------------------------------
 					  buscar cliente  -----------------
---------------------------------------
*/
function cargar_cliente(){
	from = document.buscar_client_form;
	
	if(from.codigo.value!=''){
		list_clients=crearXMLHttpRequest();
		list_clients.onreadystatechange = process_listClient;
		list_clients.open('GET','ajax/list_client.php?codigo='+from.codigo.value+'&tipo='+from.tipo.value, true);		
//		list_clients.open('GET','ajax/list_client.php?codigo='+from.codigo.value, true);
		list_clients.send(null);
	}
	else{
		if(from.nombre.value != ''){
			list_clients=crearXMLHttpRequest();
			list_clients.onreadystatechange = process_listClient;
			list_clients.open('GET','ajax/list_client.php?nombre='+from.nombre.value+'&tipo='+from.tipo.value, true);		
			list_clients.send(null);
		}
		else{
			list_clients=crearXMLHttpRequest();
			list_clients.onreadystatechange = process_listClient;
			list_clients.open('GET','ajax/list_client.php?tipo='+from.tipo.value, true);		
			list_clients.send(null);	
		}
	}
}
//--process_listClient
function process_listClient(){
  var resultados = document.getElementById("list_clients");
  if(list_clients.readyState == 4)
  {
	resultados.innerHTML = list_clients.responseText;
  } 
}

/*
---------------------------------------
  				   tipo de informacion -----------------
---------------------------------------
*/
function tipo_informacion(e){
	tipo=crearXMLHttpRequest();
	tipo.onreadystatechange = process_tipo;
	tipo.open('GET','ajax/'+e.value, true);		
	tipo.send(null);
}
function process_tipo(){
  var Tipo_resultados = document.getElementById("tipo_information");
  if(tipo.readyState == 4){
	Tipo_resultados.innerHTML = tipo.responseText;
  } 
}


/*
---------------------------------------
 					  ESTADO DE CUENTA -----------------
---------------------------------------
*/
function tipo_cuenta(e,id){
	tipo_cuenta=crearXMLHttpRequest();
	tipo_cuenta.onreadystatechange = process_tipo_cuenta;
	tipo_cuenta.open('GET','ajax/estado_'+e+'.php?id='+id, true);	
	tipo_cuenta.send(null);
}
//--process_tipo_cuenta
function process_tipo_cuenta(){
  var tipo_cuenta_resultados = document.getElementById("tipodecuenta");
  if(tipo_cuenta.readyState == 4)
  {
	tipo_cuenta_resultados.innerHTML = tipo_cuenta.responseText;
  } 
}



/*
---------------------------------------
 					  TIPO DE REPORTE -----------------
---------------------------------------
*/
function tipo_gerenal_report(){
// asegurarnos que las fechas estan llenas
	form_ = document.fechas_reporte;
	if(form_.fecha.value==""){
		alert("Por favor ingrese una fecha de inicio para el reporte");
		return false;
		}
	if(form_.fecha2.value==""){
		alert("Por favor ingrese una fecha de Limite para el reporte");
		return false;
		}
  	var i 
   	for (i=0;i<form_.tipo_repor.length;i++){ 
      	 if (form_.tipo_repor[i].checked) 
         	 break; 
 	} 
//creamos el ajax objecto		
	report =crearXMLHttpRequest();
	report.onreadystatechange = process_report;
	report.open('GET','ajax/'+form_.tipo_repor[i].value+'?f1='+form_.fecha.value+'&f2='+form_.fecha2.value, true);	
	report.send(null);
}
//--procesar reportes
function process_report(){
  var tipo_reporte_general = document.getElementById("tipo_reporte_general");
  if(report.readyState == 4)
  {
	tipo_reporte_general.innerHTML = report.responseText;
  } 
  else{
	  tipo_reporte_general.innerHTML = '<br><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/loding.gif"> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><i>Procesando Reporte</i><label>';
  }
}

/*
---------------------------------------
	  FUNTION PARA VENTA AL CONTADO -----------------
---------------------------------------
*/
function contado(valor){
	contado =crearXMLHttpRequest();
	contado.onreadystatechange = process_contado;
	contado.open('GET','ajax/'+valor, true);	
	contado.send(null);
}
function process_contado(){
	div = document.getElementById("contado");
	if(contado.readyState == 4){
		div.innerHTML = contado.responseText; 
	}
	else{
		div.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/loding.gif"> <br> <i>Procesando Reporte</i>'; 		
	}
}
function contado_add(){
	conb = document.getElementById("combust").value;
	precio = document.getElementById("precio").value;
	valor = document.getElementById("valor").value;

	contado =crearXMLHttpRequest();
	contado.onreadystatechange = process_contado;
	contado.open('GET','ajax/contado_add_form.php?do=2&comb='+conb+'&precio='+precio+'&valor='+valor, true);	
	contado.send(null);

}
function contado_edit_form(id){
	contado =crearXMLHttpRequest();
	contado.onreadystatechange = process_contado;
	contado.open('GET','ajax/contado_add_form.php?do=3&id='+id, true);	
	contado.send(null);
}
function contado_edit(id){
	conb = document.getElementById("combust").value;
	precio = document.getElementById("precio").value;
	valor = document.getElementById("valor").value;
	contado =crearXMLHttpRequest();
	contado.onreadystatechange = process_contado;
	contado.open('GET','ajax/contado_add_form.php?do=4&comb='+conb+'&precio='+precio+'&valor='+valor+'&id='+id, true);
	contado.send(null);
}
function boorar(id){
	contado =crearXMLHttpRequest();
	contado.onreadystatechange = process_contado;
	contado.open('GET','ajax/contado_add_form.php?do=6&id='+id, true);	
	contado.send(null);
}

/*
	---PRINT AND SAVE EL COMPROBANTE CREDITOS
*/
function print_estado_credito(){
	g_estado_credito_ncf();
	window.print();
}
function g_estado_credito_ncf(){
//variables	
	var id_cliente = document.getElementById("id").value;
	var fecha = document.getElementById("fecha").value;
	var fecha2 = document.getElementById("fecha2").value;	
	var nrc = document.getElementById("fiscal").value;	
	var id_user = document.getElementById("id_user_guardar").value;	
	var url = "ajax/guardar_credito.php?nrc="+nrc+"&id_cliente="+id_cliente+"&fecha="+fecha+"&fecha2="+fecha2+"&id_user="+id_user;
//objeto ajax	
	credito_ncf =crearXMLHttpRequest();
//	credito_ncf.onreadystatechange = process_contado;
	credito_ncf.open('GET',url, true);	
	credito_ncf.send(null);	
	
}

/*
---------------------------------------
 					  buscar factura  -----------------
---------------------------------------
*/
function buscar_ncf(){
	form = document.getElementById("form");//buscamos el formulario
	query_string = "";//guarda la construccion de variables
	numero_element = form.length;//contar el numero de element
	
//un for donde busco todo los elemento y su valor y lo ajunto en query_string	
	for(i=0; i < numero_element; i++){
		if( i < numero_element -1){
			query_string += form[i].name+"="+encodeURIComponent(form[i].value)+"&";
		}
		else{
			query_string += form[i].name+"="+encodeURIComponent(form[i].value);
		}
	}
// vamos acontruir el objeto ajax
	buscar_ncf_objecto_ajax =crearXMLHttpRequest();
	buscar_ncf_objecto_ajax.onreadystatechange = process_buscar_ncf_objecto_ajax;
	buscar_ncf_objecto_ajax.open('GET','ajax/ncf_reporte.php?'+query_string, true);	
	buscar_ncf_objecto_ajax.send(null);	
}
function process_buscar_ncf_objecto_ajax(){
	div = document.getElementById("informacion_ncf_lista");
	if(buscar_ncf_objecto_ajax.readyState == 4){
		div.innerHTML = buscar_ncf_objecto_ajax.responseText; 
	}
	else{
		div.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/loding.gif"> <br> <i>Procesando</i>'; 		
	}
}


/*buscar lista de cliente para llenar nfc*/
function ncf_lista_cliente(nombre){
	ncf_lista_client =crearXMLHttpRequest();
	ncf_lista_client.onreadystatechange = process_ncf_lista_client;
	ncf_lista_client.open('GET','ajax/ncf_lista_cliente.php?nombre='+nombre, true);	
	ncf_lista_client.send(null);
}

function process_ncf_lista_client(){
	div = document.getElementById("ncf_lista_cliente");
	if(ncf_lista_client.readyState == 4){
		div.innerHTML = ncf_lista_client.responseText; 
	}
}



/*buscar lista de cliente para llenar nfc*/
function ncf_lista_cliente_cargar(rnc){
	input = document.getElementById("cliente");
	input.value=rnc;
	buscar_ncf();
}



/*
---------------------------------------
 QUE NO SE ENVIE LA FACTURA SIN VALOR  -----------------
---------------------------------------
*/
function no_vacio_fact(){
form = document.getElementById("no_vacio_fact");
	if(form.fecha.value==''){
		alert("La fecha de la factura es obligatoria por favor agregar");
		return false;
	}
	if(form.precio_combustible.value==''){
		alert("El Precio Combustible es obligatorio por favor agregar");
		return false;
	}
	if(form.valor.value==''){
		alert("El Valor de la factura es obligatorio por favor agregar");
		return false;
	}
form.submit();		
}

function no_vacio_pagos(){
form = document.getElementById("form_vacio");
	if(form.fecha.value==''){
		alert("La fecha del pago es obligatorio por favor agregar");
		return false;
	}
	if(form.valor_cheque.value==''){
		alert("El valor de cheque es obligatorio por favor agregar");
		return false;
	}
form.submit();
}

/* Create pop up */
function abrirPopUp(url,h,w,titulo){ 
	ven_secu = window.open(url,titulo,"width="+w+",height="+h+",menubar=no");
	ven_secu.focus();
} 
function cerrarPopUp(){ 
	ven_secu.close();
} 

/*
---------------------------------------
 		IR CONSIGIENTE LOS NOMBRE DE LA FACTURA AL CONTADO QUE CONICIDAN CON LA LETRA
---------------------------------------
*/
function nombreFacturaContadoget(string){
	nombreFacturaContado = crearXMLHttpRequest();
	nombreFacturaContado.onreadystatechange = process_nombreFacturaContado;
	nombreFacturaContado.open('GET','ajax/facturaContadoNombre.php?nombre='+string, true);	
	nombreFacturaContado.send(null);
	
}
function process_nombreFacturaContado(){
	if(nombreFacturaContado.readyState == 4){
		document.getElementById("facturaContadonombreDrop").innerHTML = nombreFacturaContado.responseText; 
	} 
}
// desoyes de elegir un cliente
function nombreFacturaElegido(ob){
	document.getElementById('nombreFacturaContadoInput').value = ob.title;
	document.getElementById('nombreFacturaContadoInputDireccion').value = ob.className;
	document.getElementById('nombreFacturaContadoInputTelefono').value = ob.name;
	document.getElementById('nombreFacturaContadoInputRNC').value = ob.id;
	
	document.getElementById("facturaContadonombreDrop").innerHTML = '';
	document.getElementById("sinoaparececliente").innerHTML = '';
	
	
	nombreFacturaContado = crearXMLHttpRequest();
	nombreFacturaContado.onreadystatechange = process_nombreFacturaContado;
	nombreFacturaContado.open('GET','ajax/facturaContadoAddSeccion.php?id='+ob.id, true);	
	nombreFacturaContado.send(null);
	
}

function nombreFacturaContadoNcf(ob){
	
	if(ob.value.length == 19){
		nombreFacturaContado = crearXMLHttpRequest();
		nombreFacturaContado.onreadystatechange = process_nombreFacturaContadoNcf;
		nombreFacturaContado.open('GET','ajax/facturaContadoNcf.php?id='+ob.value, true);	
		nombreFacturaContado.send(null);
	}
}
function  process_nombreFacturaContadoNcf(){
	if(nombreFacturaContado.readyState == 4){
		if(nombreFacturaContado.responseText != ''){
			document.getElementById("nombreFacturaContadoInputNCF").style.color = '#f00';	 
		}
		else{
			document.getElementById("nombreFacturaContadoInputNCF").style.color = '#000';	 
		}
	} 	
}



/*
---FUNCINOES PARA LOS PROBLEMAS AJAX
*/
//***************************************
//Funciones comunes a todos los problemas
//***************************************
function addEvent(elemento,nomevento,funcion,captura)
{
  if (elemento.attachEvent)
  {
    elemento.attachEvent('on'+nomevento,funcion);
    return true;
  }
  else  
    if (elemento.addEventListener)
    {
      elemento.addEventListener(nomevento,funcion,captura);
      return true;
    }
    else
      return false;
}

function crearXMLHttpRequest() 
{
  var xmlHttp=null;
  if (window.ActiveXObject) 
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  else 
    if (window.XMLHttpRequest) 
      xmlHttp = new XMLHttpRequest();
  return xmlHttp;
}
