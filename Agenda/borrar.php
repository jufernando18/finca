<?php
    require_once('validarSesion.php');

    if ($dinero == 'ingresos') {
        $tablaQuery = $TABLA_INGRESOS;
    }
    if ($dinero == 'gastos') {
        $tablaQuery = $TABLA_GASTOS;
    }    

    $sql = "DELETE FROM $tablaQuery WHERE id=? AND idUsuario = $idUsuario;";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    if(!$stmt->execute()){
        $resultado_enviar['error']='No se pudo hacer el registro';
    }

    echo json_encode($resultado_enviar);
    $stmt->close();
    mysqli_close($conexion);
?>