<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 1) { echo json_encode(['success'=>false]); exit; }
require_once '../config/conexion.php';

$data   = json_decode(file_get_contents('php://input'), true);
$id     = intval($data['id_usuario']);
$rol    = intval($data['id_rol']);

if ($id === intval($_SESSION['id']) && $rol !== 1) {
    echo json_encode(['success'=>false, 'msg'=>'No puedes cambiar tu propio rol']);
    exit;
}

$ok = mysqli_query($conexion, "UPDATE Usuarios SET id_rol=$rol WHERE id_usuario=$id");
echo json_encode(['success' => (bool)$ok]);
mysqli_close($conexion);
?>