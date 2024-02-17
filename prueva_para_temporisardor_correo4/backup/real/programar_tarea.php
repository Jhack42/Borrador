<?php

define('PHP_EXECUTABLE', 'C:\xampp\php\php.exe');
define('TASK_NAME', 'EnviarCorreoTask');

function scheduleTask($scriptPath, $date, $time) {
    $dateTime = "$date $time";
    if (!$date || !$time || !strtotime($dateTime)) {
        throw new Exception("Error: Datos de fecha y hora no proporcionados o formato incorrecto.");
    }

    $formattedDateTime = date('H:i', strtotime($dateTime));

    exec("schtasks /delete /tn " . escapeshellarg(TASK_NAME) . " /f");

    $cronLine = "schtasks /create /sc once /st $formattedDateTime /tn " . escapeshellarg(TASK_NAME) . " /tr " . escapeshellarg(PHP_EXECUTABLE . " $scriptPath") . " > output.txt 2>&1";

    exec($cronLine, $output, $returnVar);

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
