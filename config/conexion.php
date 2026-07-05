<?php
$conexion = mysqli_connect("localhost", "root", "", "cixeventos");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

?>