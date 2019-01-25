<?php
//Verificamos si se está usando GET o  POST para la comunicacion de la informacion
if($_SERVER['REQUEST_METHOD'] == 'GET'){
//Obtener los costoes de las variables
    $id = $_GET['id'];
    $dinero = $_GET['dinero'];

    //Crear una sentensia SQL
    if ($dinero == 'ingresos') {
        $sql = "DELETE FROM tablaIngresos WHERE id ='$id';";//Como el id es incremental, se pone ese NULL
    }
    if ($dinero == 'gastos') {
        $sql = "DELETE FROM tablaGastos WHERE id ='$id';";//Como el id es incremental, se pone ese NULL
    }
    

    //Importamos la conexion
    require_once('db_connect.php');

    //Ejecutamos el query
    $resultado_enviar=array();
    if(mysqli_query($con, $sql)){
        /*$resultado_enviar['nombre']=$nombre
        $resultado_envia
        $resultado_enviar['descripcion']=$descripcion;
        $resultado_enviar['costo']=$costo;
        $resultado_enviar['fecha']=$fecha;*/

    } else {
        $resultado_enviar['error']='No se pudo hacer el registro';
    }
        
    header('Content-type: application/json; charset=utf-8');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: POST, GET');
    header('Access-Control-Allow-Credentials: *');
    echo json_encode($resultado_enviar);//se genera un JSON con el resultado
    //Cerrar la conexion
    mysqli_close($con);
}
?>