<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/conexion.php';

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!$data) {
    echo json_encode(['ok' => false, 'mensaje' => 'Datos inválidos.']);
    exit;
}

$id_evento      = intval($data['id_evento'] ?? 0);
$nombre_pagador = trim($data['nombre_pagador'] ?? '');
$telefono       = trim($data['telefono'] ?? '');
$metodo_pago    = trim($data['metodo_pago'] ?? '');
$monto_total    = floatval($data['monto_total'] ?? 0);
$items          = $data['items'] ?? [];

if (!$id_evento || !$nombre_pagador || !$telefono || !$metodo_pago || !$monto_total || empty($items)) {
    echo json_encode(['ok' => false, 'mensaje' => 'Faltan datos requeridos.']);
    exit;
}

$referencia = 'CIX-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));

try {
    if (!$conexion) {
        throw new Exception('No hay conexión a la base de datos.');
    }

    $conexion->begin_transaction();

    // 1. Insertar en pagos
    $stmt = $conexion->prepare("
        INSERT INTO pagos (id_evento, nombre_pagador, telefono, metodo_pago, monto_total, estado_pago, referencia)
        VALUES (?, ?, ?, ?, ?, 'completado', ?)
    ");
    $stmt->bind_param('isssds', $id_evento, $nombre_pagador, $telefono, $metodo_pago, $monto_total, $referencia);
    $stmt->execute();
    $id_pago = $conexion->insert_id;
    $stmt->close();

    // 2. Insertar detalle por cada item
    $stmtDet = $conexion->prepare("
        INSERT INTO detalle_evento_inmobiliario (id_evento, id_item, cantidad, estado_pago, fecha_confirmacion)
        VALUES (?, ?, ?, 'confirmado', NOW())
        ON DUPLICATE KEY UPDATE
            cantidad = VALUES(cantidad),
            estado_pago = 'confirmado',
            fecha_confirmacion = NOW()
    ");
    foreach ($items as $it) {
        $id_item  = intval($it['id_item']);
        $cantidad = intval($it['cantidad']);
        $stmtDet->bind_param('iii', $id_evento, $id_item, $cantidad);
        $stmtDet->execute();
    }
    $stmtDet->close();

    // 3. Actualizar estado del evento
    $stmtEv = $conexion->prepare("UPDATE registrar_evento SET estado = 'Confirmado' WHERE id_evento = ?");
    $stmtEv->bind_param('i', $id_evento);
    $stmtEv->execute();
    $stmtEv->close();

    $conexion->commit();

    echo json_encode([
        'ok'         => true,
        'id_pago'    => $id_pago,
        'referencia' => $referencia,
        'mensaje'    => '¡Pago procesado con éxito!'
    ]);

} catch (Exception $e) {
    if ($conexion) $conexion->rollback();
    echo json_encode([
        'ok'      => false,
        'mensaje' => 'Error interno: ' . $e->getMessage()
    ]);
}