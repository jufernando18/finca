<?php
header('Content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST, POST');
header('Access-Control-Allow-Credentials: *');  
$resultado_enviar = array();

define('DB_USER',getenv('DB_USER'));
define('DB_PASSWORD',getenv('DB_PASS'));
define('DB_DATABASE',getenv('DB_DATABASE'));
define('DB_SERVER',getenv('DB_HOST'));
define('DB_PORT', getenv('DB_PORT'));
define('DB_TABLE_USUARIOS',"tablaUsuarios");
define('DB_TABLE_INGRESOS',"tablaIngresos");
define('DB_TABLE_GASTOS',"tablaGastos");
$TABLA_USUARIOS = DB_TABLE_USUARIOS;
$TABLA_INGRESOS = DB_TABLE_INGRESOS;
$TABLA_GASTOS = DB_TABLE_GASTOS;

$token = $_POST['token'];
$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];
$titulo = $_POST['titulo'];
$id = $_POST['id'];
$dinero = $_POST['dinero'];
$descripcion = $_POST['descripcion'];
$costo = $_POST['costo'];
$fecha = $_POST['fecha'];
$ano = $_POST['ano'];    
$mes = $_POST['mes'];
$dia = $_POST['dia'];
$tipo = $_POST['tipo'];
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$pago = $_POST['pago'];

$con = mysqli_connect(DB_SERVER, DB_USER,DB_PASSWORD,DB_DATABASE,DB_PORT) or die ('Unable to Connect');
?>