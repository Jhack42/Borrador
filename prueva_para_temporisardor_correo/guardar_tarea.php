<?php
require 'conexion.php';

// Sanitiza y valida los datos del formulario
$fecha = mysqli_real_escape_string($conexion, $_POST['fecha']);
$hora = mysqli_real_escape_string($conexion, $_POST['hora']);
$tarea_nombre = mysqli_real_escape_string($conexion, $_POST['tarea_nombre']);
$script_path = mysqli_real_escape_string($conexion, $_POST['script_path']);

// Insertar datos en la base de datos
$sql = "INSERT INTO tareas_programadas (fecha, hora, tarea_nombre, script_path) VALUES ('$fecha', '$hora', '$tarea_nombre', '$script_path')";
$result = mysqli_query($conexion, $sql);

if ($result) {
    echo "Tarea programada correctamente.";
} else {
    echo "Error al programar la tarea. Por favor, intenta nuevamente.";
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
