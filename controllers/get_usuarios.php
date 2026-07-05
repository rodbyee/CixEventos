<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 1) { echo json_encode([]); exit; }
require_once '../config/conexion.php';

$result = mysqli_query($conexion, "SELECT id_usuario, nombre_usuario, email_usuario, genero, id_rol FROM Usuarios ORDER BY id_rol, nombre_usuario");
$usuarios = [];
while ($u = mysqli_fetch_assoc($result)) $usuarios[] = $u;
echo json_encode($usuarios);
mysqli_close($conexion);
?>