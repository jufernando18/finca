<?php
//Aqui vamos a declarar las variables de conexion
header('Content-type: application/json');
header('Access-Control-Allow-Origin:*');

define('DB_USER',"root");//Usuario
define('DB_PASSWORD',"");//Contraseña
define('DB_DATABASE',"");//Nombre de la base de datos
define('DB_SERVER',"localhost");//Nombre o IP del servidor

//Conexxion
$con = mysqli_connect(DB_SERVER, DB_USER,DB_PASSWORD,DB_DATABASE) or die ('Unable to Connect');//Aquí se crea la conexion
?>