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
            --primary-color: #3498db; /* Cambia el color principal */
        }

        body {
            background-color: #f8f9fa; /* Cambia el color de fondo */
        }

        .custom-section {
            background-color: #ffffff; /* Cambia el color de fondo de las secciones */
            border: 1px solid #ced4da; /* Agrega un borde a las secciones */
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .card {
            border: 1px solid var(--primary-color); /* Agrega un borde a la tarjeta */
            border-radius: 15px;
        }

        .card-title {
            color: var(--primary-color); /* Cambia el color del título de la tarjeta */
        }

        .card-body {
            color: #333333; /* Cambia el color del texto de la tarjeta */
        }
    </style>
</head>
<body>

    <div class='container mt-5'>
        <div class='row justify-content-center'>
            <div class='col-md-8'>
                <div class='card'>
                    <div class='card-body'>
                        <h2 class='card-title text-center'>Mi Currículum</h2>

                        <!-- Datos Personales -->
                        <section class='custom-section'>
                            <h3 class='text-info'>Datos Personales</h3>
                            <p>Nombre: Tu Nombre</p>
                            <p>Correo Electrónico: tu@email.com</p>
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
                </div>
            </div>
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
