<?php

$conexion = new mysqli('localhost', 'root', '', 'programar_tarea_mysql');

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

?>
