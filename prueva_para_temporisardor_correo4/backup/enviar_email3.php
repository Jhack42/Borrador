<?php
define('PHP_EXECUTABLE', 'C:\xampp\php\php.exe');
define('TASK_NAME', 'EnviarCorreoTask');

$script_path = 'C:\xampp\htdocs\Borrador\prueva_para_temporisardor_correo4\enviar_email.php';

$fecha = empty($_POST['fecha']) ? null : $_POST['fecha'];
$hora = empty($_POST['hora']) ? null : $_POST['hora'];

if (!$fecha || !$hora || !strtotime("$fecha $hora")) {
    echo "Error: Datos de fecha y hora no proporcionados o formato incorrecto.";
    exit;
}

$fecha_hora_unix = strtotime("$fecha $hora");
$fecha_hora_formateada = date('H:i', $fecha_hora_unix);

exec("schtasks /delete /tn " . escapeshellarg(TASK_NAME) . " /f");

$cron_line = "schtasks /create /sc once /st $fecha_hora_formateada /tn " . escapeshellarg(TASK_NAME) . " /tr " . escapeshellarg(PHP_EXECUTABLE . " $script_path") . " > output.txt 2>&1";

exec($cron_line, $output, $return_var);

if ($return_var === 0) {
    echo "<p>Tarea programada correctamente para el $fecha a las $hora en Windows.</p>";

    $apiKey = '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';
    $sendgrid = new \SendGrid($apiKey);

    $html_content = "<!DOCTYPE html> <!-- Resto del contenido HTML --> </html>";

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("cacereshilasacajhack@gmail.com", "Remitente");
    $email->setSubject("Presentación con Imagen Adjunta");
    $email->addTo("cacereshilasacajhack@gmail.com", "Destinatario");
    $email->addContent("text/html", $html_content);

    try {
        $response = $sendgrid->send($email);
        print_r($response->statusCode());
        print_r($response->headers());
        print_r($response->body());
    } catch (Exception $e) {
        echo 'Excepción atrapada: ', $e->getMessage(), "\n";
    }
} else {
    echo "<p>Error al programar la tarea. Detalles:</p>";
    echo "<pre>" . implode("\n", $output) . "</pre>";
}
?>
