<?php
session_start();
include(__DIR__ . '/../config/conexion.php');
header('Content-Type: application/json');
 
$id_evento = intval($_GET['id_evento'] ?? 0);
if (!$id_evento) { echo json_encode([]); exit(); }
 
$sql = "SELECT d.id_detalle, d.id_item, d.cantidad, i.nombre_item
        FROM detalle_evento_inmobiliario d
        INNER JOIN inmobiliario i ON d.id_item = i.id_item
        WHERE d.id_evento = $id_evento";
 
$result = mysqli_query($conexion, $sql);
$arts = [];
while ($row = mysqli_fetch_assoc($result)) {
    $arts[] = $row;
}
 
echo json_encode($arts);
 