<?php
session_start();
include(__DIR__ . '/../config/conexion.php');
 
header('Content-Type: application/json');
 
$id_item = intval($_GET['id']);
 
if ($id_item > 0) {
    $sql = "DELETE FROM inmobiliario WHERE id_item=$id_item";
    if (mysqli_query($conexion, $sql)) {
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false, 'msg' => mysqli_error($conexion)]);
    }
} else {
    echo json_encode(['ok' => false, 'msg' => 'ID inválido']);
}
 


