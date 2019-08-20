<?php
require_once('db_connect.php');//importamos la conexion


    $busqueda = "WHERE usuario='$usuario' AND contrasena='$contrasena'";        
    $sql = "SELECT * FROM ".DB_TABLE_USUARIOS." $busqueda;";//generamos el script en sql
    $resultado = mysqli_query($con,$sql);//ejecutando el query
    if (empty(mysqli_fetch_array($resultado))) {
        $sql = "INSERT INTO ".DB_TABLE_USUARIOS." (nombre, usuario, contrasena, titulo, creado) VALUES ('$nombre','$usuario','$contrasena','$titulo',now())";

        if(mysqli_query($con, $sql)){
            $tablaIngresos = $usuario."_tablaIngresos";
            $tablaGastos = $usuario."_tablaGastos";
            $resultado_enviar['estadoUsuario']='OK';
            $resultado_enviar['tablaIngresos']= $tablaIngresos;
            $sql ="CREATE TABLE `$tablaIngresos` (  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `nombre` varchar(50) DEFAULT NULL,  `descripcion` varchar(150) DEFAULT NULL,  `costo` varchar(30) DEFAULT NULL,  `modificado` datetime DEFAULT NULL,  `fecha` date DEFAULT NULL,  `tipo` varchar(20) DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
            if(mysqli_query($con, $sql)){
                $resultado_enviar['estadoTablaIngresos']='OK';
                $resultado_enviar['tablaGastos']=$tablaGastos;
                $sql = "CREATE TABLE `$tablaGastos` (  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `nombre` varchar(50) DEFAULT NULL,  `descripcion` varchar(150) DEFAULT NULL,  `costo` varchar(30) DEFAULT NULL,  `modificado` datetime DEFAULT NULL,  `fecha` date DEFAULT NULL,  `tipo` varchar(20) DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
                if(mysqli_query($con, $sql)){
                    $resultado_enviar['estadoTablaGastos']='OK';
                } else {
                    $resultado_enviar['estadoTablaGastos']='No se pudo crear la tabla de gastos';
                }              
            } else {
                $resultado_enviar['estadoTablaIngresos']='No se pudo crear la tabla de ingresos';
                $resultado_enviar['estadoTablaGastos']='No se pudo crear la tabla de gastos';
            }        
        } else {
            $resultado_enviar['estadoUsuario']='No se pudo hacer crear el usuario';
            $resultado_enviar['estadoTablaIngresos']='No se pudo crear la tabla de ingresos';
            $resultado_enviar['estadoTablaGastos']='No se pudo crear la tabla de gastos';
        }
    } else{
            $resultado_enviar['estadoUsuario']='El usuario ya existe';
            $resultado_enviar['estadoTablaIngresos']='No se pudo crear la tabla de ingresos';
            $resultado_enviar['estadoTablaGastos']='No se pudo crear la tabla de gastos';        
    }

    echo json_encode($resultado_enviar);//se genera un JSON con el resultado

    mysqli_close($con);//se cierra la conexion
?>