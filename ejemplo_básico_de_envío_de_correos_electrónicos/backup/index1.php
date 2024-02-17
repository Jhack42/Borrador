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
        $mail->send();
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}


function enviar_correo_mail($destinatario, $asunto, $cuerpo) {
    $headers = 'From: cacereshilasacajhack@gmail.com' . "\r\n" .
               'Reply-To: cacereshilasacajhack@gmail.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    // Envía el correo electrónico
    mail($destinatario, $asunto, $cuerpo, $headers);
}

function recordatorio_cita($destinatario, $fecha_cita) {
    // Calcula el tiempo hasta la cita
    $tiempo_hasta_cita = strtotime($fecha_cita) - time();
    
    // Si la cita es en menos de un día
    if ($tiempo_hasta_cita < 86400) { // 86400 segundos en un día
        // Envia el recordatorio
        $asunto = 'Recordatorio de cita';
        $cuerpo = 'Tu cita está programada para mañana a las ' . date('H:i', strtotime($fecha_cita));
        enviar_correo_phpmailer($destinatario, $asunto, $cuerpo);
        // O puedes usar enviar_correo_mail en lugar de enviar_correo_phpmailer según tu preferencia.
    }
}

// Configuración de la cita (ejemplo: 2024-01-26 14:30:00)
$fecha_cita = '2024-01-25 15:47:00';
$destinatario = 'cacereshilasacajhack@gmail.com';

// Programa el envío del recordatorio
recordatorio_cita($destinatario, $fecha_cita);
?>
