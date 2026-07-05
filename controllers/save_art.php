<?php
session_start();
include(__DIR__ . '/../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre_item    = mysqli_real_escape_string($conexion, $_POST['nombre_item']);
    $descripcion    = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $stock_total    = intval($_POST['stock_total']);
    $precio_renta   = floatval($_POST['precio_renta']);
    $id_usuario_inv = intval($_POST['id_usuario_inv']);

    $imagen = null;
    if (!empty($_FILES['imagen']['name'])) {
        $ext       = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombre    = uniqid('item_') . '.' . $ext;
        $destino   = __DIR__ . '/../assets/content/mobiliario/' . $nombre;
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
            $imagen = $nombre;
        }
    }

    $imagenSQL = $imagen ? "'$imagen'" : "NULL";

    $sql = "INSERT INTO inmobiliario (nombre_item, descripcion, stock_total, precio_renta, id_usuario_inv, imagen)
            VALUES ('$nombre_item', '$descripcion', $stock_total, $precio_renta, $id_usuario_inv, $imagenSQL)";

    if (mysqli_query($conexion, $sql)) {
        header("Location: /CixEventos/views/INV/mod/registrar_inv.php?ok=1");
    } else {
        header("Location: /CixEventos/views/INV/mod/registrar_inv.php?error=1");
    }
    exit();

} else {
    header("Location: /CixEventos/views/INV/mod/registrar_inv.php");
    exit();
}