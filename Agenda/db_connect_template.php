<?php
//Aqui vamos a declarar las variables de conexion
header('Content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Credentials: *');  
$resultado_enviar = array();

define('DB_USER',"root");//Usuario
define('DB_PASSWORD',"");//Contraseña
define('DB_DATABASE',"");//Nombre de la base de datos
define('DB_SERVER',"localhost");//Nombre o IP del servidor
define('DB_TABLE_USUARIOS',"tablaUsuarios");
define('DB_TABLE_INGRESOS',"tablaIngresos");
define('DB_TABLE_GASTOS',"tablaGastos");
$TABLA_USUARIOS = DB_TABLE_USUARIOS;
$TABLA_INGRESOS = DB_TABLE_INGRESOS;
$TABLA_GASTOS = DB_TABLE_GASTOS;

$token = $_GET['token'];
$nombre = $_GET['nombre'];
$usuario = $_GET['usuario'];
$contrasena = $_GET['contrasena'];
$titulo = $_GET['titulo'];
$id = $_GET['id'];
$dinero = $_GET['dinero'];
$descripcion = $_GET['descripcion'];
$costo = $_GET['costo'];
$fecha = $_GET['fecha'];
$ano = $_GET['ano'];    
$mes = $_GET['mes'];
$dia = $_GET['dia'];
$tipo = $_GET['tipo'];
$desde = $_GET['desde'];
$hasta = $_GET['hasta'];
$pago = $_GET['pago'];

//Conexxion
$con = mysqli_connect(DB_SERVER, DB_USER,DB_PASSWORD,DB_DATABASE) or die ('Unable to Connect');//Aquí se crea la conexion
?>