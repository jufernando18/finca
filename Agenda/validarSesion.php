<?php
  require_once('db_connect.php');//importamos la conexion

  $sql = "SELECT * FROM ".DB_TABLE_USUARIOS." WHERE token='$token' AND sesion = true;";
  $resultado = mysqli_query($con,$sql);//ejecutando el query
  $sesion = false;
  
  $resultado_enviar['valid']=false;
  while ($row = mysqli_fetch_array($resultado)) {
    $sesion = ($row['sesion']=="1")?true:false;
    $resultado_enviar['valid'] = $sesion;
    $usuario = $row['usuario'];
    $tablaIngresos = $usuario."_tablaIngresos";
    $tablaGastos = $usuario."_tablaGastos";
  }
?>