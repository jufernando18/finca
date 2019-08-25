<?php
    require_once('validarSesion.php');//importamos la conexion

//Verificamos si se está usando GET o  POST para la comunicacion de la informacion
if($_SERVER['REQUEST_METHOD'] == 'GET'){

    //Crear una sentensia SQL
    $tablaQuery = $TABLA_INGRESOS;
    if ($dinero == 'gasto') {
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

    //Ejecutamos el query
    if(mysqli_query($con, $sql)){
    } else {
        $resultado_enviar['error']="No se pudo hacer el registro.";
    }
        
    echo json_encode($resultado_enviar);//se genera un JSON con el resultado
    //Cerrar la conexion
    mysqli_close($con);
}
?>