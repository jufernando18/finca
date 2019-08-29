<?php
require_once('db_connect.php');


    $busqueda = "WHERE usuario='$usuario' AND contrasena='$contrasena'";        
    $sql = "SELECT * FROM $TABLA_USUARIOS $busqueda;";
    $resultado = mysqli_query($con,$sql);
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

    echo json_encode($resultado_enviar);

    mysqli_close($con);
?>