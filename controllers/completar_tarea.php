<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['id'])) { echo json_encode(['success'=>false]); exit; }
require_once '../config/conexion.php';

$data    = json_decode(file_get_contents('php://input'), true);
$idTarea = intval($data['id_tarea']);
$idUser  = intval($_SESSION['id']);

$sql = "UPDATE tareas SET estado='completada' 
        WHERE id_tarea=$idTarea AND id_destinatario=$idUser";
$ok  = mysqli_query($conexion, $sql);
echo json_encode(['success' => (bool)$ok]);
mysqli_close($conexion);
?>