<?php
session_start();
include(__DIR__ . "/../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Validar que el usuario esté logueado
    if (!isset($_SESSION['id'])) {
        die("Acceso denegado");
    }

    // 2. Recibir y limpiar datos (Usando los nombres de tu tabla)
    $nombre    = mysqli_real_escape_string($conexion, $_POST["nombre_evento"]);
    $fecha     = $_POST["fecha_evento"];
    $h_inicio  = $_POST["hora_inicio"];
    $h_fin     = $_POST["hora_fin"];
    $direccion = mysqli_real_escape_string($conexion, $_POST["direccion"]);
    $id_user   = $_SESSION['id'];
    $estado    = "Pendiente"; // Valor por defecto

    // 3. Insertar en la base de datos
    $sql = "INSERT INTO registrar_evento (nombre_evento, fecha_evento, hora_inicio, hora_fin, direccion, id_usuario, estado) 
            VALUES ('$nombre', '$fecha', '$h_inicio', '$h_fin', '$direccion', '$id_user', '$estado')";

    if (mysqli_query($conexion, $sql)) {
        // Si todo sale bien, regresamos a la página del cliente
        header("location: ../views/CLIENTE/cliente.php?registro=exito");
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>