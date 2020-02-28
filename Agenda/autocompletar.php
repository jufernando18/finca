<?php
require_once('validarSesion.php');

$sql = "SELECT DISTINCT nombre FROM $TABLA_INGRESOS WHERE idUsuario = $idUsuario;";
$resultado = mysqli_query($conexion, $sql);
for ($opcion = 0; $row = mysqli_fetch_array($resultado); $opcion++) {
    $resultado_enviar['nombreIngreso'][$opcion]['nombre'] = $row['nombre'];
}
$sql = "SELECT DISTINCT descripcion FROM $TABLA_INGRESOS WHERE idUsuario = $idUsuario;";
$resultado = mysqli_query($conexion, $sql);
for ($opcion = 0; $resultado = mysqli_query($conexion, $sql); $opcion++) {
    $resultado_enviar['descripcionIngreso'][$opcion]['descripcion'] = $row['descripcion'];
}
$sql = "SELECT DISTINCT nombre FROM $TABLA_GASTOS WHERE idUsuario = $idUsuario;";
$resultado = mysqli_query($conexion, $sql);
for ($opcion = 0; $row = mysqli_fetch_array($resultado); $opcion++) {
    $resultado_enviar['nombreGasto'][$opcion]['nombre'] = $row['nombre'];
}
$sql = "SELECT DISTINCT descripcion FROM $TABLA_GASTOS WHERE idUsuario = $idUsuario;";
$resultado = mysqli_query($conexion, $sql);
for ($opcion = 0; $row = mysqli_fetch_array($resultado); $opcion++) {
    $resultado_enviar['descripcionGasto'][$opcion]['descripcion'] = $row['descripcion'];
}

echo json_encode($resultado_enviar);
$stmt->close();
mysqli_close($conexion);
