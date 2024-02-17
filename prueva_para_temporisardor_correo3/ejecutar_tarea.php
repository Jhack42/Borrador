<?php


use SendGrid\SendGrid;

function ejecutarTareaEnviarCorreo() {
    $apiKey = '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';
    
    $sendgrid = new \SendGrid($apiKey);

    // Construir el correo electrónico con una plantilla HTML
    $html_content = "<!DOCTYPE html> <!-- Resto del contenido HTML --> </html>";

    // Crea el objeto de correo electrónico y establece el contenido HTML
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("cacereshilasacajhack@gmail.com", "Remitente");
    $email->setSubject("Presentación con Imagen Adjunta");
    $email->addTo("cacereshilasacajhack@gmail.com", "Destinatario");
    $email->addContent("text/html", $html_content);

    // Envía el correo electrónico
    try {
        $response = $sendgrid->send($email);
        echo "Correo electrónico enviado con éxito.";
    } catch (Exception $e) {
        echo "Error al enviar el correo electrónico: " . $e->getMessage();
    }
}
