<?php
    require_once('validarSesion.php');

    $sql = "UPDATE $TABLA_USUARIOS SET sesion = false  WHERE id = $idUsuario;";
    mysqli_query($con,$sql);

    echo json_encode($resultado_enviar);
    $stmt->close();
    mysqli_close($con);
?>