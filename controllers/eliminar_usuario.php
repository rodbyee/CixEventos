<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 1) { echo json_encode(['success'=>false]); exit; }
require_once '../config/conexion.php';

$data = json_decode(file_get_contents('php://input'), true);
$id   = intval($data['id_usuario']);

// Evitar que el admin se elimine a sí mismo
if ($id === intval($_SESSION['id'])) {
    echo json_encode(['success'=>false, 'msg'=>'No puedes eliminarte a ti mismo']);
    exit;
}

$ok = mysqli_query($conexion, "DELETE FROM Usuarios WHERE id_usuario=$id");
echo json_encode(['success' => (bool)$ok]);
mysqli_close($conexion);
?>