<?php
// 1. Iniciar sesión DE PRIMERO
session_start();

// 2. Errores en pantalla para debug (Solo mientras arreglamos)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 3. Conexión
include(__DIR__ . "/../config/conexion.php");

// 4. Forzar que la respuesta sea JSON siempre
header('Content-Type: application/json');

// 5. Verificar si hay usuario
if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "No hay sesión activa", "data" => []]);
    exit;
}

$id_user = $_SESSION['id'];

$sql = "SELECT 
            id_evento, 
            nombre_evento, 
            fecha_evento, 
            hora_inicio AS hora_evento, 
            hora_fin,
            direccion AS lugar_evento, 
            estado 
        FROM registrar_evento 
        WHERE id_usuario = '$id_user' 
        ORDER BY fecha_evento DESC";

$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    echo json_encode(["error" => mysqli_error($conexion)]);
    exit;
}

$eventos = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    // Agregamos mobiliario vacío para que el split() de tu JS no truene
    $fila['mobiliario'] = ""; 
    $eventos[] = $fila;
}

// 7. Enviar el resultado
echo json_encode($eventos);