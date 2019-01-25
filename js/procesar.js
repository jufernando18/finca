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
	document.getElementById('datePicker_Bdesde').valueAsDate = new Date('2018-01-01');
	document.getElementById('datePicker_Bhasta').valueAsDate = fechaActual;
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
	var datosBusqueda = document.getElementsByClassName("busqueda"), buscarIngresos=false,buscarGastos=false;
    switch (datosBusqueda[8].value){
    	case '' :
	    	buscarIngresos = true;
	    	buscarGastos = true;
	    	break;
    	case 'ingresos' :
	    	buscarIngresos = true;
	    	break;
    	case 'gastos' :
	    	buscarGastos = true;
	    	break;	    		        		
    }
    if (buscarIngresos) {
	    $.ajax({
	        data: {
	    			"id" : datosBusqueda[0].value,    	        	
	    			"nombre" : datosBusqueda[1].value,
	    			"descripcion" : datosBusqueda[2].value,
	    			"costo" : datosBusqueda[3].value,
	    			"ano" : datosBusqueda[4].value,
	    			"mes" : datosBusqueda[5].value,
	    			"dia" : datosBusqueda[6].value,
	    			"tipo" : datosBusqueda[7].value,
	    			"dinero" : 'ingresos',			    			
	    			"desde" : datosBusqueda[9].value,
	    			"hasta" : datosBusqueda[10].value},
	        type:'get',
	        url:DataBase,
	        dataType: "json",
	        success: function (resultado){
	        	v_ingreso.datos = resultado;
	            var totalIngresos=0, totalDeudas=0;
	            for (var i = 0; i < resultado.length; i++) {
	            	if (isNaN(parseInt(resultado[i].costo))) {
	            	}else if(parseInt(resultado[i].costo)<0){
	            		totalDeudas+=parseInt(resultado[i].costo);
	            	}else{
	            		totalIngresos+=parseInt(resultado[i].costo);
	            	}
	            }
	            document.getElementById("ingreso").innerHTML="Ingresos: "+totalIngresos+" | Deuda: "+totalDeudas;			            
	        }
	    });
    }	
    if (buscarGastos) {
	    $.ajax({
	        data: {
	    			"id" : datosBusqueda[0].value,    	        	
	    			"nombre" : datosBusqueda[1].value,
	    			"descripcion" : datosBusqueda[2].value,
	    			"costo" : datosBusqueda[3].value,
	    			"ano" : datosBusqueda[4].value,
	    			"mes" : datosBusqueda[5].value,
	    			"dia" : datosBusqueda[6].value,
	    			"tipo" : datosBusqueda[7].value,
	    			"dinero" : 'gastos',			    			   			
	    			"desde" : datosBusqueda[9].value,
	    			"hasta" : datosBusqueda[10].value},
	        type:'get',
	        url:DataBase,
	        dataType: "json",
	        success: function (resultado){
	        	v_gasto.datos = resultado;
	            var totalGastos=0, totalDeudas=0;
	            for (var i = 0; i < resultado.length; i++) {
	            	if (isNaN(parseInt(resultado[i].costo))) {
	            	}else if(parseInt(resultado[i].costo)<0){
	            		totalDeudas+=parseInt(resultado[i].costo);
	            	}else{
	            		totalGastos+=parseInt(resultado[i].costo);
	            	}
	            }
	            document.getElementById("gasto").innerHTML="Gastos: "+totalGastos+" | Deuda: "+totalDeudas;
	       		$( "#resultadoBuscar" ).fadeIn( TIEMPO_NOTIFICACION, function() {
					$(this).fadeTo(TIEMPO_NOTIFICACION, 0,function() {
						this.style.display = 'none';
						this.style.opacity = '1';
					});				
				});		            
	        }
	    });			    
    }
}	
function pagar(DataBase){
	var datosBusqueda = document.getElementsByClassName("busqueda"), buscarIngresos=false,buscarGastos=false;
    switch (datosBusqueda[8].value){
    	case '' :
	    	buscarIngresos = false;
	    	buscarGastos = false;
			$( "#resultadoRevisar" ).fadeIn( TIEMPO_NOTIFICACION, function() {
				$(this).fadeTo(TIEMPO_NOTIFICACION, 0,function() {
					this.style.display = 'none';
					this.style.opacity = '1';
				});
			});   			    	
	    	break;
    	case 'ingresos' :
	    	buscarIngresos = true;
	    	break;
    	case 'gastos' :
	    	buscarGastos = true;
	    	break;	    		        		
    }
    if (buscarIngresos) {
	    $.ajax({
	        data: {
	    			"id" : datosBusqueda[0].value,    	        	
	    			"nombre" : datosBusqueda[1].value,
	    			"descripcion" : datosBusqueda[2].value,
	    			"costo" : datosBusqueda[3].value,
	    			"ano" : datosBusqueda[4].value,
	    			"mes" : datosBusqueda[5].value,
	    			"dia" : datosBusqueda[6].value,
	    			"tipo" : datosBusqueda[7].value,
	    			"dinero" : 'ingresos',			    			
	    			"desde" : datosBusqueda[9].value,
	    			"hasta" : datosBusqueda[10].value},
	        type:'get',
	        url:DataBase,
	        dataType: "json",
	        success: function (resultado){
	        	buscar('Agenda/buscar.php');			            
	        }
	    });
    }	
    if (buscarGastos) {
	    $.ajax({
	        data: {
	    			"id" : datosBusqueda[0].value,    	        	
	    			"nombre" : datosBusqueda[1].value,
	    			"descripcion" : datosBusqueda[2].value,
	    			"costo" : datosBusqueda[3].value,
	    			"ano" : datosBusqueda[4].value,
	    			"mes" : datosBusqueda[5].value,
	    			"dia" : datosBusqueda[6].value,
	    			"tipo" : datosBusqueda[7].value,
	    			"dinero" : 'gastos',			    			   			
	    			"desde" : datosBusqueda[9].value,
	    			"hasta" : datosBusqueda[10].value},
	        type:'get',
	        url:DataBase,
	        dataType: "json",
	        success: function (resultado){
				buscar('Agenda/buscar.php');	            
	       		$( "#resultadoPagar" ).fadeIn( TIEMPO_NOTIFICACION, function() {
					$(this).fadeTo(TIEMPO_NOTIFICACION, 0,function() {
						this.style.display = 'none';
						this.style.opacity = '1';
					});				
				});		            				
	        }
	    });			    
    }


}	
function borrar(DataBase){
	var datosBusqueda = document.getElementsByClassName("busqueda");
   	if (datosBusqueda[8].value == ''){
		$( "#resultadoRevisar" ).fadeIn( TIEMPO_NOTIFICACION, function() {
			$(this).fadeTo(TIEMPO_NOTIFICACION, 0,function() {
				this.style.display = 'none';
				this.style.opacity = '1';
			});
		});   		
    }else{
		$.ajax({
	        data: {
	    			"id" : datosBusqueda[0].value,    	        	
	    			"nombre" : datosBusqueda[1].value,
	    			"descripcion" : datosBusqueda[2].value,
	    			"costo" : datosBusqueda[3].value,
	    			"ano" : datosBusqueda[4].value,
	    			"mes" : datosBusqueda[5].value,
	    			"dia" : datosBusqueda[6].value,
	    			"tipo" : datosBusqueda[7].value,
	    			"dinero" : datosBusqueda[8].value,			    			
	    			"desde" : datosBusqueda[9].value,
	    			"hasta" : datosBusqueda[10].value},
	        type:'get',
	        url:DataBase,
	        dataType: "json",
	        success: function (resultado){
	        	document.getElementsByClassName("busqueda")[0].value = '';
	       		$( "#resultadoBorrar" ).fadeIn( TIEMPO_NOTIFICACION, function() {
					$(this).fadeTo(TIEMPO_NOTIFICACION, 0,function() {
						this.style.display = 'none';
						this.style.opacity = '1';
					});				
				});		            	        				            
	        }
	    });
    }
}
function autocomplete(DataBase){
	var nombre = document.getElementsByClassName('nombre');
	var descripcion = document.getElementsByClassName('descripcion');
    $.ajax({
        type:'get',
        url:DataBase,
        dataType: "json",
        success: function (resultado){   
            if (typeof resultado.nombreIngreso !== "undefined" && typeof resultado.nombreGasto !== "undefined"){
            }else if (typeof resultado.nombreIngreso !== "undefined" || typeof resultado.nombreGasto !== "undefined"){
	        	if (typeof resultado.nombreIngreso !== "undefined"){
	        		v_entrada.datos.nombreIngreso = resultado.nombreIngreso;
	        		v_entrada.datos.nombreIG = resultado.nombreIngreso;
	        	}
	            if (typeof resultado.nombreGasto !== "undefined"){
	            	v_entrada.datos.nombreGasto = resultado.nombreGasto;            	
	            	v_entrada.datos.nombreIG = resultado.nombreGasto;
	            }
            }else{
	            v_entrada.datos.nombreIG = resultado.nombreIngreso.concat(resultado.nombreGasto);
        	}
            if (typeof resultado.descripcionIngreso !== "undefined" && typeof resultado.descripcionGasto !== "undefined"){
            }else if (typeof resultado.descripcionIngreso !== "undefined" || typeof resultado.descripcionGasto !== "undefined"){
	        	if (typeof resultado.descripcionIngreso !== "undefined"){
	        		v_entrada.datos.descripcionIngreso = resultado.descripcionIngreso;
	        		v_entrada.datos.descripcionIG = resultado.descripcionIngreso;
	        	}
	            if (typeof resultado.descripcionGasto !== "undefined"){
	            	v_entrada.datos.descripcionGasto = resultado.descripcionGasto;            	
	            	v_entrada.datos.descripcionIG = resultado.descripcionGasto;
	            }
            }else{
	            v_entrada.datos.descripcionIG = resultado.descripcionIngreso.concat(resultado.descripcionGasto);
        	}        	          	
        }
    });	
}