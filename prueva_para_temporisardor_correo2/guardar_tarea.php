<?php
require 'conexion.php';

$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$tarea_nombre = $_POST['tarea_nombre'];
$script_path = $_POST['script_path'];
$destinatario = $_POST['destinatario'];

$sql = "INSERT INTO tareas_programadas (fecha, hora, tarea_nombre, script_path, destinatario) VALUES ('$fecha', '$hora', '$tarea_nombre', '$script_path', '$destinatario')";
$result = mysqli_query($conexion, $sql);

if ($result) {
    echo "Tarea programada correctamente.";
} else {
    echo "Error al programar la tarea: " . mysqli_error($conexion);
}
?>
