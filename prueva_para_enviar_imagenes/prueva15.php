<?php

require 'vendor/autoload.php'; // Carga la biblioteca de SendGrid

$apiKey = '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'; // Reemplaza con tu propia clave API de SendGrid

// Ruta a la imagen
$imagen_path = 'imajenes/escine.jpg';

// Obtiene el contenido de la imagen en base64
$imagen_base64 = base64_encode(file_get_contents($imagen_path));

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
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
      text-align: center;
    }

    .card {
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      margin: 50px auto;
      overflow: hidden;
      padding: 20px;
    }

    .title {
      color: #333;
      font-size: 24px;
      font-weight: bold;
    }

    .content {
      color: #666;
      font-size: 16px;
      margin-top: 10px;
    }

    .footer {
      margin-top: 20px;
      color: #999;
      font-size: 14px;
    }

    .profile-img {
      width: 100%;
      border-radius: 50%;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class='card'>
    <img src='data:image/jpg;base64,INSERT_BASE64_ENCODED_IMAGE_HERE' alt='Imagen de Perfil' class='profile-img'>
    <div class='title'>Nombre Apellido</div>
    <div class='content'>
      <p>Cargo</p>
      <p>Empresa</p>
      <p>Contacto: contacto@empresa.com</p>
    </div>
    <div class='footer'>Este es un mensaje personalizado.</div>
  </div>
</body>
</html>
";

// Crea el objeto de correo electrónico y establece el contenido HTML
$email = new \SendGrid\Mail\Mail();
$email->setFrom("1364822@senati.pe", "Remitente");
$email->setSubject("Asunto del Correo");
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