<?php

$conexion = new mysqli('localhost', 'root', '', 'programar_tarea_mysql');

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Crear la base de datos si no existe
$createDatabase = "CREATE DATABASE IF NOT EXISTS programar_tarea_mysql";
if ($conexion->query($createDatabase) !== TRUE) {
    die("Error al crear la base de datos: " . $conexion->error);
}

// Seleccionar la base de datos
$conexion->select_db('programar_tarea_mysql');

// Verificar si la tabla tareas_programadas existe, y si no, crearla
$checkTableQuery = "SHOW TABLES LIKE 'tareas_programadas'";
$tableExists = $conexion->query($checkTableQuery);

if ($tableExists->num_rows == 0) {
    $createTableQuery = "
        CREATE TABLE tareas_programadas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            fecha DATE NOT NULL,
            hora TIME NOT NULL,
            tarea_nombre VARCHAR(255) NOT NULL,
            script_path VARCHAR(255) NOT NULL,
            email_remitente VARCHAR(255) NOT NULL,
            asunto VARCHAR(255) NOT NULL,
            email_destinatario VARCHAR(255) NOT NULL
        )
    ";

    if ($conexion->query($createTableQuery) !== TRUE) {
        die("Error al crear la tabla: " . $conexion->error);
    }
}

?>
