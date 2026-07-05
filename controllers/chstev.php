<?php
session_start();
include(__DIR__ . '/../config/conexion.php');
 
header('Content-Type: application/json');
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_evento   = intval($_POST['id_evento']);
    $nuevoEstado = mysqli_real_escape_string($conexion, $_POST['estado']);
 
    $estados_validos = ['Pendiente', 'Confirmado', 'Cancelado'];
    if (!in_array($nuevoEstado, $estados_validos)) {
        echo json_encode(['ok' => false, 'msg' => 'Estado no válido']);
        exit();
    }
 
    $sql = "UPDATE Registrar_evento SET estado = '$nuevoEstado' WHERE id_evento = $id_evento";
 
    if (mysqli_query($conexion, $sql)) {
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false, 'msg' => mysqli_error($conexion)]);
    }
} else {
    echo json_encode(['ok' => false, 'msg' => 'Método no permitido']);
}
 