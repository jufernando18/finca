<?php
  require_once('db_connect.php');

  $busqueda = "WHERE token=? AND sesion = true";
  $sql = "SELECT id FROM $TABLA_USUARIOS $busqueda;";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("s", $token);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($idUsuario);  

  if($stmt->num_rows != 1) {
    $resultado_enviar['valid']=false;
    echo json_encode($resultado_enviar);
    $stmt->close();
    mysqli_close($conexion);
    exit();    
  }
  $stmt->fetch();
?>