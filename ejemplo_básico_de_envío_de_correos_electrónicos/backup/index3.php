<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

date_default_timezone_set('America/Lima'); // Establece la zona horaria de Lima

function enviar_correo_phpmailer($destinatario, $asunto, $cuerpo) {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP para Outlook.com
        $mail->isSMTP();
        $mail->Host = 'smtp-mail.outlook.com';
        $mail->SMTPAuth = true;
        $mail->Username = '1364822@senati.pe'; // Tu dirección de correo electrónico
        $mail->Password = 'JC221101f'; // Tu contraseña
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuración del correo
        $mail->setFrom('1364822@senati.pe', 'Tu Nombre');
        $mail->addAddress($destinatario);
        $mail->Subject = $asunto;
        $mail->Body = $cuerpo;

        // Envía el correo electrónico
        if ($mail->send()) {
            echo 'Correo enviado exitosamente.';
        } else {
            echo 'Error al enviar el correo: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo 'Error al enviar el correo: ' . $e->getMessage();
    }
}

function enviar_correo_mail($destinatario, $asunto, $cuerpo) {
    $headers = 'From: cacereshilasacajhack@gmail.com' . "\r\n" .
               'Reply-To: cacereshilasacajhack@gmail.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    // Envía el correo electrónico
    if (mail($destinatario, $asunto, $cuerpo, $headers)) {
        echo 'Correo enviado exitosamente.';
    } else {
        echo 'Error al enviar el correo.';
    }
}

function programar_envio_correo($destinatario, $fecha_programada, $asunto, $cuerpo) {
    // Calcula el tiempo hasta la fecha programada
    $tiempo_hasta_programacion = strtotime($fecha_programada) - time();

    // Si el tiempo hasta la fecha programada es menor que un umbral (por ejemplo, 1 hora)
    if ($tiempo_hasta_programacion < 3600) { // 3600 segundos en una hora
        // Envia el correo
        enviar_correo_phpmailer($destinatario, $asunto, $cuerpo);
        // O puedes usar enviar_correo_mail en lugar de enviar_correo_phpmailer según tu preferencia.
    } else {
        echo 'El correo está programado para ser enviado en el futuro.';
    }
}

// Configuración de la cita (ejemplo: 2024-01-26 14:30:00)
$fecha_cita = '2024-01-25 15:39:00';
$destinatario = 'cacereshilasacajhack@gmail.com';

// Configuración de la programación (ejemplo: 2024-01-25 16:00:00)
$fecha_programada = '2024-01-25 15:52:00';

// Programa el envío del recordatorio
programar_envio_correo($destinatario, $fecha_programada, 'Asunto del correo', 'Cuerpo del correo');
?>
