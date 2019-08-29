<?php
    require_once('validarSesion.php');

    $tablaQuery = $TABLA_INGRESOS;
    if ($dinero == 'gastos') {
        $tablaQuery = $TABLA_GASTOS;
    }

    if ($id == null) {
        $start = "INSERT INTO $tablaQuery ";
        $assignment = "(nombre, descripcion, costo, fecha, modificado, tipo, idUsuario) VALUES (?,?,?,?, now(),?, $idUsuario)";
        $stmt = $con->prepare($start.$assignment);
        $stmt->bind_param("sssss", $nombre, $descripcion, $costo, $fecha, $tipo);
    } else {
        $start = "UPDATE $tablaQuery SET ";
        $end = " WHERE idUsuario = $idUsuario AND id=?";
        $assignment = "nombre=?, descripcion=?, costo=?, fecha=?, modificado = now(), tipo=?";
        $stmt = $con->prepare($start.$assignment.$end);
        $stmt->bind_param("sssssi", $nombre, $descripcion, $costo, $fecha, $tipo, $id);
    }

    if(!$stmt->execute()){
        $resultado_enviar['error']="No se pudo hacer el registro.";
    }
        
    echo json_encode($resultado_enviar);
    $stmt->close();
    mysqli_close($con);
?>