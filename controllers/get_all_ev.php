<?php
session_start();
include(__DIR__ . '/../config/conexion.php');
 
header('Content-Type: application/json');
 
// JOIN entre Registrar_evento y Usuarios para traer nombre y email del cliente
$sql = "SELECT 
            e.id_evento,
            e.nombre_evento,
            e.fecha_evento,
            e.hora_inicio,
            e.hora_fin,
            e.direccion,
            e.estado,
            u.nombre_usuario,
            u.email_usuario
        FROM Registrar_evento e
        INNER JOIN Usuarios u ON e.id_usuario = u.id_usuario
        ORDER BY e.fecha_evento ASC";
 
$result = mysqli_query($conexion, $sql);
 
$eventos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $eventos[] = $row;
}
 
echo json_encode($eventos);