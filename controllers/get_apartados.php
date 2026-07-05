<?php
session_start();
include(__DIR__ . '/../config/conexion.php');
header('Content-Type: application/json');

$sql = "SELECT 
            d.id_detalle, d.id_evento, d.id_item, d.cantidad, d.fecha_apartado,
            e.nombre_evento, e.fecha_evento, e.direccion,
            u.id_usuario, u.nombre_usuario, u.email_usuario,
            i.nombre_item
        FROM detalle_evento_inmobiliario d
        INNER JOIN Registrar_evento e ON d.id_evento = e.id_evento
        INNER JOIN Usuarios u ON e.id_usuario = u.id_usuario
        INNER JOIN inmobiliario i ON d.id_item = i.id_item
        ORDER BY d.id_evento ASC";

$result = mysqli_query($conexion, $sql);

$grupos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id_evento'];
    if (!isset($grupos[$id])) {
        $grupos[$id] = [
            'id_evento'      => $row['id_evento'],
            'nombre_evento'  => $row['nombre_evento'],
            'fecha_evento'   => $row['fecha_evento'],
            'direccion'      => $row['direccion'],
            'id_usuario'     => $row['id_usuario'],
            'nombre_usuario' => $row['nombre_usuario'],
            'email_usuario'  => $row['email_usuario'],
            'fecha_apartado' => $row['fecha_apartado'],
            'articulos'      => []
        ];
    }
    $grupos[$id]['articulos'][] = [
        'id_item'    => $row['id_item'],
        'nombre_item'=> $row['nombre_item'],
        'cantidad'   => $row['cantidad']
    ];
}

echo json_encode(array_values($grupos));