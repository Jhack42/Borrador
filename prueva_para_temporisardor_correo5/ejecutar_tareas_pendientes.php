<?php

define('PHP_EXECUTABLE', 'C:\xampp\php\php.exe');
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'programar_tarea_mysql2');


// Conectar a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Obtener tareas pendientes
$currentDateTime = date('Y-m-d H:i:s');
$sql = "SELECT id, fecha, hora FROM tareas_programadas WHERE ejecutada = 0 AND CONCAT(fecha, ' ', hora) <= '$currentDateTime'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $taskId = $row['id'];
        $date = $row['fecha'];
        $time = $row['hora'];

        // Ejecutar la tarea
        $scriptPath = __DIR__ . '/ejecutar_tarea.php';
        $formattedDateTime = date('H:i', strtotime("$date $time"));
        $command = PHP_EXECUTABLE . " $scriptPath";
        exec($command, $output, $returnVar);

        // Actualizar la base de datos para marcar la tarea como ejecutada
        if ($returnVar === 0) {
            $updateSql = "UPDATE tareas_programadas SET ejecutada = 1 WHERE id = $taskId";
            $conn->query($updateSql);
        }
    }
}

// Cerrar la conexión
$conn->close();
