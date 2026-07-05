<?php
include(__DIR__ . '/../config/conexion.php');
if (!empty($_POST["btn_registrar"])) {
    $nombre = mysqli_real_escape_string($conexion, $_POST["nombre"]);
    $email  = mysqli_real_escape_string($conexion, $_POST["email"]);
    $genero = $_POST["genero"];
    $pass   = $_POST["password"];
    $pass_c = $_POST["password_confirm"];

    // 1. Validar longitud de contraseña
    if (strlen($pass) < 8) {
        echo "<div class='alert alert-warning'>La contraseña debe tener al menos 8 caracteres.</div>";
    } 
    // 2. Validar que coincidan
    elseif ($pass !== $pass_c) {
        echo "<div class='alert alert-warning'>Las contraseñas no coinciden.</div>";
    } 
    else {
        // 3. Validar si el correo o usuario ya existen
        $check = $conexion->query("SELECT * FROM Usuarios WHERE email_usuario='$email'");
        
        if ($check->num_rows > 0) {
            echo "<div class='alert alert-danger'>El nombre de usuario o el correo ya están registrados.</div>";
        } else {
            // Si todo está bien, encriptamos e insertamos
            $pass_encriptada = password_hash($pass, PASSWORD_BCRYPT);
            $sql = "INSERT INTO Usuarios (nombre_usuario, email_usuario, genero, password_usuario, id_rol) 
            VALUES ('$nombre', '$email', '$genero', '$pass_encriptada', 4)";
            
            if (mysqli_query($conexion, $sql)) {
                echo "<div class='alert alert-success'><b>¡Registro exitoso!</b> <a href='login.php'>Inicia sesión</a></div>";
            }
           
        }
    }
}