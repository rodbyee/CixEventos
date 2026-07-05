<?php
session_start();
include(__DIR__ . '/../config/conexion.php');
header('Content-Type: application/json');

$id_usuario = intval($_SESSION['id']);

$action = $_GET['action'] ?? 'get';

if ($action === 'marcar_leidas') {
    mysqli_query($conexion, "UPDATE notificaciones SET leida = 1 WHERE id_usuario = $id_usuario");
    echo json_encode(['ok' => true]);
    exit();
}

$sql = "SELECT id_notificacion, mensaje, leida, fecha 
        FROM notificaciones 
        WHERE id_usuario = $id_usuario 
        ORDER BY fecha DESC 
        LIMIT 20";

$result = mysqli_query($conexion, $sql);
$notifs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $notifs[] = $row;
}

$no_leidas = count(array_filter($notifs, fn($n) => $n['leida'] == 0));

echo json_encode(['notificaciones' => $notifs, 'no_leidas' => $no_leidas]);