var BUSCAR_AUTO =false,ACTUALIZAR_BUSQUEDA_AUTO=true,ACTUALIZAR_INGRESO_GASTO_AUTO=true;
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
window.onload = function(){
	seleccionTipo('Principal');
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

function ingresar(DataBase,dinero,tipo){
	var datos;
	var ingresos = document.getElementsByClassName("ingreso");
	if (dinero == 'gasto') {
		ingresos = document.getElementsByClassName("gasto");
	}
	datos = {"nombre" : ingresos[0].value,"cantidad" : ingresos[1].value,"unidad" : ingresos[2].value,"valor" : ingresos[3].value,"fecha" : ingresos[4].value,"tipo" : tipo, "dinero" : dinero};
    $.ajax({
        data: datos,
        type:'get',
        url:DataBase,
        dataType: "json",
        success: function (resultado){
        	if (BUSCAR_AUTO)buscar('Agenda/buscar.php',tipo);
        }			        
    });				
}
function seleccionTipo(tipo){
	//Ocultar/Mostrar opciones según sección de interes
	document.getElementById('estado').innerHTML=tipo;
	var clases,i;
	if (tipo == 'Principal') {
		document.getElementById("tipo").value='';
		document.getElementById('ingresos').className="ni";		
		document.getElementById('gastos').className="ni";
	}else{
		document.getElementById('ingresos').className="";		
		document.getElementById('gastos').className="";
		clases = document.getElementsByClassName('ingreso')
		for (var i = 0; i < clases.length; i++) {
			clases[i].className='ingreso';
		}
		clases = document.getElementsByClassName('gasto')
		for (var i = 0; i < clases.length; i++) {
			clases[i].className='gasto';
		}					
		switch (tipo){
			case 'Café':
				document.getElementById("tipo").value='cafe';
				clases = document.getElementsByClassName('botonIngreso')
				for (var i = 0; i < clases.length; i++) {
					clases[i].className='botonIngreso ni';
				}
				clases[0].className='botonIngreso';
				clases = document.getElementsByClassName('botonGasto')
				for (var i = 0; i < clases.length; i++) {
					clases[i].className='botonGasto ni';
				}										
				clases[0].className='botonGasto';		
			break;
			case 'Ganado':
				document.getElementById("tipo").value='ganado';
				clases = document.getElementsByClassName('botonIngreso')
				for (var i = 0; i < clases.length; i++) {
					clases[i].className='botonIngreso ni';
				}
				clases[1].className='botonIngreso';
				clases = document.getElementsByClassName('botonGasto')
				for (var i = 0; i < clases.length; i++) {
					clases[i].className='botonGasto ni';
				}		
				clases[1].className='botonGasto';
			break;
			case 'Cerdos':
				document.getElementById("tipo").value='cerdos';
				clases = document.getElementsByClassName('botonIngreso')
				for (var i = 0; i < clases.length; i++) {
					clases[i].className='botonIngreso ni';
				}
				clases[2].className='botonIngreso';
				clases = document.getElementsByClassName('botonGasto')
				for (var i = 0; i < clases.length; i++) {
					clases[i].className='botonGasto ni';
				}			
				clases[2].className='botonGasto';					
			break;
			case 'Revuelto':
				document.getElementById("tipo").value='revuelto';
				clases = document.getElementsByClassName('botonIngreso')
				for (var i = 0; i < clases.length; i++) {
					clases[i].className='botonIngreso ni';
				}
				clases[3].className='botonIngreso';
				clases = document.getElementsByClassName('botonGasto')
				for (var i = 0; i < clases.length; i++) {
					clases[i].className='botonGasto ni';
				}	
				clases[3].className='botonGasto';							
			break;
			case 'Otros':
				document.getElementById("tipo").value='otros';
				clases = document.getElementsByClassName('botonIngreso')
				for (var i = 0; i < clases.length; i++) {
					clases[i].className='botonIngreso ni';
				}
				clases[4].className='botonIngreso';
				clases = document.getElementsByClassName('botonGasto')
				for (var i = 0; i < clases.length; i++) {
					clases[i].className='botonGasto ni';
				}	
				clases[4].className='botonGasto';							
			break;
			default:										
		}
	}
}
function buscar(DataBase){
	var datosBusqueda = document.getElementsByClassName("busqueda");
    $.ajax({
        data: {"dinero" : 'ingresos',
    			"busqueda" : datosBusqueda[7].value,
    			"nombre" : datosBusqueda[0].value,
    			"cantidad" : datosBusqueda[1].value,
    			"unidad" : datosBusqueda[2].value,
    			"valor" : datosBusqueda[3].value,
    			"ano" : datosBusqueda[4].value,
    			"mes" : datosBusqueda[5].value,
    			"dia" : datosBusqueda[6].value},
        type:'get',
        url:DataBase,
        dataType: "json",
        success: function (resultado){
        	v_ingreso.datos = resultado;
            var total=0;
            for (var i = 0; i < resultado.length; i++) {
            	total+=parseInt(resultado[i].valor);
            }
            document.getElementById("ingreso").innerHTML=total;			            
        }
    });
    $.ajax({
        data: {"dinero" : 'gastos',
    			"busqueda" : datosBusqueda[7].value,
    			"nombre" : datosBusqueda[0].value,
    			"cantidad" : datosBusqueda[1].value,
    			"unidad" : datosBusqueda[2].value,
    			"valor" : datosBusqueda[3].value,
    			"ano" : datosBusqueda[4].value,
    			"mes" : datosBusqueda[5].value,
    			"dia" : datosBusqueda[6].value},
        type:'get',
        url:DataBase,
        dataType: "json",
        success: function (resultado){
        	v_gasto.datos = resultado;
            var total=0;
            for (var i = 0; i < resultado.length; i++) {
            	total+=parseInt(resultado[i].valor);
            }
            document.getElementById("gasto").innerHTML=total;			            
        }
    });			    
}	