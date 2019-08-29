<?php
    require_once('validarSesion.php');

    $busqueda = "WHERE idUsuario=$idUsuario";

    if($tipo != ''){
        $busqueda = $busqueda." AND tipo='$tipo'";
    }
    if($id != ''){
        $busqueda = $busqueda." AND id=$id";
    }
    if($nombre != ''){
        $busqueda = $busqueda." AND nombre='$nombre'";
    }
    if($descripcion != ''){
        $busqueda = $busqueda." AND descripcion LIKE '%$descripcion%'";
    }
    if($costo != ''){
        $busqueda = $busqueda." AND costo LIKE '$costo%'";
    }
    if($ano != ''){
        $busqueda = $busqueda." AND YEAR(fecha)='$ano'";
    }    
    if($mes != ''){
        $busqueda = $busqueda." AND MONTH(fecha)='$mes'";
    }        
    if($dia != ''){
        $busqueda = $busqueda." AND DAY(fecha)='$dia'";
    }  
    $busqueda = $busqueda." AND fecha BETWEEN '$desde' AND '$hasta'";
    
    if ($dinero == 'ingresos') {
        $sql = "SELECT * FROM $TABLA_INGRESOS $busqueda order by fecha desc;";
        $resultado = mysqli_query($con,$sql);
        while ($row = mysqli_fetch_array($resultado)) {
            if ( is_numeric($row['costo'])) {
                if (intval($row['costo']) > 0) {
                    $costo = "-".$row['costo'];
                }else{
                    $costo = explode('-', $row['costo'])[1];
                }
                $id = $row['id'];
                mysqli_query($con,"UPDATE $TABLA_INGRESOS SET costo='$costo', modificado=now() WHERE id=$id AND  idUsuario = $idUsuario;");
            } else{
                $costo = explode('|', $row['costo'])[1];
                $id = $row['id'];
                mysqli_query($con,"UPDATE $TABLA_INGRESOS SET costo='-$costo', modificado=now() WHERE id=$id AND  idUsuario = $idUsuario;");  
            }
        }        
    }      
    
    if ($dinero == 'gastos') {
        $sql = "SELECT * FROM $TABLA_GASTOS $busqueda order by fecha desc;";
        $resultado = mysqli_query($con,$sql);
        while ($row = mysqli_fetch_array($resultado)) {
            if ( is_numeric($row['costo'])) {
                if (intval($row['costo']) > 0) {
                    $costo = "-".$row['costo'];  
                }else{
                    $costo = explode('-', $row['costo'])[1];
                }
                $id = $row['id'];
                mysqli_query($con,"UPDATE $TABLA_GASTOS SET costo='$costo', modificado=now() WHERE id=$id AND idUsuario = $idUsuario;");
            } else{
                $costo = explode('|', $row['costo'])[1];
                $id = $row['id'];
                mysqli_query($con,"UPDATE $TABLA_GASTOS SET costo='-$costo', modificado=now() WHERE id=$id AND idUsuario = $idUsuario;");  
            }
        }
    }

    echo json_encode($resultado_enviar);
    $stmt->close();
    mysqli_close($con);
?>