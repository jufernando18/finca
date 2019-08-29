<?php
    require_once('validarSesion.php');

    $sql = "SELECT DISTINCT nombre FROM $TABLA_INGRESOS WHERE idUsuario = $idUsuario;";
    $resultado = mysqli_query($con,$sql);
    $opcion=0;    
    while ($row = mysqli_fetch_array($resultado)) {
        $resultado_enviar['nombreIngreso'][$opcion]['nombre']=$row['nombre'];
        $opcion++;
    }  
    $opcion=0;
    $sql = "SELECT DISTINCT descripcion FROM $TABLA_INGRESOS WHERE idUsuario = $idUsuario;";
    $resultado = mysqli_query($con,$sql);     
    while ($row = mysqli_fetch_array($resultado)) {
        $resultado_enviar['descripcionIngreso'][$opcion]['descripcion']=$row['descripcion'];
        $opcion++;
    }    
    $opcion=0;
    $sql = "SELECT DISTINCT nombre FROM $TABLA_GASTOS WHERE idUsuario = $idUsuario;";
    $resultado = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($resultado)) {
        $resultado_enviar['nombreGasto'][$opcion]['nombre']=$row['nombre'];
        $opcion++;
    }
    $opcion=0;
    $sql = "SELECT DISTINCT descripcion FROM $TABLA_GASTOS WHERE idUsuario = $idUsuario;";
    $resultado = mysqli_query($con,$sql);    
    while ($row = mysqli_fetch_array($resultado)) {
        $resultado_enviar['descripcionGasto'][$opcion]['descripcion']=$row['descripcion'];
        $opcion++;
    }       
         
    echo json_encode($resultado_enviar);
    $stmt->close();
    mysqli_close($con);
?>