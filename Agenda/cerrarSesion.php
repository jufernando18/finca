<?php
    require_once('validarSesion.php');//importamos la conexion

    if (!$sesion){
        echo json_encode($resultado_enviar);//se genera un JSON con el resultado
        mysqli_close($con);//se cierra la conexion
        exit;
    }

    $sql = "UPDATE ".DB_TABLE_USUARIOS." SET sesion = false  WHERE token='$token';";
    mysqli_query($con,$sql);//ejecutando el query

    echo json_encode($resultado_enviar);//se genera un JSON con el resultado
    mysqli_close($con);//se cierra la conexion    
?>