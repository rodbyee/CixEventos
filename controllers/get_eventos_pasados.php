<?php
session_start();
header('Content-Type: application/json');

// ✅ Corregido: 'rol' no 'id_rol'
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 1) {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

require_once '../config/conexion.php';

$sql = "
    SELECT 
        e.id_evento,
        e.nombre_evento,
        DATE_FORMAT(e.fecha_evento, '%d/%m/%Y') AS fecha_evento,
        e.hora_inicio,
        e.hora_fin,
        e.direccion,
        e.estado,
        u.nombre_usuario AS nombre_cliente
    FROM registrar_evento e
    JOIN Usuarios u ON e.id_usuario = u.id_usuario
    WHERE e.fecha_evento < CURDATE()
    ORDER BY e.fecha_evento DESC
";

// ✅ Estilo procedural correcto
$result = mysqli_query($conexion, $sql);
$eventos = [];

while ($ev = mysqli_fetch_assoc($result)) {
    $id = intval($ev['id_evento']);
    $sqlMob = "
        SELECT 
            d.id_item,
            i.nombre_item,
            d.cantidad,
            d.devuelto,
            DATE_FORMAT(d.fecha_devolucion, '%d/%m/%Y %H:%i') AS fecha_devolucion
        FROM detalle_evento_inmobiliario d
        JOIN inmobiliario i ON d.id_item = i.id_item
        WHERE d.id_evento = $id
    ";
    // ✅ Estilo procedural correcto
    $resMob = mysqli_query($conexion, $sqlMob);
    $mobiliario = [];
    while ($mob = mysqli_fetch_assoc($resMob)) {
        $mobiliario[] = $mob;
    }

    $ev['mobiliario'] = $mobiliario;
    $eventos[] = $ev;
}

echo json_encode($eventos);
mysqli_close($conexion);
?>