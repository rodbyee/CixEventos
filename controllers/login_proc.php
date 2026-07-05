<?php
session_start();
include(__DIR__ . '/../config/conexion.php'); 

if (!empty($_POST["btn_ingresar"])) {
    if (empty($_POST["usuario"]) || empty($_POST["password"])) {
        echo "<div class='alert alert-danger'>Por favor, completa todos los campos.</div>";
    } else {
        $usuario = mysqli_real_escape_string($conexion, $_POST["usuario"]);
        $password = $_POST["password"];

        $sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE nombre_usuario='$usuario' OR email_usuario='$usuario'");

        if ($datos = mysqli_fetch_object($sql)) {
            if (password_verify($password, $datos->password_usuario)) {

                $_SESSION["id"]     = $datos->id_usuario;
                $_SESSION["nombre"] = $datos->nombre_usuario;
                $_SESSION["rol"]    = $datos->id_rol;
                $_SESSION["genero"] = $datos->genero;

                if ($_SESSION["rol"] == 1) {
                    header("location: views/ADMIN/admin.php");
                } 
                elseif($_SESSION["rol"]==2){
                    header("location: views/INV/inventario.php");
                }
                elseif($_SESSION["rol"]==3){
                    header("location: views/WORKER/worker.php");
                }
                else {
                    header("location: views/CLIENTE/cliente.php");
                }
                exit();

            } else {
                echo "<div class='alert alert-danger'>La contraseña es incorrecta.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>El usuario no existe.</div>";
        }
    }
}
?>