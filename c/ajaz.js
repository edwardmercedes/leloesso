/*CARGAR FORMULARIOS*/
function add_cliente(){
	input = document.getElementById("rnc");
	
	nrc=crearXMLHttpRequest();
	nrc.onreadystatechange = process_add_cliente;
	nrc.open('GET','ajax/client_form.php?id='+input.value, true);		
	nrc.send(null);
}
	function process_add_cliente(){
	  var div = document.getElementById("campos_form");
	  if(nrc.readyState == 4){
		div.innerHTML = nrc.responseText;
	  } 
	}
/*
 * verificar numero de comprobante fiscal
 * Asegurarno de ser unico
*/	
function n_fiscal(){
	input = document.getElementById("fiscal");
	fiscal=crearXMLHttpRequest();
	fiscal.onreadystatechange = process_fiscal;
	fiscal.open('GET','ajax/verificar_comprobante.php?id='+input.value, true);		
	fiscal.send(null);
}
	function process_fiscal(){
	  var div = document.getElementById("campos_form");
	  if(fiscal.readyState == 4){
		div.innerHTML = fiscal.responseText;
	  } 
	}
	
/*
 * GUARDAR LA FACTURAL AL CONTADO 
 * Print la pagina
*/	
function print_contado(){
	
	erro = 0;
	//validar no vacio o\\contado
	form = document.getElementById("control");
	
	numberElements = form.elements.length;
	for(i=0; i < numberElements; i++){
		if(form.elements[i].value==''){
			erro = erro + 1;
			alert("Error en: '" + form.elements[i].name + "' Por favor corrija");
		}
	}
	if(erro >= 1){
		return false;
	}
	else{
		
		g_contado();
		/*abrirPopUp('ncf_reporte.php','500','500','Factura')*/
		//document.location.href = 'ncf_reporte.php';
	}
	
}

function g_contado(){
	
	contado=crearXMLHttpRequest();
	contado.onreadystatechange = process_fiscal;
	contado.open('GET','ajax/guardar.php', true);		
	contado.send(null);
}

/*
 * BUSCAR LA LISTA DE LOS CLIENTE POR LOS RNC
 * DEVUELVE LA LISTA DE LOS CLIENTE POR EL RNC
*/	
function select_lista_cliente(id){
	select_list_client = crearXMLHttpRequest();
	select_list_client.onreadystatechange = process_select_lista_cliente;
	select_list_client.open('GET','ajax/rnc_lista.php?id='+id, true);
	select_list_client.send(null);
}
function process_select_lista_cliente(){
  var div = document.getElementById("lista_cliente");
  if(select_list_client.readyState == 4){
		div.innerHTML = select_list_client.responseText;
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
