<?php
require_once('db_connect.php');//importamos la conexion

    $busqueda = "WHERE token=? AND sesion = true";
    $sql = "SELECT nombre, titulo FROM $TABLA_USUARIOS $busqueda order by creado desc;";//generamos el script en sql
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($nombre, $titulo);    

    $resultado_enviar['valid']=false;

    while ($row = $stmt->fetch()) {
        $resultado_enviar['valid'] =true;
        $resultado_enviar['titulo']=$titulo;
        $resultado_enviar['nombre']=$nombre;
        $resultado_enviar['token']=$token;

        echo json_encode($resultado_enviar);//se genera un JSON con el resultado
        $stmt->close();
        mysqli_close($con);//se cierra la conexion
        exit();
    }      



    $busqueda = "WHERE usuario=? AND contrasena=?";
    $busqueda_unsecure = "WHERE usuario='$usuario' AND contrasena='$contrasena'";
    $sql = "SELECT nombre, titulo FROM $TABLA_USUARIOS $busqueda order by creado desc;";//generamos el script en sql


    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $usuario, $contrasena);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($nombre, $titulo);  


    while ($row = $stmt->fetch()) {
        $token = sha1 ("".time());
        $sql = "UPDATE $TABLA_USUARIOS SET token = '$token', sesion = true $busqueda_unsecure;"; // ya se sabe que el usuario y contraseña estan bien
        mysqli_query($con,$sql);//ejecutando el query

        $resultado_enviar['valid'] =true;
        $resultado_enviar['titulo']=$titulo;
        $resultado_enviar['nombre']=$nombre;
        $resultado_enviar['token']=$token;

        echo json_encode($resultado_enviar);//se genera un JSON con el resultado
        
        mysqli_close($con);//se cierra la conexion
        exit();
    }   

    echo json_encode($resultado_enviar);//se genera un JSON con el resultado
    $stmt->close();
    mysqli_close($con);//se cierra la conexion
?>