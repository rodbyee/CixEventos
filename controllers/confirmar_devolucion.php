<?php
session_start();
include(__DIR__ . '/../config/conexion.php');
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id_evento']) || !isset($data['detalles'])) {
    echo json_encode(['ok' => false, 'msg' => 'Datos incompletos']);
    exit();
}

$id_evento = intval($data['id_evento']);
$detalles  = $data['detalles'];

foreach ($detalles as $det) {
    $id_item            = intval($det['id_item']);
    $id_detalle         = intval($det['id_detalle']);
    $cantidad_apartada  = intval($det['cantidad_apartada']);
    $cantidad_entregada = intval($det['cantidad_entregada']);
    $estado             = $det['estado'] === 'danado' ? 'danado' : 'bueno';

    // Cantidad no entregada se regresa al stock normal
    $no_entregada = $cantidad_apartada - $cantidad_entregada;

    if ($estado === 'bueno') {
        // Todo entregado en buen estado → regresa al stock normal
        mysqli_query($conexion,
            "UPDATE inmobiliario SET stock_total = stock_total + $cantidad_entregada
             WHERE id_item = $id_item"
        );
    } else {
        // Dañados van a stock_danado, los no dañados regresan normal
        // Aquí asumimos que la cantidad entregada está dañada
        mysqli_query($conexion,
            "UPDATE inmobiliario 
             SET stock_danado = stock_danado + $cantidad_entregada
             WHERE id_item = $id_item"
        );
    }

    // Los no entregados regresan al stock normal
    if ($no_entregada > 0) {
        mysqli_query($conexion,
            "UPDATE inmobiliario SET stock_total = stock_total + $no_entregada
             WHERE id_item = $id_item"
        );
    }

    // Eliminar detalle del evento
    mysqli_query($conexion,
        "DELETE FROM detalle_evento_inmobiliario WHERE id_detalle = $id_detalle"
    );
}

echo json_encode(['ok' => true]);