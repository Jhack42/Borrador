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
        return "Tarea programada correctamente para el $date a las $time en la base de datos.";
    } else {
        return "Error al programar la tarea en la base de datos. Detalles: " . $result;
    }
}


function executePendingTasks($conn) {
    $currentDateTime = date('Y-m-d H:i:s');
    $sql = "SELECT id, fecha, hora FROM tareas_programadas WHERE ejecutada = 0 AND CONCAT(fecha, ' ', hora) <= '$currentDateTime'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $taskId = $row['id'];
            $date = $row['fecha'];
            $time = $row['hora'];

            // Execute the task
            $scriptPath = __DIR__ . '/ejecutar_tarea.php';
            $formattedDateTime = date('H:i', strtotime("$date $time"));
            $command = "php $scriptPath";
            exec($command, $output, $returnVar);

            // Update the database to mark the task as executed
            if ($returnVar === 0) {
                $updateSql = "UPDATE tareas_programadas SET ejecutada = 1 WHERE id = $taskId";
                executeQuery($conn, $updateSql);
            }
        }
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

// Execute pending tasks
$conn = connectToDatabase();
executePendingTasks($conn);
$conn->close();
?>
