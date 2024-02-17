<?php

require 'vendor/autoload.php'; // Carga la biblioteca de SendGrid

$apiKey = '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'; // Reemplaza con tu propia clave API de SendGrid

// URL de la imagen
$imagen_url = 'https://i.postimg.cc/rwFbrY0s/imagen1.png';

// Obtiene el contenido de la imagen en base64
$imagen_base64 = base64_encode(file_get_contents($imagen_url));

// Crea el objeto SendGrid con tu clave API
$sendgrid = new \SendGrid($apiKey);

// Construye el correo electrónico con una plantilla HTML
$html_content = "
<!DOCTYPE html>
<html lang='es'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <style>
    /* Estilos Bootstrap en línea */
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f8f9fa;
      margin: 0;
    }

    .card {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin: 20px;
      padding: 20px;
      background-color: #ffffff;
    }

    .presentation-img {
      width: 100%;
      height: auto;
      border-radius: 8px;
    }

    .content {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class='card'>
    <!-- Inserta la imagen en base64 desde la URL -->
    <img src='data:image/png;base64,{$imagen_base64}' alt='Imagen de Presentación' class='presentation-img'>
    <div class='content'>
      <p>Hola,</p>
      <p>Este es un mensaje de presentación con una imagen adjunta.</p>
    </div>
  </div>
</body>
</html>
";

// Crea el objeto de correo electrónico y establece el contenido HTML
$email = new \SendGrid\Mail\Mail();
$email->setFrom("1364822@senati.pe", "Remitente");
$email->setSubject("Presentación con Imagen Adjunta");
$email->addTo("cacereshilasacajhack@gmail.com", "Destinatario");
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
