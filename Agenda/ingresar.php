<?php
require_once('db_connect.php');

    $busqueda = "WHERE token=? AND sesion = true";
    $sql = "SELECT nombre, titulo FROM $TABLA_USUARIOS $busqueda order by creado desc;";
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

        echo json_encode($resultado_enviar);
        $stmt->close();
        mysqli_close($con);
        exit();
    }      



    $busqueda = "WHERE usuario=? AND contrasena=?";
    $busqueda_unsecure = "WHERE usuario='$usuario' AND contrasena='$contrasena'";
    $sql = "SELECT nombre, titulo FROM $TABLA_USUARIOS $busqueda order by creado desc;";


    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $usuario, $contrasena);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($nombre, $titulo);  


    while ($row = $stmt->fetch()) {
        $token = sha1 ("".time());
        $sql = "UPDATE $TABLA_USUARIOS SET token = '$token', sesion = true $busqueda_unsecure;";
        mysqli_query($con,$sql);

        $resultado_enviar['valid'] =true;
        $resultado_enviar['titulo']=$titulo;
        $resultado_enviar['nombre']=$nombre;
        $resultado_enviar['token']=$token;
    }   

    echo json_encode($resultado_enviar);
    $stmt->close();
    mysqli_close($con);
?>