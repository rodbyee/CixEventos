<?php
header('Content-Type: application/json');

include(__DIR__ . "/../config/conexion.php");

$data = [];

/* EVENTOS ACTIVOS */
$sql = "SELECT COUNT(*) AS total FROM Registrar_evento WHERE estado = 'Activo'";
$res = $conexion->query($sql);
$data['eventos_activos'] = $res->fetch_assoc()['total'] ?? 0;

/* EVENTOS PENDIENTES */
$sql = "SELECT COUNT(*) AS total FROM Registrar_evento WHERE estado = 'Pendiente'";
$res = $conexion->query($sql);
$data['eventos_pendientes'] = $res->fetch_assoc()['total'] ?? 0;

/* USUARIOS */
$sql = "SELECT COUNT(*) AS total FROM Usuarios";
$res = $conexion->query($sql);
$data['usuarios_total'] = $res->fetch_assoc()['total'] ?? 0;

/* INVENTARIO */
$sql = "SELECT SUM(stock_total) AS total FROM Inmobiliario";
$res = $conexion->query($sql);
$data['articulos_stock'] = $res->fetch_assoc()['total'] ?? 0;

echo json_encode($data);