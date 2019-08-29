<?php
    require_once('validarSesion.php');//importamos la conexion

    //Crear una sentensia SQL
    if ($dinero == 'ingresos') {
    $sql = "DELETE FROM $TABLA_INGRESOS WHERE id =$id AND idUsuario = $idUsuario;";//Como el id es incremental, se pone ese NULL
    }
    if ($dinero == 'gastos') {
    $sql = "DELETE FROM $TABLA_GASTOS WHERE id =$id AND idUsuario = $idUsuario;";//Como el id es incremental, se pone ese NULL
    }

    //Ejecutamos el query
    if(!mysqli_query($con, $sql)){
    $resultado_enviar['error']='No se pudo hacer el registro';
    }

    echo json_encode($resultado_enviar);//se genera un JSON con el resultado
    $stmt->close();
    mysqli_close($con);
?>