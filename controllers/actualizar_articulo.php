<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include(__DIR__ . '/../config/conexion.php');
ob_clean();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_item      = intval($_POST['id_item']);
    $nombre_item  = mysqli_real_escape_string($conexion, $_POST['nombre_item']);
    $descripcion  = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $stock_total  = intval($_POST['stock_total']);
    $precio_renta = floatval($_POST['precio_renta']);

    // ── Manejo de imagen ──
    $imgSQL = '';
    if (!empty($_FILES['imagen']['name'])) {
        $ext     = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombre  = uniqid('item_') . '.' . $ext;
        $destino = __DIR__ . '/../assets/content/mobiliario/' . $nombre;
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
            $imgSQL = ", imagen='$nombre'";
        }
    }

    $sql = "UPDATE inmobiliario 
            SET nombre_item='$nombre_item', descripcion='$descripcion', 
                stock_total=$stock_total, precio_renta=$precio_renta $imgSQL
            WHERE id_item=$id_item";

    if (mysqli_query($conexion, $sql)) {
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false, 'msg' => mysqli_error($conexion)]);
    }
} else {
    echo json_encode(['ok' => false, 'msg' => 'Método no permitido']);
}