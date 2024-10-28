<?php
// Archivo: Model/prueba_conexion.php
require_once __DIR__ . '/conexion.php';

$conexion = new Conexion();

if ($conexion->conexion) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error al conectar a la base de datos.";
}
?>
