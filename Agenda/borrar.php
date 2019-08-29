<?php
    require_once('validarSesion.php');

    if ($dinero == 'ingresos') {
        $tablaQuery = $TABLA_INGRESOS;
    }
    if ($dinero == 'gastos') {
        $tablaQuery = $TABLA_GASTOS;
    }    

    $sql = "DELETE FROM $tablaQuery WHERE id =$id AND idUsuario = $idUsuario;";

    if(!mysqli_query($con, $sql)){
        $resultado_enviar['error']='No se pudo hacer el registro';
    }

    echo json_encode($resultado_enviar);
    $stmt->close();
    mysqli_close($con);
?>