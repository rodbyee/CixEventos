<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['id'])) { echo json_encode([]); exit; }
require_once '../config/conexion.php';

$idUsuario = intval($_SESSION['id']);
$tipo      = $_GET['tipo'] ?? 'enviadas';
$idTarea   = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($idTarea) {
    $campo = $tipo === 'enviadas' ? 'id_destinatario' : 'id_remitente';
    $sql = "
        SELECT t.*, 
               u.nombre_usuario AS nombre_contraparte,
               u.id_rol AS rol_contraparte
        FROM tareas t
        JOIN Usuarios u ON t.$campo = u.id_usuario
        WHERE t.id_tarea = $idTarea
        AND (" . ($tipo === 'enviadas' ? "t.id_remitente" : "t.id_destinatario") . " = $idUsuario)
    ";
    $res = mysqli_query($conexion, $sql);
    $t   = mysqli_fetch_assoc($res);
    echo json_encode($t ?: null);
    exit;
}

if ($tipo === 'enviadas') {
    $sql = "
        SELECT t.id_tarea, t.titulo, t.prioridad, t.estado, t.fecha_creacion,
               u.nombre_usuario AS nombre_contraparte, u.id_rol AS rol_contraparte
        FROM tareas t
        JOIN Usuarios u ON t.id_destinatario = u.id_usuario
        WHERE t.id_remitente = $idUsuario
        ORDER BY t.fecha_creacion DESC
    ";
} else {
    $sql = "
        SELECT t.id_tarea, t.titulo, t.prioridad, t.estado, t.fecha_creacion,
               u.nombre_usuario AS nombre_contraparte, u.id_rol AS rol_contraparte
        FROM tareas t
        JOIN Usuarios u ON t.id_remitente = u.id_usuario
        WHERE t.id_destinatario = $idUsuario
        ORDER BY t.fecha_creacion DESC
    ";
}

$res    = mysqli_query($conexion, $sql);
$tareas = [];
while ($t = mysqli_fetch_assoc($res)) $tareas[] = $t;
echo json_encode($tareas);
mysqli_close($conexion);
?>