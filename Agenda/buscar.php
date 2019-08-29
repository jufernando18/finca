<?php
    require_once('validarSesion.php');

    $busqueda = "WHERE idUsuario=$idUsuario";

    if($tipo != null && $tipo != ''){
        $busqueda = $busqueda." AND tipo='$tipo'";
    }
    if($id != null && $id != ''){
        $busqueda = $busqueda." AND id=$id";
    }
    if($nombre != null && $nombre != ''){
        $busqueda = $busqueda." AND nombre='$nombre'";
    }
    if($descripcion != null && $descripcion != ''){
        $busqueda = $busqueda." AND descripcion LIKE '%$descripcion%'";
    }
    if($costo != null && $costo != ''){
        $busqueda = $busqueda." AND costo LIKE '$costo%'";
    }
    if($ano != null && $ano != ''){
        $busqueda = $busqueda." AND YEAR(fecha)='$ano'";
    }    
    if($mes != null && $mes != ''){
        $busqueda = $busqueda." AND MONTH(fecha)='$mes'";
    }        
    if($dia != null && $dia != ''){
        $busqueda = $busqueda." AND DAY(fecha)='$dia'";
    }  
    if($desde != null && $desde != ''){
        $busqueda = $busqueda." AND fecha >= '$desde'";
    }  
    if($hasta != null && $hasta != ''){
        $busqueda = $busqueda." AND fecha <='$hasta'";
    }      
            
    $sql = "SELECT * FROM $TABLA_INGRESOS $busqueda order by fecha desc;";
    if ($dinero == 'gastos') {
        $sql = "SELECT * FROM $TABLA_GASTOS $busqueda order by fecha desc;";
    }
    $resultado = mysqli_query($con,$sql);

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
    echo json_encode($resultado_enviar);
    $stmt->close();
    mysqli_close($con);
?>