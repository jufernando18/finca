<?php
require_once('db_connect.php');

    $sql = "SELECT id FROM $TABLA_USUARIOS WHERE usuario=? AND contrasena=?;";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $usuario, $contrasena);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id);      

    if ($stmt->num_rows != 0) {
        $resultado_enviar['estadoUsuario']='El usuario ya existe';
        echo json_encode($resultado_enviar);
        $stmt->close();
        mysqli_close($con);        
    }

    $sql = "INSERT INTO $TABLA_USUARIOS (nombre, usuario, contrasena, titulo, creado) VALUES (?,?,?,?,now())";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $usuario, $contrasena, $titulo);

    if($stmt->execute()){
        $resultado_enviar['estadoUsuario']='OK';
    } else {
        $resultado_enviar['estadoUsuario']='No se pudo hacer crear el usuario';
    }

    echo json_encode($resultado_enviar);
    $stmt->close();
    mysqli_close($con);
?>