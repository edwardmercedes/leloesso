window.onload = function(){
	link_activo();
}





/*
	*VAMOS A PONERLE UNA CLASE A LOS ACTIVOS LINK DEL MENU
*/
function link_activo(){
	lista_a_reportes = document.getElementById("new_report");
	a_lista = document.getElementsByTagName("a");
	for(i=0; i < a_lista.length; i++){
		a_lista[i].onclick = function(){
			for(i=0; i < a_lista.length; i++){
				a_lista[i].setAttribute('id',' ');
			}
			this.setAttribute('id','activo');
			
			//FUNCION AJAX PARA CARGAR LOS REPORTE DESDE EL MENU PRINCIPLA 1.0
			reporte_principal=crearXMLHttpRequest();
			reporte_principal.onreadystatechange = process_reporte_principal;
			reporte_principal.open('GET','ajax/'+this.title, true);		
			reporte_principal.send(null);	
		}
	}
}




/*
	*PASAR PARAMETRO DE FECHA ENTRE LOS AJAX
*/
function dosfecha(){
	inicio = document.getElementById("inicio").value;
	fin = document.getElementById("final").value;
	pag = document.getElementById("activo").title+'?';
	
	if(fin == '' && inicio==''){
		alert("Las fechas son necesarioas por favor llenar");		
	}
	else{
		//FUNCION AJAX PARA CARGAR LOS REPORTE DESDE EL MENU PRINCIPLA 1.0
		reporte_principal=crearXMLHttpRequest();
		reporte_principal.onreadystatechange = process_reporte_principal;
		reporte_principal.open('GET','ajax/'+pag+'&inicio='+inicio+'&fin='+fin, true);		
		reporte_principal.send(null);	
	}
}

/*
	*PASAR PARAMETRO DE FECHA ENTRE LOS AJAX 
	* PASAR SOLAMENTE EL ANO
*/
function un_ano(valor){
	pag = document.getElementById("activo").title+'?ano='+valor;
	//FUNCION AJAX PARA CARGAR LOS REPORTE DESDE EL MENU PRINCIPLA 1.0
	reporte_principal=crearXMLHttpRequest();
	reporte_principal.onreadystatechange = process_reporte_principal;
	reporte_principal.open('GET','ajax/'+pag, true);		
	reporte_principal.send(null);
}






//***************************************
//Funciones que procesan las repuesta del servidor
//***************************************

//-- 1.0
function process_reporte_principal(){
  var resultados = document.getElementById("cargar");
  if(reporte_principal.readyState == 4)
  {
	resultados.innerHTML = reporte_principal.responseText;
  }
  else{
	  resultados.innerHTML = '<div id="procesando"><img src="images/ruedas.gif" title="Trabajando"/><p>Procesando...</p></div>';
  }
}











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