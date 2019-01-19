<?php
//Verificamos si se está usando GET o  POST para la comunicacion de la informacion
if($_SERVER['REQUEST_METHOD'] == 'GET'){
//Obtener los valores de las variables
    $id = $_GET['id'];
    $nombre = $_GET['nombre'];//en Bundle se debia usar una llave que era nombre(creo)
    $vistas = $_GET['vistas'];
    $descargas = $_GET['descargas'];

    //Crear una sentensia SQL
    $sql = "INSERT INTO books (id, nombre, vistas, descargas ) VALUES ('$id','$nombre','$vistas','$descargas')";//Como el id es incremental, se pone ese NULL

    //Importamos la conexion
    require_once('db_connect.php');

    //Ejecutamos el query
    $resultado_enviar=array();
    if(mysqli_query($con, $sql)){
        $resultado_enviar['id']=$id;
        $resultado_enviar['nombre']=substr($nombre,1,-1);
        $resultado_enviar['vistas']=substr($vistas,1,-1);
        $resultado_enviar['descargas']=substr($descargas,1,-1);

    } else {
        $resultado_enviar['error']='No se pudo agregar el libro';
    }
        
    header('Content-type: application/json; charset=utf-8');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: POST, GET');
    header('Access-Control-Allow-Credentials: *');
    echo json_encode($resultado_enviar);//se genera un JSON con el resultado
    //Cerrar la conexion
    mysqli_close($con);
}
?>