<?php
define('PHP_EXECUTABLE', 'C:\xampp\php\php.exe');
define('TASK_NAME', 'EnviarCorreoTask');
define('SENDGRID_API_KEY', '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');

function scheduleTask($scriptPath, $date, $time) {
    $dateTime = "$date $time";
    if (!$date || !$time || !strtotime($dateTime)) {
        echo "Error: Datos de fecha y hora no proporcionados o formato incorrecto.";
        exit;
    }

    $formattedDateTime = date('H:i', strtotime($dateTime));

    exec("schtasks /delete /tn " . escapeshellarg(TASK_NAME) . " /f");

    $cronLine = "schtasks /create /sc once /st $formattedDateTime /tn " . escapeshellarg(TASK_NAME) . " /tr " . escapeshellarg(PHP_EXECUTABLE . " $scriptPath") . " > output.txt 2>&1";

    exec($cronLine, $output, $returnVar);

    return [$returnVar, $output];
}

function sendEmail() {
    require 'vendor/autoload.php'; // Asegúrate de incluir el autoload de SendGrid

    $apiKey = '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';
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
    } catch (\Exception $e) {
        echo 'Excepción atrapada: ', $e->getMessage(), "\n";
    }
}


$scriptPath = 'C:\xampp\htdocs\Borrador\prueva_para_temporisardor_correo4\enviar_email.php';
$date = empty($_POST['fecha']) ? null : $_POST['fecha'];
$time = empty($_POST['hora']) ? null : $_POST['hora'];

list($returnVar, $output) = scheduleTask($scriptPath, $date, $time);

if ($returnVar === 0) {
    echo "<p>Tarea programada correctamente para el $date a las $time en Windows.</p>";
    try {
        sendEmail();
    } catch (Exception $e) {
        echo 'Excepción atrapada: ', $e->getMessage(), "\n";
    }
} else {
    echo "<p>Error al programar la tarea. Detalles:</p>";
    echo "<pre>" . implode("\n", $output) . "</pre>";
}
?>
