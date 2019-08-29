<?php
    require_once('validarSesion.php');

    $tablaQuery = $TABLA_INGRESOS;
    if ($dinero == 'gastos') {
        $tablaQuery = $TABLA_GASTOS;
    }

    $start = "UPDATE $tablaQuery SET ";
    $end = " WHERE idUsuario = $idUsuario AND id = $id";
    $assignment = "nombre = '$nombre', descripcion = '$descripcion', costo = '$costo', fecha = '$fecha', modificado = now(), tipo = '$tipo'";
    if ($id == null) {
        $start = "INSERT INTO $tablaQuery ";
        $end = "";
        $assignment = "(nombre, descripcion, costo, fecha, modificado, tipo, idUsuario) VALUES ('$nombre','$descripcion','$costo','$fecha',now(),'$tipo',$idUsuario)";
    }

    $sql = $start.$assignment.$end;

    if(mysqli_query($con, $sql)){
    } else {
        $resultado_enviar['error']="No se pudo hacer el registro.";
    }
        
    echo json_encode($resultado_enviar);
    $stmt->close();
    mysqli_close($con);
?>