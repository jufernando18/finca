const BUSCAR_AUTO =true,ACTUALIZAR_BUSQUEDA_AUTO=false,ACTUALIZAR_INGRESO_GASTO_AUTO=true, TIEMPO_NOTIFICACION=1000, TIEMPO_NOTIFICACION_OK=1000, TIEMPO_NOTIFICACION_FAIL=3000, LIMPIAR_AUTO=true;
var v_ingreso = new Vue ({el : "#resultadosBusqueda_ingresos",data : {datos: ""}});	
var v_gasto = new Vue ({el : "#resultadosBusqueda_gastos",data : {datos: ""}});
var v_entrada = new Vue ({el : "#header",data : {datos: es}});	
var usuario;					
window.onload = function(){
	usuario = document.URL.indexOf('?')+1;
	if (usuario) {
		document.getElementById('salir').style.display = 'block';
		document.getElementById('contenido').style.display = 'block';
		document.getElementById('login').style.display = 'none';
		v_entrada.datos.titulo =  document.URL.substr(usuario).split('&')[1].split('=')[1].replace(/%20/g, " ");
		usuario =  document.URL.substr(usuario).split('&')[0].split('=')[1];
		autocompletar('Agenda/autocompletar.php');	
		if (BUSCAR_AUTO) buscar('Agenda/buscar.php');
	} else{
		//alert("Para administrar sus registros, primero debe iniciar sesión");
		document.getElementById('salir').style.display = 'none';
		document.getElementById('contenido').style.display = 'none';
		document.getElementById('login').style.display = 'block';
	}
	console.log(usuario);
	console.log(v_entrada.datos.titulo );
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
