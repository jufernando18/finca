<?php
    header('Content-type: application/json; charset=utf-8');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: POST, GET');
    header('Access-Control-Allow-Credentials: *');

    require_once('db_connect.php');//importamos la conexion       

    $opcion=0;
    $resultado_enviar=array();

    $sql = "SELECT DISTINCT nombre, descripcion FROM tablaIngresos;";
    $resultado = mysqli_query($con,$sql);//ejecutando el query
    while ($row = mysqli_fetch_array($resultado)) {
        $resultado_enviar['nombreIngreso'][$opcion]=$row['nombre'];
        $resultado_enviar['descripcionIngreso'][$opcion]=$row['descripcion'];
        $opcion++;
    }
    $opcion=0;
    $sql = "SELECT DISTINCT nombre, descripcion FROM tablaGastos;";
    $resultado = mysqli_query($con,$sql);//ejecutando el query
    while ($row = mysqli_fetch_array($resultado)) {
        $resultado_enviar['nombreGasto'][$opcion]=$row['nombre'];
        $resultado_enviar['descripcionGasto'][$opcion]=$row['descripcion'];
        $opcion++;
    }        
    echo json_encode($resultado_enviar);//se genera un JSON con el resultado

    mysqli_close($con);//se cierra la conexion
?>