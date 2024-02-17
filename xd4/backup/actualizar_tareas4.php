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

// Mostrar resultados en la tabla y enviar correos si es necesario
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Correo</th>
            <th>Tiempo Restante</th>
        </tr>";

while ($row = $result->fetch_assoc()) {
    $currentDateTime = new DateTime();
    $taskDateTime = new DateTime($row['fecha'] . ' ' . $row['hora']);
    $interval = $currentDateTime->diff($taskDateTime);
    
    // Formato de tiempo restante con segundos incluidos
    $timeLeft = $interval->format('%R%a días %H horas %I minutos %S segundos');
    // Si prefieres que los segundos aparezcan solo cuando el tiempo restante es menor a un día, puedes usar %R%a días %H horas %I minutos %S segundos.
    
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['fecha']}</td>
            <td>{$row['hora']}</td>
            <td>{$row['correo']}</td>
            <td>{$timeLeft}</td>
         </tr>";

    // Si el tiempo restante es 0 días 00 horas 00 minutos y no se ha enviado un correo electrónico antes
    if ($timeLeft === '-0 días 00 horas 00 minutos 00 segundos') {
        $toEmail = $row['correo'];
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($fromEmail);
        $email->setSubject("Asunto del correo");
        $email->addTo($toEmail);
        $email->addContent("text/html", "Contenido del correo electrónico");

        try {
            $response = $sendgrid->send($email);
            $status = $response->statusCode(); // Obtener el código de estado de la respuesta

            // Guardar el estado del correo electrónico en la base de datos
            // Aquí deberías tener código para actualizar el estado en tu base de datos

            echo "Correo enviado a {$toEmail} con éxito. Código de respuesta: " . $status . "<br>";
        } catch (Exception $e) {
            // Si hay un error al enviar el correo electrónico, muestra el mensaje de error
            echo 'Error al enviar el correo a {$toEmail}: ' . $e->getMessage() . "<br>";

            // También puedes guardar el estado del correo electrónico en la base de datos
        }
    }
}

echo "</table>";

// Cerrar la conexión a la base de datos
$conn->close();
?>
