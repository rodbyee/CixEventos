<?php
include(__DIR__ . "/../config/conexion.php");

$id = $_GET['id'];

$sql = "DELETE FROM registrar_evento WHERE id_evento = '$id'";

if(mysqli_query($conexion, $sql)) {
    echo json_encode(["ok" => true]);
} else {
    echo json_encode(["ok" => false]);
}