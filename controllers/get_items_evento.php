<?php
session_start();
require_once '../config/conexion.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id']) || !isset($_GET['id_evento'])) {
    echo json_encode([]);
    exit;
}

$id_evento = intval($_GET['id_evento']);

$sql = "SELECT i.id_item, i.nombre_item, i.descripcion, i.stock_total,
               d.cantidad AS cantidad_solicitada
        FROM Detalle_Evento_Inmobiliario d
        JOIN Inmobiliario i ON d.id_item = i.id_item
        WHERE d.id_evento = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $id_evento);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
    $row['suficiente'] = $row['stock_total'] >= $row['cantidad_solicitada'] ? 1 : 0;
    $items[] = $row;
}

echo json_encode($items);