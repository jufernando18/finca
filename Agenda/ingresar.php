<?php
require_once('db_connect.php');//importamos la conexion
    $busqueda = "";
    //$busqueda = "WHERE usuario='$usuario' AND contrasena='$contrasena'";
            
    $sql = "SELECT * FROM ".DB_TABLE_USUARIOS." $busqueda order by creado desc;";//generamos el script en sql

    $resultado = mysqli_query($con,$sql);//ejecutando el query
    
    header('Content-type: application/json; charset=utf-8');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: POST, GET');
    header('Access-Control-Allow-Credentials: *');
    $resultado_enviar=array();
    //$resultado_enviar['usuarioEstado']="false";
    //$resultado_enviar['contrasenaEstado']="false";
    $resultado_enviar['valid']="false";
    $opcion=0;
    while ($row = mysqli_fetch_array($resultado)) {
        if ($usuario == $row['usuario']) {
            //$resultado_enviar['usuarioEstado']="true";
            if ($contrasena == $row['contrasena']) {
                $resultado_enviar['valid'] ="true";
                //$resultado_enviar['contrasenaEstado']="true";
                $resultado_enviar['titulo']=$row['titulo'];
                $resultado_enviar['nombre']=$row['nombre'];
            }
        }
        //$resultado_enviar['usuario'][$opcion]=$row['usuario'];
        //$resultado_enviar['contrasena'][$opcion]=$row['contrasena'];
        $opcion++;
    }  
    echo json_encode($resultado_enviar);//se genera un JSON con el resultado

    mysqli_close($con);//se cierra la conexion
?>