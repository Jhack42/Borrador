<?php
require 'conexion.php'; // Archivo de conexión a la base de datos

// Obtener la fecha y hora actual
$fecha_actual = date('Y-m-d');
$hora_actual = date('H:i');

// Obtener las tareas programadas para la fecha y hora actual
$sql = "SELECT * FROM tareas_programadas WHERE fecha = '$fecha_actual' AND hora <= '$hora_actual'";
$result = mysqli_query($conexion, $sql);

if ($result) {
    // Recorrer las filas y ejecutar las tareas
    while ($row = mysqli_fetch_assoc($result)) {
        $tarea_nombre = $row['tarea_nombre'];
        $script_path = $row['script_path'];

        // Ejecutar la tarea (aquí podrías usar la lógica que necesites para ejecutar el script)
        exec("php $script_path", $output, $return_var);

        // Registrar la ejecución en un log o hacer cualquier otro manejo que necesites
        if ($return_var === 0) {
            echo "Tarea $tarea_nombre ejecutada correctamente.\n";
        } else {
            echo "Error al ejecutar la tarea $tarea_nombre.\n";
            echo "Detalles del error:\n";
            echo implode("\n", $output);
        }
    }
} else {
    echo "Error al obtener las tareas programadas: " . mysqli_error($conexion);
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
