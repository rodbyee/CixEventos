<?php
session_start();
session_destroy(); // Borra todos los datos de la sesión
header("location: ../login.php"); // Nos manda de vuelta al login
exit();
?>