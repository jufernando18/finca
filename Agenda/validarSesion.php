<?php
  require_once('db_connect.php');//importamos la conexion
  $resultado_enviarValidate = array();

  $sql = "SELECT * FROM ".DB_TABLE_USUARIOS." WHERE token='$token' AND sesion = true;";
  $resultado = mysqli_query($con,$sql);//ejecutando el query
  $sesion = false;
  
  while ($row = mysqli_fetch_array($resultado)) {
    $sesion = ($row['sesion']=="1")?true:false;
    $usuario = $row['usuario'];
    $tablaIngresos = $usuario."_tablaIngresos";
    $tablaGastos = $usuario."_tablaGastos";
  }

  if (!$sesion){
    $resultado_enviarValidate['valid'] = $sesion;
    echo json_encode($resultado_enviarValidate);//se genera un JSON con el resultado
    mysqli_close($con);//se cierra la conexion
    exit;
  }  
?>