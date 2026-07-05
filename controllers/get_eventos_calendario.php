<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id']) || $_SESSION['rol'] != 1) {
    echo json_encode([]);
    exit;
}

require_once '../config/conexion.php';

$sql = "
    SELECT 
        e.id_evento,
        e.nombre_evento,
        e.fecha_evento,
        e.hora_inicio,
        e.hora_fin,
        e.direccion,
        e.estado,
        u.nombre_usuario AS nombre_cliente
    FROM registrar_evento e
    JOIN Usuarios u ON e.id_usuario = u.id_usuario
    WHERE e.fecha_evento >= CURDATE()
    ORDER BY e.fecha_evento ASC
";

$result = mysqli_query($conexion, $sql);
$eventos = [];

while ($ev = mysqli_fetch_assoc($result)) {
    $id = intval($ev['id_evento']);

    // Mobiliario del evento
    $sqlMob = "
        SELECT i.nombre_item, d.cantidad
        FROM detalle_evento_inmobiliario d
        JOIN inmobiliario i ON d.id_item = i.id_item
        WHERE d.id_evento = $id
    ";
    $resMob = mysqli_query($conexion, $sqlMob);
    $mobiliario = [];
    while ($mob = mysqli_fetch_assoc($resMob)) {
        $mobiliario[] = $mob;
    }

    $eventos[] = [
        'id'             => $ev['id_evento'],
        'title'          => $ev['nombre_evento'],
        'start'          => $ev['fecha_evento'] . 'T' . $ev['hora_inicio'],
        'end'            => $ev['fecha_evento'] . 'T' . $ev['hora_fin'],
        'extendedProps'  => [
            'cliente'    => $ev['nombre_cliente'],
            'direccion'  => $ev['direccion'],
            'estado'     => $ev['estado'],
            'mobiliario' => $mobiliario,
        ]
    ];
}

echo json_encode($eventos);
mysqli_close($conexion);
?>