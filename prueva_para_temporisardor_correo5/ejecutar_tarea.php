<?php

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

    if ($response->statusCode() === 202) {
        echo "<p>Correo electrónico enviado correctamente.</p>";
    } else {
        echo "<p>Error al enviar el correo electrónico.</p>";
    }
} catch (\Exception $e) {
    echo 'Excepción atrapada: ', $e->getMessage(), "\n";
}

?>
