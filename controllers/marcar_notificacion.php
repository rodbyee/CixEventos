<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['success' => false]);
    exit;
}

require_once '../config/conexion.php';

$body = json_decode(file_get_contents('php://input'), true);
$id_usuario = intval($_SESSION['id_usuario']);

if (!empty($body['marcar_todas'])) {
    // Marcar todas las notificaciones del usuario como leídas
    $stmt = $conn->prepare("UPDATE notificaciones SET leida = 1 WHERE id_usuario = ? AND leida = 0");
    $stmt->bind_param("i", $id_usuario);
    $ok = $stmt->execute();
    $stmt->close();
} else {
    // Marcar una notificación específica
    $id_notificacion = intval($body['id_notificacion'] ?? 0);
    if (!$id_notificacion) {
        echo json_encode(['success' => false]);
        exit;
    }
    $stmt = $conn->prepare("UPDATE notificaciones SET leida = 1 WHERE id_notificacion = ? AND id_usuario = ?");
    $stmt->bind_param("ii", $id_notificacion, $id_usuario);
    $ok = $stmt->execute();
    $stmt->close();
}

echo json_encode(['success' => $ok ?? false]);
$conn->close();
?>