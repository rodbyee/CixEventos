<?php
session_start();
include(__DIR__ . '/../config/conexion.php');

header('Content-Type: application/json');

// Leer JSON del body
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id_evento']) || !isset($data['articulos'])) {
    echo json_encode(['ok' => false, 'msg' => 'Datos incompletos']);
    exit();
}

$id_evento = intval($data['id_evento']);
$articulos = $data['articulos'];

if (!$id_evento || empty($articulos)) {
    echo json_encode(['ok' => false, 'msg' => 'Faltan datos']);
    exit();
}

// ── 1. Liberar apartados expirados (más de 1 hora) ──────────────
$liberar = "SELECT id_detalle, id_item, cantidad FROM detalle_evento_inmobiliario 
             WHERE fecha_apartado < DATE_SUB(NOW(), INTERVAL 1 HOUR)";
$res_liberar = mysqli_query($conexion, $liberar);

while ($row = mysqli_fetch_assoc($res_liberar)) {
    // Regresar stock
    mysqli_query($conexion, "UPDATE inmobiliario SET stock_total = stock_total + {$row['cantidad']} 
                              WHERE id_item = {$row['id_item']}");
    // Borrar detalle
    mysqli_query($conexion, "DELETE FROM detalle_evento_inmobiliario WHERE id_detalle = {$row['id_detalle']}");
}

// ── 2. Validar stock disponible para cada artículo ───────────────
foreach ($articulos as $art) {
    $id_item  = intval($art['id_item']);
    $cantidad = intval($art['cantidad']);

    $res = mysqli_query($conexion, "SELECT stock_total, nombre_item FROM inmobiliario WHERE id_item = $id_item");
    $item = mysqli_fetch_assoc($res);

    if (!$item || $item['stock_total'] < $cantidad) {
        echo json_encode([
            'ok'  => false,
            'msg' => "Stock insuficiente para: {$item['nombre_item']}. Disponibles: {$item['stock_total']}"
        ]);
        exit();
    }
}

// ── 3. Guardar apartados y reducir stock ─────────────────────────
foreach ($articulos as $art) {
    $id_item  = intval($art['id_item']);
    $cantidad = intval($art['cantidad']);

    // Insertar en detalle
    mysqli_query($conexion, "INSERT INTO detalle_evento_inmobiliario (id_evento, id_item, cantidad)
                              VALUES ($id_evento, $id_item, $cantidad)");

    // Reducir stock
    mysqli_query($conexion, "UPDATE inmobiliario SET stock_total = stock_total - $cantidad 
                              WHERE id_item = $id_item");
}

echo json_encode(['ok' => true]);