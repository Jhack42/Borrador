<?php
// Establecer la zona horaria del sistema operativo Windows
date_default_timezone_set('America/Lima'); // Ajusta la zona horaria según tu ubicación

// Obtener la hora actual del sistema operativo Windows
$hora_actual = date("H:i:s");

echo "Hora actual del sistema operativo Windows: $hora_actual<br><br>";

require 'vendor/autoload.php'; // Incluir el autoload de SendGrid

$apiKey = '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'; // API key de SendGrid
$sendgrid = new \SendGrid($apiKey);

// Dirección de correo electrónico del remitente
$fromEmail = "1364822@senati.pe";

// Conexión a la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'programar_tarea_mysql4');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener las tareas programadas
$sql = "SELECT id, fecha, hora, correo FROM tareas_programadas";
$result = $conn->query($sql);

// Mostrar resultados en la tabla
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Correo</th>
            <th>Tiempo Restante</th>
        </tr>";

// Verificar tiempo restante y enviar correo si es necesario
while ($row = $result->fetch_assoc()) {
    $currentDateTime = new DateTime();
    $taskDateTime = new DateTime($row['fecha'] . ' ' . $row['hora']);
    $interval = $currentDateTime->diff($taskDateTime);
    $timeLeft = $interval->format('%R%a días %H horas %I minutos');

    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['fecha']}</td>
            <td>{$row['hora']}</td>
            <td>{$row['correo']}</td>
            <td>{$timeLeft}</td>
         </tr>";

    // Si el tiempo restante es menor o igual a 0, enviar el correo
    if ($interval->invert == 1 && $interval->format('%R') === '-') {
        $toEmail = $row['correo'];
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($fromEmail);
        $email->setSubject("Asunto del correo");
        $email->addTo($toEmail);
        $email->addContent("text/html", "Contenido del correo electrónico");

        try {
            $response = $sendgrid->send($email);
            echo "Correo enviado a {$toEmail} con éxito. Código de respuesta: " . $response->statusCode() . "<br>";
        } catch (Exception $e) {
            echo 'Error al enviar el correo a {$toEmail}: ' . $e->getMessage() . "<br>";
        }
    }
}

echo "</table>";

// Cerrar la conexión a la base de datos
$conn->close();
?>
