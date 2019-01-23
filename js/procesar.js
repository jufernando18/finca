const BUSCAR_AUTO =false,ACTUALIZAR_BUSQUEDA_AUTO=false,ACTUALIZAR_INGRESO_GASTO_AUTO=true, TIEMPO_NOTIFICACION=1500;
var v_ingreso = new Vue ({
    el : "#resultadosBusqueda_ingresos",
    data : {
        datos: ""
    }
});	
var v_gasto = new Vue ({
    el : "#resultadosBusqueda_gastos",
    data : {
        datos: ""
    }
});
var v_entrada = new Vue ({
    el : "#entrada",
    data : {
        datos: es
    }
});						
window.onload = function(){
	seleccionTipo('Principal');
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
	var datos, tipo = v_entrada.datos.estado;
	var ingresos = document.getElementsByClassName("ingreso");
	if (dinero == 'gasto')ingresos = document.getElementsByClassName("gasto");
	if (ingresos[0].value == "" || ingresos[2].value == "" || ingresos[3].value == "" || parseInt(ingresos[2].value).toString() != ingresos[2].value){
		$( "#"+dinero+"Revisar" ).fadeIn( TIEMPO_NOTIFICACION, function() {
			$(this).fadeTo(TIEMPO_NOTIFICACION, 0,function() {
				this.style.display = 'none';
				this.style.opacity = '1';
			});
		});
		return;
	}
	datos = {"nombre" : ingresos[0].value,"descripcion" : ingresos[1].value,"costo" : ingresos[2].value,"fecha" : ingresos[3].value,"tipo" : tipo, "dinero" : dinero};
    $.ajax({
        data: datos,
        type:'get',
        url:DataBase,
        dataType: "json",
        success: function (resultado){
        	if (BUSCAR_AUTO)buscar('Agenda/buscar.php',tipo);
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
function seleccionTipo(tipo){
	v_entrada.datos.estado=v_entrada.datos[tipo+'_m'];
	document.getElementById('ingresos').className="ni";		
	document.getElementById('gastos').className="ni";
	if (v_entrada.datos.estado!='') {
		document.getElementById('ingresos').className="";		
		document.getElementById('gastos').className="";
	}
	document.getElementById('estado').innerHTML=tipo + "<hr/>" + v_entrada.datos[tipo];
	document.getElementById("tipo").value=v_entrada.datos.estado;
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
	var nombreIngreso = [],descripcionIngreso = [],nombreGasto = [],descripcionGasto = [];
    $.ajax({
        type:'get',
        url:DataBase,
        dataType: "json",
        success: function (resultado){
        	if (resultado.nombreIngreso) {
	            for(var i=0, dato=[];i<resultado.nombreIngreso.length;i++){
	                nombreIngreso.push(resultado.nombreIngreso[i]);
	                descripcionIngreso.push(resultado.descripcionIngreso[i]);
	            }        		
        	}
            if (resultado.nombreGasto) {
	            for(var i=0, dato=[];i<resultado.nombreGasto.length;i++){
	                nombreGasto.push(resultado.nombreGasto[i]);
	                descripcionGasto.push(resultado.descripcionGasto[i]);
	            }   
            }         
			$(nombre[0]).autocomplete({ 
		    	source: nombreIngreso 
		    }); 
			$(descripcion[0]).autocomplete({ 
		    	source: descripcionIngreso
		    });   
			$(nombre[1]).autocomplete({ 
		    	source: nombreGasto 
		    });     
			$(descripcion[1]).autocomplete({ 
		    	source: descripcionGasto 
		    });   		  
			$(nombre[2]).autocomplete({ 
		    	source: nombreIngreso.concat(nombreGasto)
		    });     
			$(descripcion[2]).autocomplete({ 
		    	source: descripcionIngreso.concat(descripcionGasto)
		    });   		      
        }
    });	
}