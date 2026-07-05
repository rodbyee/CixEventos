<?php
require_once '../config/conexion.php';

$sql = "UPDATE Registrar_evento 
        SET estado = 'Finalizado' 
        WHERE fecha_evento < CURDATE() 
        AND estado NOT IN ('Cancelado', 'Finalizado')";
 
$conexion->query($sql);
?>
 