<?php
    require_once('validarSesion.php');//importamos la conexion

    if (!$sesion){
        echo json_encode($resultado_enviar);//se genera un JSON con el resultado
        mysqli_close($con);//se cierra la conexion
        exit;
    }
    $busqueda = '';

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
        $sql = "SELECT * FROM $tablaIngresos $busqueda order by fecha desc;";//generamos el script en sql
        $resultado = mysqli_query($con,$sql);//ejecutando el query
        while ($row = mysqli_fetch_array($resultado)) {
            if ( is_numeric($row['costo'])) {
                if (intval($row['costo']) > 0) {
                    $costo = "-".$row['costo'];
                }else{
                    $costo = explode('-', $row['costo'])[1];
                }
                $id = $row['id'];
                mysqli_query($con,"UPDATE $tablaIngresos SET costo='$costo', modificado=now() WHERE id='$id';");
            } else{
                $costo = explode('|', $row['costo'])[1];
                $id = $row['id'];
                mysqli_query($con,"UPDATE $tablaIngresos SET costo='-$costo', modificado=now() WHERE id='$id';");  
            }
        }        
    }      
    
    if ($dinero == 'gastos') {
        $sql = "SELECT * FROM $tablaGastos $busqueda order by fecha desc;";//generamos el script en sql
        $resultado = mysqli_query($con,$sql);//ejecutando el query
        while ($row = mysqli_fetch_array($resultado)) {
            if ( is_numeric($row['costo'])) {
                if (intval($row['costo']) > 0) {
                    $costo = "-".$row['costo'];  
                }else{
                    $costo = explode('-', $row['costo'])[1];
                }
                $id = $row['id'];
                mysqli_query($con,"UPDATE $tablaGastos SET costo='$costo', modificado=now() WHERE id='$id';");
            } else{
                $costo = explode('|', $row['costo'])[1];
                $id = $row['id'];
                mysqli_query($con,"UPDATE $tablaGastos SET costo='-$costo', modificado=now() WHERE id='$id';");  
            }
        }
    }

    echo json_encode($resultado_enviar);//se genera un JSON con el resultado

    mysqli_close($con);//se cierra la conexion
?>