<?php
//Verificamos si se está usando GET o  POST para la comunicacion de la informacion
if($_SERVER['REQUEST_METHOD'] == 'GET'){
//Obtener los valores de las variables
    $nombre = $_GET['nombre'];
    $cantidad = $_GET['cantidad'];//en Bundle se debia usar una llave que era nombre(creo)
    $unidad = $_GET['unidad'];
    $valor = $_GET['valor'];
    $fecha = $_GET['fecha'];
    $tipo = $_GET['tipo'];

    //Crear una sentensia SQL
    $sql = "INSERT INTO tabla2019ingresos (nombre, cantidad, unidad, valor, fecha ) VALUES ('$nombre','$cantidad','$unidad','$valor','$fecha')";//Como el id es incremental, se pone ese NULL
    if ($tipo == 'gasto') {
        $sql = "INSERT INTO tabla2019gastos (nombre, cantidad, unidad, valor, fecha ) VALUES ('$nombre','$cantidad','$unidad','$valor','$fecha')";//Como el id es incremental, se pone ese NULL
    }
    

    //Importamos la conexion
    require_once('db_connect.php');

    //Ejecutamos el query
    $resultado_enviar=array();
    if(mysqli_query($con, $sql)){
        /*$resultado_enviar['nombre']=$nombre
        $resultado_enviar['cantidad']=$cantidad;
        $resultado_enviar['unidad']=$unidad;
        $resultado_enviar['valor']=$valor;
        $resultado_enviar['fecha']=$fecha;*/

    } else {
        $resultado_enviar['error']='No se pudo hacer el registro';
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