<?php
  require_once('db_connect.php');//importamos la conexion

  $sesion = 1;
  $busqueda = "WHERE token=? AND sesion=?";
  $sql = "SELECT id FROM $TABLA_USUARIOS $busqueda;";//generamos el script en sql
  $stmt = $con->prepare($sql);
  $stmt->bind_param("si", $token, $sesion);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($idUsuario);  

  if($stmt->num_rows != 1) {
    $resultado_enviar['valid']=false;
    echo json_encode($resultado_enviar);//se genera un JSON con el resultado
    $stmt->close();
    mysqli_close($con);//se cierra la conexion
    exit();    
  }
  $stmt->fetch()
?>