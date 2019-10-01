const BUSCAR_AUTO =true,ACTUALIZAR_BUSQUEDA_AUTO=false,ACTUALIZAR_INGRESO_GASTO_AUTO=true, TIEMPO_NOTIFICACION=1000, TIEMPO_NOTIFICACION_OK=1000, TIEMPO_NOTIFICACION_FAIL=3000, LIMPIAR_AUTO=true,TITULO=true;
var v_ingreso = new Vue ({el : "#resultadosBusqueda_ingresos",data : {datos: ""}});	
var v_gasto = new Vue ({el : "#resultadosBusqueda_gastos",data : {datos: ""}});
var v_entrada = new Vue ({el : "#header-body",data : {datos: es}});	
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
fechaActual = new Date().toLocaleString("en-US", {timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone});
fechaActual = new Date(fechaActual);
if (ACTUALIZAR_INGRESO_GASTO_AUTO) {
	document.getElementById('datePicker_agregarInfo').valueAsDate = fechaActual;
	document.getElementById('datePicker_Bdesde').valueAsDate = new Date('2018-01-01');
	document.getElementById('datePicker_Bhasta').valueAsDate = fechaActual;
	document.getElementById('datePicker_Bpago').valueAsDate = fechaActual;
}
if (ACTUALIZAR_BUSQUEDA_AUTO){
	document.getElementById('ano').value = fechaActual.getFullYear();
	document.getElementById('mes').value = fechaActual.getMonth()+1;
}
v_entrada.datos.showIngreso = false;
v_entrada.datos.showRegistro = false;
v_entrada.datos.showIngresoInfo = false;
v_entrada.datos.showBuscar = false;
function toogleIngreso() {
	console.log('toogleIngreso: ', v_entrada.datos.showIngreso, ' to: ', !v_entrada.datos.showIngreso);
	v_entrada.datos.showIngreso = !v_entrada.datos.showIngreso;
}
function toogleRegistro() {
	console.log('toogleRegistro: ', v_entrada.datos.showRegistro, ' to: ', !v_entrada.datos.showRegistro);
	v_entrada.datos.showRegistro = !v_entrada.datos.showRegistro;
}
function toogleIngresoInfo() {
	console.log('toogleIngresoInfo: ', v_entrada.datos.showIngresoInfo, ' to: ', !v_entrada.datos.showIngresoInfo);
	v_entrada.datos.showIngresoInfo = !v_entrada.datos.showIngresoInfo;
}
function toogleBuscar() {
	console.log('toogleBuscar: ', v_entrada.datos.showBuscar, ' to: ', !v_entrada.datos.showBuscar);
	v_entrada.datos.showBuscar = !v_entrada.datos.showBuscar;
}