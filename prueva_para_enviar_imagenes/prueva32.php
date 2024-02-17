<?php

require 'vendor/autoload.php'; // Load the SendGrid library

$apiKey = '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'; // Replace with your SendGrid API key

// Image URL for the profile picture on Imgur
$imagen_url = 'https://i.postimg.cc/pL366K17/imagen1.png';

// Create the SendGrid object with your API key
$sendgrid = new \SendGrid($apiKey);

// Build the email content with HTML template
$html_content = "
<!DOCTYPE html>
<html>
<head>
    <title>Mi página web con Flask</title>
    <link rel='stylesheet' type='text/css' href='{{ url_for('static', filename='styles/estilos.css') }}'>
</head>
<head>
    <style>
        /* CSS styles for the message design */
        .container {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            padding: 20px;
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            border: 2px solid maroon;
            border-radius: 10px;
            text-align: center;
        }
        /* Header styles */
        .encabezado {
            background-color: rgb(230, 217, 170);
            padding: 10px;
            display: flex;
            align-items: center;
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 20px;
            border-radius: 10px;
            text-align: left;
        }

        .texto-uni-orce {
            font-size: 48px;
            font-weight: bold;
            text-transform: uppercase;
            margin-right: 20px;
            color: #711610
        }

        .img-container {
            float: right;
            margin-left: auto;
            width: 90px;
            margin-right: 20px;
        }

        .imagen {
            width: 90px;
            max-width: 100px;
            margin-left: auto;
        }
        /* Content styles */
        .content {
            background-color: white;
            padding: 20px;
            color: #711610
        }

        .contenedor_invisible {
            display: flex;
            justify-content: flex-end;
        }

        .pie_de_página {
            background-color: rgb(230, 217, 170);
            border-radius: 10px;
        }

    </style>
</head>
<body>
    <div class='container'>
        <!-- Header -->
        <div class='encabezado'>
            <div class='texto-uni-orce' style='display: inline-block;'>
                UNI<br>ORCE
            </div>
            <img class='img-container' src='{$imagen_url}' alt='imagen1.png'>
        </div>
        <!-- Content -->
        <div class='content'>
            <p>Bienvenido {nombres_profesor} {apellidos_profesor}</p>
            <ul>
                <li>al ciclo 2022-1</li>
                <li>{curso_seccion}</li>
                <li>Listado de estudiantes: {listado_estudiantes}</li>
                <li>Donde cargar su material</li>
                <li>Listado de sesiones, fecha y hora: {listado_sesiones}</li>
                <li>Listado de evaluaciones, fecha y hora, cargar sus evaluaciones: {listado_evaluaciones}</li>
            </ul>
            <p>¡Esperamos un excelente ciclo!</p>
        </div>
        <!-- Footer -->
        <div class='pie_de_página'>
            <!-- Address -->
            <div class='contenedor_invisible'>
                <div class='text_direccion' style='text-align: right;'>
                    <p style='text-align: left;'>Contacto</p>
                    <p style='text-align: left;'>Av. Túpac Amaru 210 - Rímac.</p>
                    <p style='text-align: left;'>Apartado 1301. Lima - Perú</p>
                    <p style='text-align: left;'>Telf.: 4811070</p>
                </div>
            </div>
            <!-- Text -->
            <div class='text' style='display: block; text-align: center;'>
                <p>2022 © Derechos Reservados</p>
            </div>
        </div>        
    </div>
</body>
</html>
";

// Create the email object and set the HTML content
$email = new \SendGrid\Mail\Mail();
$email->setFrom("cacereshilasacajhack@gmail.com", "Remitente");
$email->setSubject("Presentación con Imagen Adjunta");
$email->addTo("cacereshilasacajhack@gmail.com", "Destinatario");
$email->addContent("text/html", $html_content);

// Send the email
try {
    $response = $sendgrid->send($email);
    print_r($response->statusCode());
    print_r($response->headers());
    print_r($response->body());
} catch (Exception $e) {
    echo 'Excepción atrapada: ', $e->getMessage(), "\n";
}
?>
