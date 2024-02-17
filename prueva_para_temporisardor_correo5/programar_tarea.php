<?php

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'programar_tarea_mysql2');

function connectToDatabase() {
    return new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}

function executeQuery($conn, $sql) {
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return $conn->error;
    }
}

function scheduleTask($conn, $scriptPath, $date, $time) {
    if (!$date || !$time || !strtotime("$date $time")) {
        return "Error: Datos de fecha y hora no proporcionados o formato incorrecto.";
    }

    $formattedDateTime = date('H:i', strtotime("$date $time"));

    // Check if the task with the same name is already scheduled
    $existingTask = $conn->query("SELECT id FROM tareas_programadas WHERE fecha = '$date' AND hora = '$time'");
    if ($existingTask->num_rows > 0) {
        return "Error: La tarea ya está programada.";
    }

    // Insert into the database
    $sql = "INSERT INTO tareas_programadas (fecha, hora, ejecutada) VALUES ('$date', '$time', 0)";
    $result = executeQuery($conn, $sql);

    if ($result === true) {
        // Execute the task immediately
        $command = "php $scriptPath";
        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            return "Tarea programada y ejecutada correctamente para el $date a las $time en la base de datos.";
        } else {
            return "Error al ejecutar la tarea inmediatamente. Detalles: " . implode("\n", $output);
        }
    } else {
        return "Error al programar la tarea en la base de datos. Detalles: " . $result;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectToDatabase();

    $date = empty($_POST['fecha']) ? null : $_POST['fecha'];
    $time = empty($_POST['hora']) ? null : $_POST['hora'];

    if ($date && $time) {
        $scriptPath = __DIR__ . '/ejecutar_tarea.php';
        $output = scheduleTask($conn, $scriptPath, $date, $time);
        echo "<p>$output</p>";
    } else {
        echo "<p>Error: Datos de fecha y hora no proporcionados o formato incorrecto.</p>";
    }

    $conn->close();
}

// No es necesario ejecutar las tareas pendientes aquí, ya que se ejecutan inmediatamente cuando se programan
?>
