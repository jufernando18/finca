<?php
    require_once('validarSesion.php');

    if ($dinero == 'ingresos') {
        $tablaQuery = $TABLA_INGRESOS;
    }
    if ($dinero == 'gastos') {
        $tablaQuery = $TABLA_GASTOS;
    } 
    $sql = "SELECT id, costo FROM $tablaQuery WHERE id=? AND idUsuario=$idUsuario;";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $costo);  
    $stmt->fetch();
    if($stmt->num_rows != 1) {
        $resultado_enviar['id']=$id;
        $resultado_enviar['costo']=$costo;
        echo json_encode($resultado_enviar);
        $stmt->close();
        mysqli_close($con);
        exit();    
    }

    if (!(is_numeric(intval($costo)) && intval($costo) < 0)) {
        echo json_encode($resultado_enviar);
        $stmt->close();
        mysqli_close($con);
        exit();            
    }
    $costo = explode('-', $costo)[1];
    $pago = "P$pago|$costo";
    $sql = "UPDATE $tablaQuery SET costo=?, modificado=now() WHERE id=$id AND idUsuario = $idUsuario;";  
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $pago);
    $stmt->execute();

    echo json_encode($resultado_enviar);
    $stmt->close();
    mysqli_close($con);
?>