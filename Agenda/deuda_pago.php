<?php
require_once('validarSesion.php');

if ($dinero == 'ingresos') {
    $tablaQuery = $TABLA_INGRESOS;
}
if ($dinero == 'gastos') {
    $tablaQuery = $TABLA_GASTOS;
}
$sql = "SELECT id, costo FROM $tablaQuery WHERE id=? AND idUsuario=$idUsuario;";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $costo);
$stmt->fetch();
if ($stmt->num_rows != 1) {
    echo json_encode($resultado_enviar);
    $stmt->close();
    mysqli_close($conexion);
    exit();
}

$costo = (!is_numeric($costo)) ? ("-" . explode('|', $costo)[1]) : ((intval($costo) < 0) ? explode('-', $costo)[1] : "-$costo");

$sql = "UPDATE $tablaQuery SET costo=?, modificado=now() WHERE id=$id AND  idUsuario = $idUsuario;";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $costo);
$stmt->execute();
echo json_encode($resultado_enviar);
$stmt->close();
mysqli_close($conexion);
