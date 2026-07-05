<?php
include(__DIR__ . "/../config/conexion.php");

$id        = $_POST['id_evento'];
$nombre    = $_POST['nombre_evento'];
$fecha     = $_POST['fecha_evento'];
$inicio    = $_POST['hora_inicio'];
$fin       = $_POST['hora_fin'];
$direccion = $_POST['direccion'];

$sql = "UPDATE registrar_evento SET 
        nombre_evento='$nombre', 
        fecha_evento='$fecha', 
        hora_inicio='$inicio', 
        hora_fin='$fin', 
        direccion='$direccion' 
        WHERE id_evento='$id'";

if(mysqli_query($conexion, $sql)) {
    echo json_encode(["ok" => true]);
} else {
    echo json_encode(["ok" => false, "error" => mysqli_error($conexion)]);
}