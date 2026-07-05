<?php
session_start();
header('Content-Type: application/json');
 
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
}
 
require_once '../config/conexion.php';
 
$body = json_decode(file_get_contents('php://input'), true);
 
$id_evento     = intval($body['id_evento'] ?? 0);
$nombre_evento = htmlspecialchars($body['nombre_evento'] ?? '');
$notificar_todo = $body['notificar_todo'] ?? false;
 
if (!$id_evento) {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
    exit;
}
 
// Buscar al encargado de inventario (id_rol = 2)
$stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE id_rol = 2 LIMIT 1");
$stmt->execute();
$encargado = $stmt->get_result()->fetch_assoc();
$stmt->close();
 
if (!$encargado) {
    echo json_encode(['success' => false, 'error' => 'No se encontró encargado de inventario']);
    exit;
}
 
$id_encargado = $encargado['id_usuario'];
 
if ($notificar_todo) {
    // Notificar todos los artículos pendientes del evento
    $stmt = $conn->prepare("
        SELECT i.nombre_item, d.cantidad
        FROM detalle_evento_inmobiliario d
        JOIN inmobiliario i ON d.id_item = i.id_item
        WHERE d.id_evento = ? AND d.devuelto = 0
    ");
    $stmt->bind_param("i", $id_evento);
    $stmt->execute();
    $pendientes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
 
    if (empty($pendientes)) {
        echo json_encode(['success' => false, 'error' => 'No hay pendientes']);
        exit;
    }
 
    $lista = implode(', ', array_map(fn($p) => "{$p['nombre_item']} (x{$p['cantidad']})", $pendientes));
    $mensaje = "⚠️ Devolución pendiente del evento \"$nombre_evento\": $lista. Por favor verifica y confirma la devolución.";
 
    $stmt = $conn->prepare("INSERT INTO notificaciones (id_usuario, mensaje) VALUES (?, ?)");
    $stmt->bind_param("is", $id_encargado, $mensaje);
    $ok = $stmt->execute();
    $stmt->close();
 
} else {
    // Notificar un artículo específico
    $id_item     = intval($body['id_item'] ?? 0);
    $nombre_item = htmlspecialchars($body['nombre_item'] ?? '');
 
    if (!$id_item) {
        echo json_encode(['success' => false, 'error' => 'Artículo no especificado']);
        exit;
    }
 
    $mensaje = "⚠️ Devolución pendiente del evento \"$nombre_evento\": el artículo \"$nombre_item\" aún no ha sido devuelto. Por favor verifica.";
 
    $stmt = $conn->prepare("INSERT INTO notificaciones (id_usuario, mensaje) VALUES (?, ?)");
    $stmt->bind_param("is", $id_encargado, $mensaje);
    $ok = $stmt->execute();
    $stmt->close();
}
 
echo json_encode(['success' => $ok ?? false]);
$conn->close();
?>