<?php
// Parámetros de conexión a la base de datos
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "tiendaenlínea";

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>