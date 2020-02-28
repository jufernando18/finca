<?php
require_once('validarSesion.php');

$queryDataArray = array();
$queryTypeArray = array();
$busqueda = "WHERE idUsuario=$idUsuario";

if ($tipo != null && $tipo != '') {
    $busqueda = $busqueda . " AND tipo=?";
    array_push($queryDataArray, $tipo);
    array_push($queryTypeArray, "s");
}
if ($id != null && $id != '') {
    $busqueda = $busqueda . " AND id=?";
    array_push($queryDataArray, $id);
    array_push($queryTypeArray, "i");
}
if ($nombre != null && $nombre != '') {
    $busqueda = $busqueda . " AND nombre=?";
    array_push($queryDataArray, $nombre);
    array_push($queryTypeArray, "s");
}

if ($descripcion != null && $descripcion != '') {
    $busqueda = $busqueda . " AND descripcion LIKE ?";
    array_push($queryDataArray, "%" . $descripcion . "%");
    array_push($queryTypeArray, "s");
}
if ($costo != null && $costo != '') {
    $busqueda = $busqueda . " AND costo LIKE ?";
    array_push($queryDataArray, "%" . $costo . "%");
    array_push($queryTypeArray, "s");
}
if ($ano != null && $ano != '') {
    $busqueda = $busqueda . " AND YEAR(fecha)=?";
    array_push($queryDataArray, $ano);
    array_push($queryTypeArray, "s");
}
if ($mes != null && $mes != '') {
    $busqueda = $busqueda . " AND MONTH(fecha)=?";
    array_push($queryDataArray, $mes);
    array_push($queryTypeArray, "s");
}
if ($dia != null && $dia != '') {
    $busqueda = $busqueda . " AND DAY(fecha)=?";
    array_push($queryDataArray, $dia);
    array_push($queryTypeArray, "s");
}


if ($desde != null && $desde != '') {
    $busqueda = $busqueda . " AND fecha >=?";
    array_push($queryDataArray, $desde);
    array_push($queryTypeArray, "s");
}
if ($hasta != null && $hasta != '') {
    $busqueda = $busqueda . " AND fecha <=?";
    array_push($queryDataArray, $hasta);
    array_push($queryTypeArray, "s");
}

$tablaQuery = $TABLA_INGRESOS;
if ($dinero == 'gastos') {
    $tablaQuery = $TABLA_GASTOS;
}

$bind_param_data = array();
array_push($bind_param_data, implode("", $queryTypeArray));
foreach ($queryDataArray as $queryData) array_push($bind_param_data, $queryData);
$sql = "SELECT id, nombre, descripcion, costo, fecha, modificado, tipo FROM $tablaQuery $busqueda order by fecha desc;";

$stmt = $conexion->prepare($sql);
call_user_func_array(array($stmt, 'bind_param'), $bind_param_data);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $nombre, $descripcion, $costo, $fecha, $modificado, $tipo);

while ($row = $stmt->fetch()) {
    $dato = [
        'id'            => $id,
        'nombre'        => $nombre,
        'descripcion'   => $descripcion,
        'costo'         => $costo,
        'fecha'         => $fecha,
        'modificado'    => $modificado,
        'tipo'          => $tipo
    ];
    array_push($resultado_enviar, $dato);
}
echo json_encode($resultado_enviar);
$stmt->close();
mysqli_close($conexion);
