<?php

require 'vendor/autoload.php'; // Carga la biblioteca de SendGrid

$apiKey = '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'; // Reemplaza con tu propia clave API de SendGrid

// Ruta a la imagen
$imagen_path = 'imajenes/escine.jpg';

// Crea el objeto SendGrid con tu clave API
$sendgrid = new \SendGrid($apiKey);

// Crea el objeto de correo electrónico y establece el contenido HTML
$html_content = "
<!DOCTYPE html>
<html lang='es'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>
<body>
  <img src='https://example.com/imagen.jpg' alt='Imagen de Perfil'>
</body>
</html>
";

// Crea el objeto de correo electrónico y establece el contenido HTML
$email = new \SendGrid\Mail\Mail();
$email->setFrom("1364822@senati.pe", "Remitente");
$email->setSubject("Asunto del Correo");
$email->addTo("dianaquishila@gmail.com", "Destinatario");
$email->addContent("text/html", $html_content);

// Envía el correo electrónico
try {
    $response = $sendgrid->send($email);
    print_r($response->statusCode());
    print_r($response->headers());
    print_r($response->body());
} catch (Exception $e) {
    echo 'Excepción atrapada: ', $e->getMessage(), "\n";
}


