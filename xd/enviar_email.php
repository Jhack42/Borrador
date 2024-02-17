<?php

require 'vendor/autoload.php'; // Carga la biblioteca SendGrid

use SendGrid\Mail\Mail;

$apiKey = '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'; // Tu clave API de SendGrid

// Configura el remitente y el destinatario
$fromEmail = "1364822@senati.pe";
$toEmail = "cacereshilasacajhack@gmail.com";

// Crea un objeto de correo electrónico
$mail = new Mail();
$mail->setFrom($fromEmail, "Remitente");
$mail->setSubject("La solución está completa");
$mail->addTo($toEmail, "Destinatario");
$mail->addContent("text/plain", "La solución está completa");

// Crea un objeto de SendGrid y envía el correo electrónico
$sendgrid = new \SendGrid($apiKey);

try {
    $response = $sendgrid->send($mail);
    if ($response->statusCode() == 202) {
        echo "El correo se ha enviado correctamente.";
    } else {
        echo "Hubo un problema al enviar el correo. Código de estado: " . $response->statusCode();
    }
} catch (Exception $e) {
    echo 'Hubo un problema al enviar el correo: ' . $e->getMessage();
}
?>
