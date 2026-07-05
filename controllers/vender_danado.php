<?php
session_start();
include(__DIR__ . '/../config/conexion.php');
 
header('Content-Type: application/json');
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'msg' => 'Método no permitido']);
    exit();
}
 
$id_item  = intval($_POST['id_item']);
$cantidad = intval($_POST['cantidad']);
 
if (!$id_item || $cantidad <= 0) {
    echo json_encode(['ok' => false, 'msg' => 'Datos inválidos']);
    exit();
}
 
// Verificar que haya suficiente stock dañado
$res = mysqli_query($conexion, "SELECT stock_danado, nombre_item FROM inmobiliario WHERE id_item = $id_item");
$art = mysqli_fetch_assoc($res);
 
if (!$art || $art['stock_danado'] < $cantidad) {
    echo json_encode(['ok' => false, 'msg' => 'No hay suficiente stock dañado disponible']);
    exit();
}
 
// Reducir stock_danado
$sql = "UPDATE inmobiliario SET stock_danado = stock_danado - $cantidad WHERE id_item = $id_item";
 
if (mysqli_query($conexion, $sql)) {
    echo json_encode(['ok' => true]);
} else {
    echo json_encode(['ok' => false, 'msg' => mysqli_error($conexion)]);
}
