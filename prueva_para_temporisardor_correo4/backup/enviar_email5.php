<?php

define('PHP_EXECUTABLE', 'C:\xampp\php\php.exe'); // Ruta del ejecutable de PHP
define('TASK_NAME', 'EnviarCorreoTask'); // Nombre de la tarea programada
define('SENDGRID_API_KEY', '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'); // Clave de la API de SendGrid

function scheduleTask($scriptPath, $date, $time) {
    $dateTime = "$date $time";
    if (!$date || !$time || !strtotime($dateTime)) {
        throw new Exception("Error: Datos de fecha y hora no proporcionados o formato incorrecto.");
    }

    $formattedDateTime = date('H:i', strtotime($dateTime));

    exec("schtasks /delete /tn " . escapeshellarg(TASK_NAME) . " /f"); // Eliminar tarea programada existente

    // Crear nueva tarea programada utilizando schtasks
    $cronLine = "schtasks /create /sc once /st $formattedDateTime /tn " . escapeshellarg(TASK_NAME) . " /tr " . escapeshellarg(PHP_EXECUTABLE . " $scriptPath") . " > output.txt 2>&1";

    exec($cronLine, $output, $returnVar);

    return [$returnVar, $output];
}

function sendEmail() {
    require 'vendor/autoload.php'; // Incluir el autoload de SendGrid

    $apiKey = SENDGRID_API_KEY;
    $sendgrid = new \SendGrid($apiKey);

    $htmlContent = "<!DOCTYPE html> <!-- Resto del contenido HTML --> </html>";

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("cacereshilasacajhack@gmail.com", "Remitente");
    $email->setSubject("Presentación con Imagen Adjunta");
    $email->addTo("cacereshilasacajhack@gmail.com", "Destinatario");
    $email->addContent("text/html", $htmlContent);

    try {
        $response = $sendgrid->send($email);
        print_r($response->statusCode());
        print_r($response->headers());
        print_r($response->body());

        if ($response->statusCode() === 202) {
            echo "<p>Correo electrónico enviado correctamente.</p>";
        } else {
            echo "<p>Error al enviar el correo electrónico.</p>";
        }
    } catch (\Exception $e) {
        throw new Exception('Excepción al enviar el correo: ' . $e->getMessage());
    }
}

function main() {
    $scriptPath = __DIR__ . '/enviar_email.php';
    $date = empty($_POST['fecha']) ? null : $_POST['fecha'];
    $time = empty($_POST['hora']) ? null : $_POST['hora'];

    try {
        list($returnVar, $output) = scheduleTask($scriptPath, $date, $time);

        if ($returnVar === 0) {
            echo "<p>Tarea programada correctamente para el $date a las $time en Windows.</p>";
            sendEmail();
        } else {
            echo "<p>Error al programar la tarea. Detalles:</p>";
            echo "<pre>" . implode("\n", $output) . "</pre>";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

main();

?>
