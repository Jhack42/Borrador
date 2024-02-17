<?php

define('PHP_EXECUTABLE', 'C:\xampp\php\php.exe');
define('TASK_NAME', 'EnviarCorreoTask');
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'programar_tarea_mysql2');

function scheduleTask($scriptPath, $date, $time) {
    $dateTime = "$date $time";
    if (!$date || !$time || !strtotime($dateTime)) {
        throw new Exception("Error: Datos de fecha y hora no proporcionados o formato incorrecto.");
    }

    $formattedDateTime = date('H:i', strtotime($dateTime));

    exec("schtasks /delete /tn " . escapeshellarg(TASK_NAME) . " /f");

    $cronLine = "schtasks /create /sc once /st $formattedDateTime /tn " . escapeshellarg(TASK_NAME) . " /tr " . escapeshellarg(PHP_EXECUTABLE . " $scriptPath") . " > output.txt 2>&1";

    exec($cronLine, $output, $returnVar);

    // Insertar en la base de datos
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $sql = "INSERT INTO tareas_programadas (fecha, hora) VALUES ('$date', '$time')";
    $conn->query($sql);
    $conn->close();

    return [$returnVar, $output];
}

$scriptPath = __DIR__ . '/ejecutar_tarea.php'; // Archivo que ejecutará el correo
$date = empty($_POST['fecha']) ? null : $_POST['fecha'];
$time = empty($_POST['hora']) ? null : $_POST['hora'];

try {
    list($returnVar, $output) = scheduleTask($scriptPath, $date, $time);

    if ($returnVar === 0) {
        echo "<p>Tarea programada correctamente para el $date a las $time en Windows.</p>";
    } else {
        echo "<p>Error al programar la tarea. Detalles:</p>";
        echo "<pre>" . implode("\n", $output) . "</pre>";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

?>
