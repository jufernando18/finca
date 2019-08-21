<?php
require_once('db_connect.php');//importamos la conexion


    $busqueda = "WHERE usuario='$usuario' AND contrasena='$contrasena'";        
    $sql = "SELECT * FROM $TABLA_USUARIOS $busqueda;";//generamos el script en sql
    $resultado = mysqli_query($con,$sql);//ejecutando el query
    if (empty(mysqli_fetch_array($resultado))) {
        $sql = "INSERT INTO $TABLA_USUARIOS (nombre, usuario, contrasena, titulo, creado) VALUES ('$nombre','$usuario','$contrasena','$titulo',now())";

        if(mysqli_query($con, $sql)){
            $resultado_enviar['estadoUsuario']='OK';
        } else {
            $resultado_enviar['estadoUsuario']='No se pudo hacer crear el usuario';
        }
    } else{
            $resultado_enviar['estadoUsuario']='El usuario ya existe';
    }

    echo json_encode($resultado_enviar);//se genera un JSON con el resultado

    mysqli_close($con);//se cierra la conexion
?>