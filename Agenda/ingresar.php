<?php
require_once('db_connect.php');//importamos la conexion

    $busqueda = "WHERE token='$token'";
    $sql = "SELECT * FROM ".DB_TABLE_USUARIOS." $busqueda order by creado desc;";//generamos el script en sql

    $resultado = mysqli_query($con,$sql);//ejecutando el query

    $resultado_enviar['valid']=false;

    while ($row = mysqli_fetch_array($resultado)) {
        $resultado_enviar['valid'] =true;
        $resultado_enviar['titulo']=$row['titulo'];
        $resultado_enviar['nombre']=$row['nombre'];
        $resultado_enviar['token']=$token;

        echo json_encode($resultado_enviar);//se genera un JSON con el resultado
        mysqli_close($con);//se cierra la conexion
        exit();
    }      

    $busqueda = "WHERE usuario='$usuario' AND contrasena='$contrasena'";
    $sql = "SELECT * FROM ".DB_TABLE_USUARIOS." $busqueda order by creado desc;";//generamos el script en sql

    $resultado = mysqli_query($con,$sql);//ejecutando el query

    while ($row = mysqli_fetch_array($resultado)) {
        if ($usuario == $row['usuario'] && $contrasena == $row['contrasena']) {
            $token = sha1 ("".time());
            $sql = "UPDATE ".DB_TABLE_USUARIOS." SET token = '$token', sesion = true $busqueda;";
            mysqli_query($con,$sql);//ejecutando el query

            $resultado_enviar['valid'] =true;
            $resultado_enviar['titulo']=$row['titulo'];
            $resultado_enviar['nombre']=$row['nombre'];
            $resultado_enviar['token']=$token;
        }
    }  

    echo json_encode($resultado_enviar);//se genera un JSON con el resultado

    mysqli_close($con);//se cierra la conexion
?>