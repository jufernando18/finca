class Crud{
	constructor(datos){
		this._datos=datos;
	}
	insertar(DataBase,dinero){
		var dineroIG = (dinero == 'gasto')?dineroIG = document.getElementsByClassName("gasto"):document.getElementsByClassName("ingreso");
		let _this = this;
		if (dineroIG[0].value == "" || dineroIG[2].value == "" || dineroIG[3].value == "" || parseInt(dineroIG[2].value).toString() != dineroIG[2].value){
			$( "#"+dinero+"Revisar" ).fadeIn(TIEMPO_NOTIFICACION).delay(TIEMPO_NOTIFICACION).fadeTo(TIEMPO_NOTIFICACION,0, function() {
				this.style.display = 'none';
				this.style.opacity = '1';
			});
			return;
		}
		_this._datos = {
			"usuario" : usuario,
			"nombre" : dineroIG[0].value,
			"descripcion" : dineroIG[1].value,
			"costo" : dineroIG[2].value,
			"fecha" : dineroIG[3].value,
			"tipo" : dineroIG[4].value, 
			"dinero" : dinero};
	    $.ajax({
	        data: _this._datos,
	        type:'get',
	        url:DataBase,
	        dataType: "json",
	        success: function (resultado){
	        	if (BUSCAR_AUTO)_this.buscar('Agenda/buscar.php');
	        	if (LIMPIAR_AUTO) {
	        		dineroIG[0].value='';
		        	dineroIG[1].value='';
		        	dineroIG[2].value='';        		
	        	}
				$( "#"+dinero+"Agregado" ).fadeIn(TIEMPO_NOTIFICACION_OK).delay(TIEMPO_NOTIFICACION_OK).fadeTo(TIEMPO_NOTIFICACION_OK,0, function() {
					this.style.display = 'none';
					this.style.opacity = '1';
				});			
				_this.autocompletar('Agenda/autocompletar.php');
	        }			        
	    });				
	}
	buscar(DataBase){
		var datosBusqueda = document.getElementsByClassName("busqueda"), buscarIngresos=false,buscarGastos=false;
		var totalIngresos=0, totalIngresosDeudas=0, totalGastos=0, totalGastosDeudas=0;
		let ingresosElement = document.getElementById("resultadosBusqueda_ingresos");
		let gastosElement = document.getElementById("resultadosBusqueda_gastos");
		let _this =this;
	    switch (datosBusqueda[8].value){
	    	case '' :
		    	buscarIngresos = true;
		    	buscarGastos = true;
		    	ingresosElement.style.display = "";
		    	gastosElement.style.display = "";
		    	break;
	    	case 'ingresos' :
		    	buscarIngresos = true;
		    	ingresosElement.style.display= "";
		    	gastosElement.style.display = "none";
		    	break;
	    	case 'gastos' :
		    	buscarGastos = true;
		    	ingresosElement.style.display = "none";
		    	gastosElement.style.display = "";
		    	break;	    		        		
		}
		_this._datos = {
			"usuario" : usuario ,
			"id" : datosBusqueda[0].value,    	        	
			"nombre" : datosBusqueda[1].value,
			"descripcion" : datosBusqueda[2].value,
			"costo" : datosBusqueda[3].value,
			"ano" : datosBusqueda[4].value,
			"mes" : datosBusqueda[5].value,
			"dia" : datosBusqueda[6].value,
			"tipo" : datosBusqueda[7].value,	    			
			"desde" : datosBusqueda[9].value,
			"hasta" : datosBusqueda[10].value};
	    if (buscarIngresos) {
			_this._datos.dinero = 'ingresos';
		    $.ajax({
		        data: _this._datos,
		        type:'get',
		        url:DataBase,
		        dataType: "json",
		        success: function (resultado){
		        	v_ingreso.datos = resultado;
		            for (var i = 0; i < resultado.length; i++) {
		            	if (isNaN(parseInt(resultado[i].costo))) {
		            	}else if(parseInt(resultado[i].costo)<0){
		            		totalIngresosDeudas+=parseInt(resultado[i].costo);
		            	}else{
		            		totalIngresos+=parseInt(resultado[i].costo);
		            	}
		            }
		            document.getElementById("ingreso").innerHTML="Ingresos: "+totalIngresos.toLocaleString()+" | Deuda: "+totalIngresosDeudas.toLocaleString();
		        }
		    });
	    }	
	    if (buscarGastos) {
			_this._datos.dinero = 'gastos';
		    $.ajax({
		        data: _this._datos,
		        type:'get',
		        url:DataBase,
		        dataType: "json",
		        success: function (resultado){
		        	v_gasto.datos = resultado;
		            for (var i = 0; i < resultado.length; i++) {
		            	if (isNaN(parseInt(resultado[i].costo))) {
		            	}else if(parseInt(resultado[i].costo)<0){
		            		totalGastosDeudas+=parseInt(resultado[i].costo);
		            	}else{
		            		totalGastos+=parseInt(resultado[i].costo);
		            	}
		            }
		            document.getElementById("gasto").innerHTML="Gastos: "+totalGastos.toLocaleString()+" | Deuda: "+totalGastosDeudas.toLocaleString();	            
		        }
		    });			    
	    } 
		$( "#resultadoBuscar" ).fadeIn(TIEMPO_NOTIFICACION_OK).delay(TIEMPO_NOTIFICACION_OK).fadeTo(TIEMPO_NOTIFICACION_OK,0, function() {
			this.style.display = 'none';
			this.style.opacity = '1';
		});	   
	}
	pagar(DataBase){
		var datosBusqueda = document.getElementsByClassName("busqueda");
		let _this = this;
	    switch (datosBusqueda[8].value){
	    	case '' :
				$( "#resultadoRevisar" ).fadeIn(TIEMPO_NOTIFICACION_FAIL).delay(TIEMPO_NOTIFICACION_FAIL).fadeTo(TIEMPO_NOTIFICACION_FAIL,0, function() {
					this.style.display = 'none';
					this.style.opacity = '1';
				});			
				return; 			    	
		    	break;
		}    		        
		if (DataBase == "Agenda/pagar.php"){
			idResultado="resultadoPagar";
			if(!confirm("Está seguro que quiere pagar lo seleccionado?"))return;
		} 
		if (DataBase == "Agenda/deuda_pago.php"){
			idResultado="resultadoDeuda";
			if(!confirm("Está seguro que quiere cambiar de estado lo seleccionado?"))return;
		}
		_this._datos = {
			"usuario" : usuario ,
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
			"hasta" : datosBusqueda[10].value,
			"pago" : datosBusqueda[11].value};
	    $.ajax({
	        data: _this._datos,
	        type:'get',
	        url:DataBase,
	        dataType: "json",
	        success: function (resultado){
	        	datosBusqueda[0].value = '';//se limpia id
	        	if (BUSCAR_AUTO)_this.buscar('Agenda/buscar.php');
				$( "#"+idResultado ).fadeIn(TIEMPO_NOTIFICACION_OK).delay(TIEMPO_NOTIFICACION_OK).fadeTo(TIEMPO_NOTIFICACION_OK,0, function() {
					this.style.display = 'none';
					this.style.opacity = '1';
				});					        				            
	        }
	    });
	}
	borrar(DataBase){
		var datosBusqueda = document.getElementsByClassName("busqueda");
		let _this = this;
	   	if (datosBusqueda[0].value == '' || datosBusqueda[8].value == ''){
			$( "#resultadoRevisar" ).fadeIn(TIEMPO_NOTIFICACION_FAIL).delay(TIEMPO_NOTIFICACION_FAIL).fadeTo(TIEMPO_NOTIFICACION_FAIL,0, function() {
				this.style.display = 'none';
				this.style.opacity = '1';
			});			 		
	    }else{
	    	_this._datos = {
	    		"usuario" : usuario ,
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
				"hasta" : datosBusqueda[10].value};
			$.ajax({
		        data: _this._datos,
		        type:'get',
		        url:DataBase,
		        dataType: "json",
		        success: function (resultado){
		        	document.getElementsByClassName("busqueda")[0].value = '';//se limpia id
		        	if (BUSCAR_AUTO)_this.buscar('Agenda/buscar.php');
		        	_this.autocompletar('Agenda/autocompletar.php');
					$( "#resultadoBorrar" ).fadeIn(TIEMPO_NOTIFICACION_OK).delay(TIEMPO_NOTIFICACION_OK).fadeTo(TIEMPO_NOTIFICACION_OK,0, function() {
						this.style.display = 'none';
						this.style.opacity = '1';
					});					            	        				            
		        }
		    });
	    }
	}	
	autocompletar(DataBase){
		var nombre = document.getElementsByClassName('nombre');
		var descripcion = document.getElementsByClassName('descripcion');
		let _this = this;
		_this._datos = { 
			"usuario" : usuario};
	    $.ajax({
	    	data: _this._datos,
	        type:'get',
	        url:DataBase,
	        dataType: "json",
	        success: function (resultado){   
	            if (typeof resultado.nombreIngreso === "undefined" && typeof resultado.nombreGasto === "undefined"){
	            }else if (typeof resultado.nombreIngreso === "undefined" || typeof resultado.nombreGasto === "undefined"){
		        	if (typeof resultado.nombreIngreso !== "undefined"){
		        		v_entrada.datos.nombreIngreso = resultado.nombreIngreso;
		        		v_entrada.datos.nombreIG = resultado.nombreIngreso;
		        	}
		            if (typeof resultado.nombreGasto !== "undefined"){
		            	v_entrada.datos.nombreGasto = resultado.nombreGasto;            	
		            	v_entrada.datos.nombreIG = resultado.nombreGasto;
		            }
	            }else{
	            	v_entrada.datos.nombreIngreso = resultado.nombreIngreso;
	            	v_entrada.datos.nombreGasto = resultado.nombreGasto; 
		            v_entrada.datos.nombreIG = resultado.nombreIngreso.concat(resultado.nombreGasto);
	        	}
	            if (typeof resultado.descripcionIngreso === "undefined" && typeof resultado.descripcionGasto === "undefined"){
	            }else if (typeof resultado.descripcionIngreso === "undefined" || typeof resultado.descripcionGasto === "undefined"){
		        	if (typeof resultado.descripcionIngreso !== "undefined"){
		        		v_entrada.datos.descripcionIngreso = resultado.descripcionIngreso;
		        		v_entrada.datos.descripcionIG = resultado.descripcionIngreso;
		        	}
		            if (typeof resultado.descripcionGasto !== "undefined"){
		            	v_entrada.datos.descripcionGasto = resultado.descripcionGasto;            	
		            	v_entrada.datos.descripcionIG = resultado.descripcionGasto;
		            }
	            }else{
	            	v_entrada.datos.descripcionIngreso = resultado.descripcionIngreso;
	            	v_entrada.datos.descripcionGasto = resultado.descripcionGasto;   
		            v_entrada.datos.descripcionIG = resultado.descripcionIngreso.concat(resultado.descripcionGasto);
	        	}        	          	
	        }
	    });	
	}				
}
class Login{
	constructor(datos){
		this._datos = datos;
	}
	ingresar(DataBase){
		var input = document.getElementsByClassName('login');
		this._datos = {
			"usuario" : input[0].value,
			"contrasena" : input[1].value};
		$.ajax({
			data: this._datos,
			type:'get',
			url:DataBase,
			dataType: "json",
			success: function (resultado){
				if (resultado['usuarioEstado'] == "true" && resultado['contrasenaEstado'] == "true") {
					document.location.href = 'index.html?usuario='+input[0].value+"&titulo="+resultado.titulo;
				}
			}			        
		});					
	}	
	registrar(DataBase){
		var input = document.getElementsByClassName('registro');
		if (input[1].value.split(' ').length > 1) {
			alert("El nombre de usuario no debe contener espacios");
			return;
		}
		this._datos = {
			"nombre" : input[0].value,
			"usuario" : input[1].value,
			"contrasena" : input[2].value,
			"titulo" : input[3].value};
		$.ajax({
			data: this._datos,
			type:'get',
			url:DataBase,
			dataType: "json",
			success: function (resultado){
				switch(resultado['estadoUsuario']){
					case 'OK':
						alert("El usuario fue creado con éxito");
						break;
					case 'No se pudo hacer crear el usuario':
						alert("No se pudo hacer crear el usuario");
						break;
					case 'El usuario ya existe':
						alert("El usuario ya existe");
						break;
					default:
				}
			}			        
		});					
	}
}