<?php
session_start();
include(__DIR__ . '/../config/conexion.php');
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id_usuario']) || !isset($data['mensaje'])) {
    echo json_encode(['ok' => false, 'msg' => 'Datos incompletos']);
    exit();
}

$id_usuario = intval($data['id_usuario']);
$mensaje    = mysqli_real_escape_string($conexion, $data['mensaje']);

$sql = "INSERT INTO notificaciones (id_usuario, mensaje) VALUES ($id_usuario, '$mensaje')";

if (mysqli_query($conexion, $sql)) {
    echo json_encode(['ok' => true]);
} else {
    echo json_encode(['ok' => false, 'msg' => mysqli_error($conexion)]);
}