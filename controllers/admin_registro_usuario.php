<?php
session_start();
include(__DIR__ . '/../config/conexion.php');

if (!isset($_SESSION['id']) || $_SESSION['rol'] != 1) {
    header('Location: /CixEventos/login.php');
    exit;
}

if (!empty($_POST["btn_registrar"])) {
    $nombre  = mysqli_real_escape_string($conexion, $_POST["nombre"]);
    $email   = mysqli_real_escape_string($conexion, $_POST["email"]);
    $genero  = mysqli_real_escape_string($conexion, $_POST["genero"]);
    $pass    = $_POST["password"];
    $pass_c  = $_POST["password_confirm"];
    $id_rol  = intval($_POST["id_rol"]);

    $base = '/CixEventos/views/ADMIN/mod/registrar_usuario.php';

    if (strlen($pass) < 8) {
        header("Location: $base?short=1"); exit;
    }
    if ($pass !== $pass_c) {
        header("Location: $base?pass=1"); exit;
    }

    $check = mysqli_query($conexion, "SELECT id_usuario FROM Usuarios WHERE email_usuario='$email'");
    if (mysqli_num_rows($check) > 0) {
        header("Location: $base?error=1"); exit;
    }

    $pass_hash = password_hash($pass, PASSWORD_BCRYPT);
    $sql = "INSERT INTO Usuarios (nombre_usuario, email_usuario, genero, password_usuario, id_rol)
            VALUES ('$nombre', '$email', '$genero', '$pass_hash', $id_rol)";

    if (mysqli_query($conexion, $sql)) {
        header("Location: $base?ok=1");
    } else {
        header("Location: $base?error=1");
    }
    exit;
}

header('Location: /CixEventos/views/ADMIN/mod/registrar_usuario.php');
exit;