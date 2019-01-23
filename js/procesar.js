const BUSCAR_AUTO =false,ACTUALIZAR_BUSQUEDA_AUTO=false,ACTUALIZAR_INGRESO_GASTO_AUTO=true, TIEMPO_NOTIFICACION=1500, LIMPIAR_AUTO=true;
var v_ingreso = new Vue ({el : "#resultadosBusqueda_ingresos",data : {datos: ""}});	
var v_gasto = new Vue ({el : "#resultadosBusqueda_gastos",data : {datos: ""}});
var v_entrada = new Vue ({el : "#entrada",data : {datos: es}});						
window.onload = function(){
	autocomplete('Agenda/autocompletar.php');
	if (BUSCAR_AUTO)buscar('Agenda/buscar.php','');
}			
fechaActual = new Date();
if (ACTUALIZAR_INGRESO_GASTO_AUTO) {
	document.getElementById('datePicker_ingreso').valueAsDate = fechaActual;
	document.getElementById('datePicker_gasto').valueAsDate = fechaActual;
}
if (ACTUALIZAR_BUSQUEDA_AUTO){
	document.getElementById('ano').value = fechaActual.getFullYear();
	document.getElementById('mes').value = fechaActual.getMonth()+1;
}
function ingresar(DataBase,dinero){
	var datos;
	var dineroIG = document.getElementsByClassName("ingreso");
	if (dinero == 'gasto')dineroIG = document.getElementsByClassName("gasto");
	if (dineroIG[0].value == "" || dineroIG[2].value == "" || dineroIG[3].value == "" || parseInt(dineroIG[2].value).toString() != dineroIG[2].value){
		$( "#"+dinero+"Revisar" ).fadeIn( TIEMPO_NOTIFICACION, function() {
			$(this).fadeTo(TIEMPO_NOTIFICACION, 0,function() {
				this.style.display = 'none';
				this.style.opacity = '1';
			});
		});
		return;
	}
	datos = {"nombre" : dineroIG[0].value,"descripcion" : dineroIG[1].value,"costo" : dineroIG[2].value,"fecha" : dineroIG[3].value,"tipo" : dineroIG[4].value, "dinero" : dinero};
    $.ajax({
        data: datos,
        type:'get',
        url:DataBase,
        dataType: "json",
        success: function (resultado){
        	if (BUSCAR_AUTO)buscar('Agenda/buscar.php',dineroIG[4].value);
        	if (LIMPIAR_AUTO) {
        		dineroIG[0].value='';
        		dineroIG[1].value='';
        		dineroIG[2].value='';
        	}
			$( "#"+dinero+"Agregado" ).fadeIn( TIEMPO_NOTIFICACION, function() {
				$(this).fadeTo(TIEMPO_NOTIFICACION, 0,function() {
					this.style.display = 'none';
					this.style.opacity = '1';
				});				
			});
			autocomplete('Agenda/autocompletar.php');
        }			        
    });				
}
function buscar(DataBase){
	var datosBusqueda = document.getElementsByClassName("busqueda");
    $.ajax({
        data: {"dinero" : 'ingresos',
    			"nombre" : datosBusqueda[0].value,
    			"descripcion" : datosBusqueda[1].value,
    			"costo" : datosBusqueda[2].value,
    			"ano" : datosBusqueda[3].value,
    			"mes" : datosBusqueda[4].value,
    			"dia" : datosBusqueda[5].value,
    			"tipo" : datosBusqueda[6].value},
        type:'get',
        url:DataBase,
        dataType: "json",
        success: function (resultado){
        	v_ingreso.datos = resultado;
            var total=0;
            for (var i = 0; i < resultado.length; i++) {
            	total+=parseInt(resultado[i].costo);
            }
            document.getElementById("ingreso").innerHTML=total;			            
        }
    });
    $.ajax({
        data: {"dinero" : 'gastos',
    			"nombre" : datosBusqueda[0].value,
    			"descripcion" : datosBusqueda[1].value,
    			"costo" : datosBusqueda[2].value,
    			"ano" : datosBusqueda[3].value,
    			"mes" : datosBusqueda[4].value,
    			"dia" : datosBusqueda[5].value,
    			"tipo" : datosBusqueda[6].value},
        type:'get',
        url:DataBase,
        dataType: "json",
        success: function (resultado){
        	v_gasto.datos = resultado;
            var total=0;
            for (var i = 0; i < resultado.length; i++) {
            	total+=parseInt(resultado[i].costo);
            }
            document.getElementById("gasto").innerHTML=total;	
       		$( "#resultado" ).fadeIn( TIEMPO_NOTIFICACION, function() {
				$(this).fadeTo(TIEMPO_NOTIFICACION, 0,function() {
					this.style.display = 'none';
					this.style.opacity = '1';
				});				
			});		            
        }
    });			    
}	
function autocomplete(DataBase){
	var nombre = document.getElementsByClassName('nombre');
	var descripcion = document.getElementsByClassName('descripcion');
    $.ajax({
        type:'get',
        url:DataBase,
        dataType: "json",
        success: function (resultado){     
            v_entrada.datos.nombreIngreso = resultado.nombreIngreso;
            v_entrada.datos.descripcionIngreso = resultado.descripcionIngreso;
            v_entrada.datos.nombreGasto = resultado.nombreGasto;
            v_entrada.datos.descripcionGasto = resultado.descripcionGasto;
            v_entrada.datos.nombreIG = resultado.nombreIngreso.concat(resultado.nombreGasto);
            v_entrada.datos.descripcionIG = resultado.descripcionIngreso.concat(resultado.descripcionGasto);   
        }
    });	
}