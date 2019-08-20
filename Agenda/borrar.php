<?php
    require_once('validarSesion.php');//importamos la conexion

//Verificamos si se está usando GET o  POST para la comunicacion de la informacion
if($_SERVER['REQUEST_METHOD'] == 'GET'){

    //Crear una sentensia SQL
    if ($dinero == 'ingresos') {
        $sql = "DELETE FROM $tablaIngresos WHERE id ='$id';";//Como el id es incremental, se pone ese NULL
    }
    if ($dinero == 'gastos') {
        $sql = "DELETE FROM $tablaGastos WHERE id ='$id';";//Como el id es incremental, se pone ese NULL
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