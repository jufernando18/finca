<?php
require_once('db_connect.php');//importamos la conexion
    $busqueda = '';
    $id = $_GET['id'];
    $dinero = $_GET['dinero'];
    $nombre = $_GET['nombre'];
    $descripcion = $_GET['descripcion'];
    $costo = $_GET['costo'];
    $ano = $_GET['ano'];    
    $mes = $_GET['mes'];
    $dia = $_GET['dia'];
    $tipo = $_GET['tipo'];
    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];
    if($tipo != ''){
        $busqueda = "WHERE tipo='$tipo'";
    }
    if($id != ''){
        if($busqueda != ''){
            $busqueda = $busqueda." AND id='$id'";
        }else{
            $busqueda = "WHERE id='$id'";
        }
    }
    if($nombre != ''){
        if($busqueda != ''){
            $busqueda = $busqueda." AND nombre='$nombre'";
        }else{
            $busqueda = "WHERE nombre='$nombre'";
        }
    }
    if($descripcion != ''){
        if($busqueda != ''){
            $busqueda = $busqueda." AND descripcion LIKE '%$descripcion%'";
        }else{
            $busqueda = "WHERE descripcion LIKE '%$descripcion%'";
        }
    }
    if($costo != ''){
        if($busqueda != ''){
            $busqueda = $busqueda." AND costo LIKE '$costo%'";
        }else{
            $busqueda = "WHERE costo LIKE '%$costo%'";
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
    if($busqueda != ''){
        $busqueda = $busqueda." AND fecha BETWEEN '$desde' AND '$hasta'";
    }else{
        $busqueda = "WHERE fecha BETWEEN '$desde' AND '$hasta'";
    }
            
    $sql = "SELECT * FROM ".DB_TABLE_INGRESOS." $busqueda order by fecha desc;";//generamos el script en sql
    if ($dinero == 'gastos') {
        $sql = "SELECT * FROM ".DB_TABLE_GASTOS." $busqueda order by fecha desc;";//generamos el script en sql
    }
    $resultado = mysqli_query($con,$sql);//ejecutando el query
    
    header('Content-type: application/json; charset=utf-8');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: POST, GET');
    header('Access-Control-Allow-Credentials: *');
    $resultado_enviar=array();
    $posicion=0;
    while ($row = mysqli_fetch_array($resultado)) {
        $resultado_enviar[$posicion]['id']=$row['id'];
        $resultado_enviar[$posicion]['nombre']=$row['nombre'];
        $resultado_enviar[$posicion]['descripcion']=$row['descripcion'];
        $resultado_enviar[$posicion]['costo']=$row['costo'];
        $resultado_enviar[$posicion]['fecha']=$row['fecha'];
        $resultado_enviar[$posicion]['modificado']=$row['modificado'];
        $resultado_enviar[$posicion]['tipo']=$row['tipo'];
        $posicion+=1;
    }
    echo json_encode($resultado_enviar);//se genera un JSON con el resultado

    mysqli_close($con);//se cierra la conexion
?>