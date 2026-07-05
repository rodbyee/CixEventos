<?php
session_start();
include("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpieza de datos
    $nombre    = mysqli_real_escape_string($conexion, $_POST['nombre_evento']);
    $fecha     = $_POST['fecha_evento'];
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
    $inicio    = $_POST['hora_inicio'];
    $fin       = $_POST['hora_fin'];
    $id_user   = $_POST['id_usuario']; 

    // IMPORTANTE: Según tu error, la relación es con 'id_usuario' en la tabla usuarios.
    // Verificamos que el ID no sea nulo
    if(empty($id_user)){
        die("Error critico: No se puede registrar sin un ID de usuario valido en la tabla usuarios.");
    }

    $sql = "INSERT INTO registrar_evento (nombre_evento, fecha_evento, hora_inicio, hora_fin, direccion, id_usuario, estado) 
            VALUES ('$nombre', '$fecha', '$inicio', '$fin', '$direccion', '$id_user', 'Pendiente')";

    if (mysqli_query($conexion, $sql)) {
        echo "<script>
                alert('¡Evento registrado exitosamente!');
                window.location.href='../views/INV/inventario.php';
              </script>";
    } else {
        // Esto te dirá exactamente qué valor está fallando
        echo "Error en la base de datos: " . mysqli_error($conexion);
        echo "<br>ID intentado: " . $id_user;
    }
}
?>