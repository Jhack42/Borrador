<?php
require 'vendor/autoload.php';
require 'conexion.php';

$fecha_hora_actual = date('Y-m-d H:i:s');
$sql = "SELECT * FROM tareas_programadas WHERE fecha <= '$fecha_hora_actual'";
$result = mysqli_query($conexion, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $destinatario = $row['destinatario'];
        $tarea_nombre = $row['tarea_nombre'];
        $script_path = $row['script_path'];

        exec("php $script_path", $output, $return_var);

        if ($return_var === 0) {
            echo "Tarea $tarea_nombre ejecutada correctamente y enviada a $destinatario.\n";
        } else {
            echo "Error al ejecutar la tarea $tarea_nombre.\n";
            echo "Detalles del error:\n";
            echo implode("\n", $output);
        }
    }
} else {
    echo "Error al obtener las tareas programadas: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>
