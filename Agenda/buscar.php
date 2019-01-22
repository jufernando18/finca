<?php
require_once('db_connect.php');//importamos la conexion
    $busqueda = '';
    $dinero = $_GET['dinero'];
    $nombre = $_GET['nombre'];
    $cantidad = $_GET['cantidad'];//en Bundle se debia usar una llave que era nombre(creo)
    $unidad = $_GET['unidad'];
    $valor = $_GET['valor'];
    $ano = $_GET['ano'];    
    $mes = $_GET['mes'];
    $dia = $_GET['dia'];
    $tipo = $_GET['tipo'];
    if($tipo != ''){
        $busqueda = "WHERE tipo='$tipo'";
    }
    if($nombre != ''){
        if($busqueda != ''){
            $busqueda = $busqueda." AND nombre='$nombre'";
        }else{
            $busqueda = "WHERE nombre='$nombre'";
        }
    }
    if($cantidad != ''){
        if($busqueda != ''){
            $busqueda = $busqueda." AND cantidad='$cantidad'";
        }else{
            $busqueda = "WHERE cantidad='$cantidad'";
        }
    }
    if($unidad != ''){
        if($busqueda != ''){
            $busqueda = $busqueda." AND unidad='$unidad'";
        }else{
            $busqueda = "WHERE unidad='$unidad'";
        }
    }
    if($valor != ''){
        if($busqueda != ''){
            $busqueda = $busqueda." AND valor='$valor'";
        }else{
            $busqueda = "WHERE valor='$valor'";
        }
    }
    if($ano != ''){
        if($busqueda != ''){
            $busqueda = $busqueda." AND YEAR(fecha)='$ano'";
        }else{
            $busqueda = "WHERE YEAR(fecha)='$ano'";
        }
    }    
    if($mes != ''){
        if($busqueda != ''){
            $busqueda = $busqueda." AND MONTH(fecha)='$mes'";
        }else{
            $busqueda = "WHERE MONTH(fecha)='$mes'";
        }
    }        
    if($dia != ''){
        if($busqueda != ''){
            $busqueda = $busqueda." AND DAY(fecha)='$dia'";
        }else{
            $busqueda = "WHERE DAY(fecha)='$dia'";
        }
    }        
    $sql = "SELECT * FROM tabla2019ingresosT $busqueda order by fecha desc;";//generamos el script en sql
    if ($dinero == 'gastos') {
        $sql = "SELECT * FROM tabla2019gastosT $busqueda order by fecha desc;";//generamos el script en sql
    }
    $resultado = mysqli_query($con,$sql);//ejecutando el query
    
    header('Content-type: application/json; charset=utf-8');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: POST, GET');
    header('Access-Control-Allow-Credentials: *');
    $resultado_enviar=array();
    $posicion=0;
    while ($row = mysqli_fetch_array($resultado)) {
        $resultado_enviar[$posicion]['nombre']=$row['nombre'];
        $resultado_enviar[$posicion]['cantidad']=$row['cantidad'];
        $resultado_enviar[$posicion]['unidad']=$row['unidad'];
        $resultado_enviar[$posicion]['valor']=$row['valor'];
        $resultado_enviar[$posicion]['fecha']=$row['fecha'];
        $resultado_enviar[$posicion]['tipo']=$row['tipo'];
        $posicion+=1;
    }
    echo json_encode($resultado_enviar);//se genera un JSON con el resultado

    mysqli_close($con);//se cierra la conexion
?>