<?php

require 'vendor/autoload.php'; // Reemplaza con la ruta correcta a tu archivo autoload.php

date_default_timezone_set('America/Lima'); // Establece la zona horaria de Lima

function enviar_correo_sendgrid($destinatario, $asunto, $cuerpo, $apiKey) {
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom('cacereshilasacajhack@gmail.com', 'Tu Nombre');
    $email->setSubject($asunto);
    $email->addTo($destinatario);
    $email->addContent("text/plain", $cuerpo);

    $sendgrid = new \SendGrid($apiKey);

    try {
        $response = $sendgrid->send($email);
        if ($response->statusCode() == 202) {
            echo 'Correo enviado exitosamente.';
        } else {
            echo 'Error al enviar el correo. Código de estado: ' . $response->statusCode() . ', Respuesta: ' . $response->body();
        }
    } catch (Exception $e) {
        echo 'Error al enviar el correo: ' . $e->getMessage();
    }
}

function programar_envio_correo($destinatario, $fecha_programada, $asunto, $cuerpo, $apiKey) {
    // Calcula el tiempo hasta la fecha programada
    $tiempo_hasta_programacion = strtotime($fecha_programada) - time();

    // Si el tiempo hasta la fecha programada es menor que un umbral (por ejemplo, 1 hora)
    if ($tiempo_hasta_programacion < 3600) { // 3600 segundos en una hora
        // Envia el correo
        enviar_correo_sendgrid($destinatario, $asunto, $cuerpo, $apiKey);
    } else {
        echo 'El correo está programado para ser enviado en el futuro.';
    }
}

// Configuración de la cita (ejemplo: 2024-01-26 14:30:00)
$fecha_cita = '2024-01-25 15:39:00';
$destinatario = 'cacereshilasacajhack@gmail.com';

// Configuración de la programación (ejemplo: 2024-01-25 16:00:00)
$fecha_programada = '2024-01-25 16:00:00';

// Tu clave API de SendGrid
$apiKey = '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';

// Programa el envío del recordatorio
programar_envio_correo($destinatario, $fecha_programada, 'Asunto del correo', 'Cuerpo del correo', $apiKey);
?>
