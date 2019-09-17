class Crud{
	constructor(datos){
		this._datos=datos;
	}
	insertar(DataBase, id){
		
		var dineroIG = document.getElementsByClassName("agregarInfo");
		let _this = this;
		if (dineroIG[0].value == "" || dineroIG[2].value == "" || dineroIG[3].value == "" || parseInt(dineroIG[2].value).toString() != dineroIG[2].value){
			$( "#agregarInfoRevisar" ).fadeIn(TIEMPO_NOTIFICACION).delay(TIEMPO_NOTIFICACION).fadeTo(TIEMPO_NOTIFICACION,0, function() {
				this.style.display = 'none';
				this.style.opacity = '1';
			});
			return;
		}
		_this._datos = {
			"token" : token,
			"id" : id,
			"nombre" : dineroIG[0].value,
			"descripcion" : dineroIG[1].value,
			"costo" : dineroIG[2].value,
			"fecha" : dineroIG[3].value,
			"tipo" : dineroIG[4].value, 
			"dinero" : dineroIG[5].value};
		$.ajax({
				data: _this._datos,
				type:'POST',
				url:DataBase,
				dataType: "json",
				success: function (resultado){
					if(!_this.validar(resultado))return;
					if (BUSCAR_AUTO)_this.buscar('Agenda/buscar.php');
					if (LIMPIAR_AUTO) {
						dineroIG[0].value='';
						dineroIG[1].value='';
						dineroIG[2].value='';        		
					}
			$( "#agregarInfoAgregado" ).fadeIn(TIEMPO_NOTIFICACION_OK).delay(TIEMPO_NOTIFICACION_OK).fadeTo(TIEMPO_NOTIFICACION_OK,0, function() {
				this.style.display = 'none';
				this.style.opacity = '1';
			});			
			dineroIG[6].innerHTML = "";
			dineroIG[6].value = null;
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
			"token" : token ,
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
		        type:'POST',
		        url:DataBase,
		        dataType: "json",
		        success: function (resultado){
							if(!_this.validar(resultado))return;
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
						type:'POST',
						url:DataBase,
						dataType: "json",
						success: function (resultado){
							if(!_this.validar(resultado))return;
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
	pagar(DataBase, id, dinero){
		var datosBusqueda = document.getElementsByClassName("busqueda");
		let _this = this;  		        
		/*if (DataBase == "Agenda/pagar.php"){
			idResultado="resultadoPagar";
			if(!confirm("Está seguro que quiere pagar lo seleccionado?"))return;
		} 
		if (DataBase == "Agenda/deuda_pago.php"){
			idResultado="resultadoDeuda";
			if(!confirm("Está seguro que quiere cambiar de estado lo seleccionado?"))return;
		}*/
		_this._datos = {
			"token" : token ,
			"id" :id,    	        	
			"dinero" :dinero,		    			
			"pago" : datosBusqueda[11].value};
		$.ajax({
				data: _this._datos,
				type:'POST',
				url:DataBase,
				dataType: "json",
				success: function (resultado){
					if(!_this.validar(resultado))return;
					datosBusqueda[0].value = '';//se limpia id
					if (BUSCAR_AUTO)_this.buscar('Agenda/buscar.php');
			$( "#"+idResultado ).fadeIn(TIEMPO_NOTIFICACION_OK).delay(TIEMPO_NOTIFICACION_OK).fadeTo(TIEMPO_NOTIFICACION_OK,0, function() {
				this.style.display = 'none';
				this.style.opacity = '1';
			});					        				            
				}
		});
	}
	borrar(DataBase,id, dinero){
		var datosBusqueda = document.getElementsByClassName("busqueda");
		let _this = this;
			_this._datos = {
				"token" : token ,
			"id" : id,//datosBusqueda[0].value,    	        	
			"nombre" : datosBusqueda[1].value,
			"descripcion" : datosBusqueda[2].value,
			"costo" : datosBusqueda[3].value,
			"ano" : datosBusqueda[4].value,
			"mes" : datosBusqueda[5].value,
			"dia" : datosBusqueda[6].value,
			"tipo" : datosBusqueda[7].value,
			"dinero" : dinero,//datosBusqueda[8].value,			    			
			"desde" : datosBusqueda[9].value,
			"hasta" : datosBusqueda[10].value};
		$.ajax({
					data: _this._datos,
					type:'POST',
					url:DataBase,
					dataType: "json",
					success: function (resultado){
						if(!_this.validar(resultado))return;
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
	autocompletar(DataBase){
		let _this = this;
		_this._datos = { 
			"token" : token};
		$.ajax({
			data: _this._datos,
				type:'POST',
				url:DataBase,
				dataType: "json",
				success: function (resultado){   
					if(!_this.validar(resultado))return;
					if (typeof resultado.nombreIngreso === "undefined" && typeof resultado.nombreGasto === "undefined"){
					}else if (typeof resultado.nombreIngreso === "undefined" || typeof resultado.nombreGasto === "undefined"){
						if (typeof resultado.nombreIngreso !== "undefined"){
							v_entrada.datos.nombreIG = resultado.nombreIngreso;
						}
						if (typeof resultado.nombreGasto !== "undefined"){
							v_entrada.datos.nombreIG = resultado.nombreGasto;
						}
					}else{
						v_entrada.datos.nombreIG = resultado.nombreIngreso.concat(resultado.nombreGasto);
					}
					if (typeof resultado.descripcionIngreso === "undefined" && typeof resultado.descripcionGasto === "undefined"){
					}else if (typeof resultado.descripcionIngreso === "undefined" || typeof resultado.descripcionGasto === "undefined"){
						if (typeof resultado.descripcionIngreso !== "undefined"){
							v_entrada.datos.descripcionIG = resultado.descripcionIngreso;
						}
						if (typeof resultado.descripcionGasto !== "undefined"){
							v_entrada.datos.descripcionIG = resultado.descripcionGasto;
						}
					}else{ 
						v_entrada.datos.descripcionIG = resultado.descripcionIngreso.concat(resultado.descripcionGasto);
					}        	          	
				}
		});	
	}			
	copyToClipboard() {
		let nodo = document.createElement("textarea");
		document.body.appendChild(nodo);
		nodo.innerHTML = document.URL+"index.html?"+token;
		nodo.select();
		document.execCommand("copy");
		document.body.removeChild(nodo);
	}
	cerrarSesion(DataBase) {
		let _this = this;
		_this._datos = { 
			"token" : token};
		$.ajax({
			data: _this._datos,
				type:'POST',
				url:DataBase,
				dataType: "json",
				success: function (resultado){   	
					_this.pedirIngreso();
				}
		});					
	}
	validar(resultado) {
		if (resultado.valid == false) {
			this.pedirIngreso();
			return false;
		} 
		return true;
	}
	pedirIngreso() {
		document.getElementById('salir').style.display = 'none';
		document.getElementById('contenido').style.display = 'none';
		document.getElementById('login').style.display = 'block';
	}	
	setDatosEdicion(DataBase, id, dinero) {
		let _this = this;
		this._datos = {
			"token" : token,
			"id" : id,
			"dinero" : dinero};
		$.ajax({
			data: this._datos,
			type:'POST',
			url:DataBase,
			dataType: "json",
			success: function (resultado){
				if(!_this.validar(resultado))return;
				resultado = resultado[0];
				var dineroIG = document.getElementsByClassName("agregarInfo");
				dineroIG[0].value = resultado.nombre;
				dineroIG[1].value = resultado.descripcion;
				dineroIG[2].value = resultado.costo;
				dineroIG[3].valueAsDate = new Date(resultado.fecha);
				dineroIG[4].value = resultado.tipo;
				dineroIG[5].value = dinero;
				dineroIG[6].value = id;
				dineroIG[6].innerHTML = "actualizar";

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
			"token" : token,
			"usuario" : input[0].value,
			"contrasena" : input[1].value};
		$.ajax({
			data: this._datos,
			type:'POST',
			url:DataBase,
			dataType: "json",
			success: function (resultado){
				if (resultado.valid) {
					input[1].value = "";
					if(TITULO)v_entrada.datos.titulo = resultado.titulo;
					v_entrada.datos.nombre = resultado.nombre;
					token = resultado.token;

					document.getElementById('salir').style.display = 'block';
					document.getElementById('contenido').style.display = 'block';
					document.getElementById('login').style.display = 'none';					

					crud.autocompletar('Agenda/autocompletar.php');	
					if (BUSCAR_AUTO) crud.buscar('Agenda/buscar.php');					
				}
			}			        
		});					
	}	
	registrar(DataBase){
		var input = document.getElementsByClassName('registro');
		if (input[1].value.length == 0) {
			alert("Ingrese un usuario");
			return;
		} 
		if(input[1].value.split(' ').length > 1) {
			alert("El nombre de usuario no debe contener espacios");
			return;
		}
		if (input[2].value.length == 0) {
			alert("Ingrese una contraseña");
			return;
		} 
		if(input[2].value.split(' ').length > 1) {
			alert("La contraseña no debe contener espacios");
			return;
		}	
		if(!(input[2].value == input[3].value)) {
			alert("Las contraseñas no coinciden");
			return;
		}				
		this._datos = {
			"nombre" : input[0].value,
			"usuario" : input[1].value,
			"contrasena" : input[2].value,
			"titulo" : input[4].value};
		$.ajax({
			data: this._datos,
			type:'POST',
			url:DataBase,
			dataType: "json",
			success: function (resultado){
				switch(resultado['estadoUsuario']){
					case 'OK':
						alert("El usuario fue creado con éxito. Por favor digite su usuario y contraseña para ingresar");
						input[2].value = "";
						input[3].value = "";
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
	abrirPestana() {
		window.open("index.html?"+token, "_blank");
	}
}