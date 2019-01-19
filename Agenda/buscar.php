<?php
    require_once('db_connect.php');//importamos la conexion

    $sql = "SELECT * FROM tabla2019;";//generamos el script en sql

    $resultado = mysqli_query($con,$sql);//ejecutando el query

    $row = mysqli_fetch_array($resultado);
    $resultado_enviar=array();
    $resultado_enviar['nombre']=$row['nombre'];
    $resultado_enviar['cantidad']=$row['cantidad'];
    $resultado_enviar['unidad']=$row['unidad'];
    $resultado_enviar['valor']=$row['valor'];
    $resultado_enviar['fecha']=$row['fecha'];
    
    header('Content-type: application/json; charset=utf-8');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: POST, GET');
    header('Access-Control-Allow-Credentials: *');
    echo json_encode($resultado_enviar);//se genera un JSON con el resultado

    mysqli_close($con);//se cierra la conexion
?>