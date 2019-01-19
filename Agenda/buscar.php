<?php
require_once('db_connect.php');//importamos la conexion

    $tipo = $_GET['tipo'];
    $sql = "SELECT * FROM tabla2019ingresos;";//generamos el script en sql
    if ($tipo == 'gastos') {
        $sql = "SELECT * FROM tabla2019gastos;";//generamos el script en sql
    }
    $resultado = mysqli_query($con,$sql);//ejecutando el query
    
    header('Content-type: application/json; charset=utf-8');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: POST, GET');
    header('Access-Control-Allow-Credentials: *');
    $resultado_enviar=array();
    $posicion=0;
    while ($row = mysqli_fetch_array($resultado)) {
        $resultado_enviar[$posicion]['nombre']=$row['nombre'];
        $resultado_enviar[$posicion]['cantidad']=$row['cantidad'];
        $resultado_enviar[$posicion]['unidad']=$row['unidad'];
        $resultado_enviar[$posicion]['valor']=$row['valor'];
        $resultado_enviar[$posicion]['fecha']=$row['fecha'];
        $posicion+=1;
    }
    echo json_encode($resultado_enviar);//se genera un JSON con el resultado

    mysqli_close($con);//se cierra la conexion
?>