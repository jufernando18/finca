<?php
    require_once('validarSesion.php');

    if ($dinero == 'ingresos') {
    $sql = "DELETE FROM $TABLA_INGRESOS WHERE id =$id AND idUsuario = $idUsuario;";
    }
    if ($dinero == 'gastos') {
    $sql = "DELETE FROM $TABLA_GASTOS WHERE id =$id AND idUsuario = $idUsuario;";
    }

    if(!mysqli_query($con, $sql)){
        $resultado_enviar['error']='No se pudo hacer el registro';
    }

    echo json_encode($resultado_enviar);
    $stmt->close();
    mysqli_close($con);
?>