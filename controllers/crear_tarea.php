<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['id'])) { echo json_encode(['success'=>false]); exit; }
require_once '../config/conexion.php';

$data        = json_decode(file_get_contents('php://input'), true);
$idRem       = intval($_SESSION['id']);
$idDest      = intval($data['id_destinatario']);
$titulo      = mysqli_real_escape_string($conexion, $data['titulo']);
$desc        = mysqli_real_escape_string($conexion, $data['descripcion'] ?? '');
$fecha       = mysqli_real_escape_string($conexion, $data['fecha_limite']);
$prioridad   = in_array($data['prioridad'], ['alta','media','baja']) ? $data['prioridad'] : 'media';

$sql = "INSERT INTO tareas (id_remitente, id_destinatario, titulo, descripcion, prioridad, fecha_limite)
        VALUES ($idRem, $idDest, '$titulo', '$desc', '$prioridad', '$fecha')";

$ok = mysqli_query($conexion, $sql);
echo json_encode(['success' => (bool)$ok]);
mysqli_close($conexion);
?>