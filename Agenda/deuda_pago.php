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
    $pago = $_GET['pago'];
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
    
    if ($dinero == 'ingresos') {
        $sql = "SELECT * FROM ".DB_TABLE_INGRESOS." $busqueda order by fecha desc;";//generamos el script en sql
        $resultado = mysqli_query($con,$sql);//ejecutando el query
        while ($row = mysqli_fetch_array($resultado)) {
            if ( is_numeric($row['costo'])) {
                if (intval($row['costo']) > 0) {
                    $costo = "-".$row['costo'];
                }else{
                    $costo = explode('-', $row['costo'])[1];
                }
                $id = $row['id'];
                mysqli_query($con,"UPDATE ".DB_TABLE_INGRESOS." SET costo='$costo', modificado=now() WHERE id='$id';");
            } else{
                $costo = explode('|', $row['costo'])[1];
                $id = $row['id'];
                mysqli_query($con,"UPDATE ".DB_TABLE_INGRESOS." SET costo='-$costo', modificado=now() WHERE id='$id';");  
            }
        }        
    }      
    
    if ($dinero == 'gastos') {
        $sql = "SELECT * FROM ".DB_TABLE_GASTOS." $busqueda order by fecha desc;";//generamos el script en sql
        $resultado = mysqli_query($con,$sql);//ejecutando el query
        while ($row = mysqli_fetch_array($resultado)) {
            if ( is_numeric($row['costo'])) {
                if (intval($row['costo']) > 0) {
                    $costo = "-".$row['costo'];  
                }else{
                    $costo = explode('-', $row['costo'])[1];
                }
                $id = $row['id'];
                mysqli_query($con,"UPDATE ".DB_TABLE_GASTOS." SET costo='$costo', modificado=now() WHERE id='$id';");
            } else{
                $costo = explode('|', $row['costo'])[1];
                $id = $row['id'];
                mysqli_query($con,"UPDATE ".DB_TABLE_GASTOS." SET costo='-$costo', modificado=now() WHERE id='$id';");  
            }
        }
    }
    
    
    
    header('Content-type: application/json; charset=utf-8');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: POST, GET');
    header('Access-Control-Allow-Credentials: *');
    $resultado_enviar=array();

    echo json_encode($resultado_enviar);//se genera un JSON con el resultado

    mysqli_close($con);//se cierra la conexion
?>