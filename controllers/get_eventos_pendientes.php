<?php
session_start();
require_once '../config/conexion.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT r.id_evento, r.nombre_evento, r.fecha_evento, r.hora_inicio, r.hora_fin, r.direccion, r.notas_adicionales,
               u.nombre_usuario AS cliente
        FROM Registrar_evento r
        JOIN Usuarios u ON r.id_usuario = u.id_usuario
        WHERE r.estado = 'Pendiente'
        ORDER BY r.fecha_evento ASC";

$result = $conexion->query($sql);
$eventos = [];

while ($row = $result->fetch_assoc()) {
    $eventos[] = $row;
}

echo json_encode($eventos);