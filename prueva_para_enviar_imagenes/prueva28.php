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
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Mi Currículum</title>
    <style>
        :root {
            --primary-color: #ff6b6b; /* Rojo */
            --secondary-color: #5f27cd; /* Morado */
            --border-color: #e0e0e0; /* Gris claro para bordes */
            --background-color: #f9f9f9; /* Gris claro */
        }

        body {
            background-color: var(--background-color);
            text-align: center;
            margin: 0;
            font-family: 'Arial', sans-serif;
            transition: background-color 0.5s ease-in-out;
        }

        .custom-section {
            background-color: #ffffff; /* Blanco */
            border: 2px solid #64fdf0; /* Cambia el color del borde a rojo */
            border-radius: 10px;
            padding: 20px;
            margin: 20px auto; /* Centra el contenido en el medio */
            max-width: 600px; /* Limita el ancho máximo del contenido */
            transition: transform 0.3s ease-in-out;
        }


        .card {
            border: 2px solid var(--primary-color); /* Borde más grueso y color rojo */
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff; /* Blanco */
            transition: transform 0.3s ease-in-out;
        }

        .card:hover,
        .custom-section:hover {
            transform: scale(1.05);
        }

        .card-title {
            color: var(--primary-color); /* Rojo */
            font-size: 28px; /* Tamaño de fuente más grande */
            font-weight: bold;
            margin-bottom: 15px;
        }

        .card-body {
            color: #333333; /* Gris oscuro */
            font-size: 18px; /* Tamaño de fuente más grande */
        }

        .text-info {
            color: var(--secondary-color); /* Morado para la información */
        }

        .text-success {
            color: #27ae60; /* Verde para el éxito */
        }

        .text-warning {
            color: #f39c12; /* Amarillo para la advertencia */
        }

        /* Agregamos un estilo sencillo para los enlaces */
        a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease-in-out;
        }

        a:hover {
            color: var(--secondary-color);
        }
    </style>
</head>
<body>

    <div class='custom-section'>
        <h2 class='card-title'>Mi Currículum</h2>

        <!-- Datos Personales -->
        <section class='custom-section'>
            <h3 class='text-info'>Datos Personales</h3>
            <p>Nombre: Tu Nombre</p>
            <p>Correo Electrónico: <a href='mailto:tu@email.com'>tu@email.com</a></p>
            <!-- Agrega más información según sea necesario -->
        </section>

        <!-- Educación -->
        <section class='custom-section'>
            <h3 class='text-success'>Educación</h3>
            <p>Grado Académico: Licenciatura en...</p>
            <p>Universidad: Nombre de la Universidad</p>
            <!-- Agrega más información sobre tu educación -->
        </section>

        <!-- Experiencia Laboral -->
        <section class='custom-section'>
            <h3 class='text-warning'>Experiencia Laboral</h3>
            <p>Puesto: Nombre del Puesto</p>
            <p>Empresa: Nombre de la Empresa</p>
            <!-- Agrega más información sobre tu experiencia laboral -->
        </section>

        <!-- Puedes agregar más secciones según sea necesario -->

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
