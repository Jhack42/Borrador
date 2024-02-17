<?php
// guardar_tarea.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    
    // Crear la fecha y hora completa
    $fechaHora = $fecha . ' ' . $hora;

    // Guardar en la base de datos
    $conexion = new mysqli("localhost", "root", "", "programar_tarea_mysql");

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión a la base de datos: " . $conexion->connect_error);
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO tareas_programadas (fecha_ejecucion, descripcion) VALUES ('$fechaHora', 'Tarea programada')";
    
    if ($conexion->query($sql) === TRUE) {
        echo "Tarea programada con éxito.";
    } else {
        echo "Error al programar la tarea: " . $conexion->error;
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
}
?>
