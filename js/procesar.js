const BUSCAR_AUTO =true,ACTUALIZAR_BUSQUEDA_AUTO=false,ACTUALIZAR_INGRESO_GASTO_AUTO=true, TIEMPO_NOTIFICACION=1000, TIEMPO_NOTIFICACION_OK=1000, TIEMPO_NOTIFICACION_FAIL=3000, LIMPIAR_AUTO=true,TITULO=true;
var v_ingreso = new Vue ({el : "#resultadosBusqueda_ingresos",data : {datos: ""}});	
var v_gasto = new Vue ({el : "#resultadosBusqueda_gastos",data : {datos: ""}});
var v_entrada = new Vue ({el : "#header",data : {datos: es}});	
var token;			
let login = new Login;
let crud = new Crud;		
window.onload = function(){
	let tokenIndex = document.URL.indexOf('?')+1;
	if (tokenIndex) {
		token = document.URL.substr(tokenIndex);
		crud.pedirIngreso();
		login.ingresar('Agenda/ingresar.php');
		window.history.replaceState({}, document.title, document.URL.substr(0,tokenIndex-"index.html?".length));
	} else{
		document.getElementById('salir').style.display = 'none';
		document.getElementById('contenido').style.display = 'none';
		document.getElementById('login').style.display = 'block';
	}
}			
fechaActual = new Date();
if (ACTUALIZAR_INGRESO_GASTO_AUTO) {
	document.getElementById('datePicker_ingreso').valueAsDate = fechaActual;
	document.getElementById('datePicker_gasto').valueAsDate = fechaActual;
	document.getElementById('datePicker_Bdesde').valueAsDate = new Date('2018-01-01');
	document.getElementById('datePicker_Bhasta').valueAsDate = fechaActual;
	document.getElementById('datePicker_Bpago').valueAsDate = fechaActual;
}
if (ACTUALIZAR_BUSQUEDA_AUTO){
	document.getElementById('ano').value = fechaActual.getFullYear();
	document.getElementById('mes').value = fechaActual.getMonth()+1;
}
