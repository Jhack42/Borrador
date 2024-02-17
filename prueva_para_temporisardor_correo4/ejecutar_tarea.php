<?php

require 'vendor/autoload.php'; // Asegúrate de incluir el autoload de SendGrid

$apiKey = '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';
$sendgrid = new \SendGrid($apiKey);

// Image URL for the profile picture on Imgur
//$imagen_url = 'https://i.imgur.com/ON5gjNa.png';

$htmlContent = "
<!DOCTYPE html>
<html>
<head>
    <title>Mi página web con Flask</title>
</head>
<head>
    <style>
        /* Estilos CSS para el diseño del mensaje */
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
        /*------------encabezado-------------*/
        .encabezado {
            background-color: rgb(230, 217, 170);
            padding: 10px;
            display: flex;
            align-items: center; /* Alinea verticalmente el texto y la imagen */
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 20px;
            border-radius: 10px;
            text-align: left; /* Alineación del texto a la izquierda dentro del encabezado */
        }

        .texto-uni-orce {
            font-size: 48px;
            font-weight: bold;
            text-transform: uppercase;
            margin-right: 20px;
            color: #711610
        }
        /* Estilos para la imagen dentro del encabezado */
        .img-container {
            float: right; /* Alineación a la derecha */
            margin-left: auto;
            width: 90px; /* Ancho de la imagen */
            margin-right: 20px; /* Espacio entre la imagen y el contenido adyacente */
        }

        .imagen {
            width: 90px; /* Ancho de la imagen */
            max-width: 100px;/* Ajusta el tamaño de la imagen según sea necesario */
            margin-left: auto; /* Empuja la imagen a la derecha */
        }
        /*------------content-------------*/
        .content {
            background-color: white;
            padding: 20px;
            color: #711610
        }
        .contenedor_invisible {
            display: flex;
            justify-content: flex-end; /* Alinea el contenido a la derecha */
        }
        .pie_de_página {
            background-color: rgb(230, 217, 170);
            border-radius: 10px;
        }

    </style>
</head>
<body>
    <div class='container'>
        <!--------------encabezado--------------->
        <div class='encabezado' >
            <div class='texto-uni-orce' style='display: inline-block;'>
                UNI<br>ORCE
            </div>
            <img class='img-container' src='https://i.imgur.com/ON5gjNa.png' alt='imagen1.png'>
        </div>
        <!--------------contenido--------------->
        <div class='content'>
            <p>Bienvenido {nombres_profesor} {apellidos_profesor}</p>
            <ul>
            <p>al ciclo 2022-1</p>
            <p>{curso_seccion}</p>
            <p>Listado de estudiantes: {listado_estudiantes}</p>
            <p>Donde cargar su material</p>
            <p>Listado de sesiones, fecha y hora: {listado_sesiones}</p>
            <p>Listado de evaluaciones, fecha y hora, cargar sus evaluaciones: {listado_evaluaciones}</p>
            </ul>
            <p>¡Esperamos un excelente ciclo!</p>
        </div>
        <!--------------pie_de_página--------------->
        <div class='pie_de_página'>
            <!-- dirección -->
            <div class='contenedor_invisible'>
                <div class='text_direccion' style='text-align: right;'>
                    <p style='text-align: left;'>Contacto</p>
                    <p style='text-align: left;'>Av. Túpac Amaru 210 - Rímac.</p>
                    <p style='text-align: left;'>Apartado 1301. Lima - Perú</p>
                    <p style='text-align: left;'>Telf.: 4811070</p>
                </div>
            </div>
            <!-- text -->
            <div class='text' style='display: block; text-align: center;'>
                <p>2022 © Derechos Reservados</p>
            </div>
        </div>        
    </div>
</body>
</html>

";
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
