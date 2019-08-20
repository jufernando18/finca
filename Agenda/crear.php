<?php
    require_once('validarSesion.php');//importamos la conexion

//Verificamos si se está usando GET o  POST para la comunicacion de la informacion
if($_SERVER['REQUEST_METHOD'] == 'GET'){

    //Crear una sentensia SQL
    $sql = "INSERT INTO $tablaIngresos (nombre, descripcion, costo, fecha, modificado, tipo) VALUES ('$nombre','$descripcion','$costo','$fecha',now(),'$tipo')";//Como el id es incremental, se pone ese NULL
    if ($dinero == 'gasto') {
        $sql = "INSERT INTO $tablaGastos (nombre, descripcion, costo, fecha, modificado, tipo) VALUES ('$nombre','$descripcion','$costo','$fecha',now(),'$tipo')";//Como el id es incremental, se pone ese NULL
    }

    //Ejecutamos el query
    if(mysqli_query($con, $sql)){
        /*$resultado_enviar['nombre']=$nombre
        $resultado_envia
        $resultado_enviar['descripcion']=$descripcion;
        $resultado_enviar['costo']=$costo;
        $resultado_enviar['fecha']=$fecha;*/

    } else {
        $resultado_enviar['error']='No se pudo hacer el registro';
    }
        
    echo json_encode($resultado_enviar);//se genera un JSON con el resultado
    //Cerrar la conexion
    mysqli_close($con);
}
?>