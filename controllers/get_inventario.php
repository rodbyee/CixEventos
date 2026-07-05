<?php
session_start();
include(__DIR__ . '/../config/conexion.php');

header('Content-Type: application/json');

$sql = "SELECT id_item, nombre_item, descripcion, stock_total, precio_renta, stock_danado, imagen
        FROM inmobiliario ORDER BY nombre_item ASC";

$result = mysqli_query($conexion, $sql);
$articulos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $articulos[] = $row;
}

echo json_encode($articulos);