<?php
session_start();
require_once '../config/conexion.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(['ok' => false, 'msg' => 'No autorizado']);
    exit;
}

$data       = json_decode(file_get_contents('php://input'), true);
$id_evento  = intval($data['id_evento'] ?? 0);
$id_usuario = intval($_SESSION['id']);

if (!$id_evento) {
    echo json_encode(['ok' => false, 'msg' => 'Evento inválido']);
    exit;
}

$check = $conexion->prepare("SELECT id_evento FROM Registrar_evento WHERE id_evento = ? AND estado = 'Pendiente'");
$check->bind_param('i', $id_evento);
$check->execute();
if ($check->get_result()->num_rows === 0) {
    echo json_encode(['ok' => false, 'msg' => 'El evento no existe o ya fue procesado']);
    exit;
}

$conexion->begin_transaction();

try {
   
    $ins = $conexion->prepare("INSERT INTO Pedido_Preparado (id_evento, id_usuario) VALUES (?, ?)");
    $ins->bind_param('ii', $id_evento, $id_usuario);
    $ins->execute();

    $upd = $conexion->prepare("UPDATE Registrar_evento SET estado = 'Listo para entregar' WHERE id_evento = ?");
    $upd->bind_param('i', $id_evento);
    $upd->execute();

    $conexion->commit();
    echo json_encode(['ok' => true]);

} catch (Exception $e) {
    $conexion->rollback();
    echo json_encode(['ok' => false, 'msg' => 'Error al procesar: ' . $e->getMessage()]);
}