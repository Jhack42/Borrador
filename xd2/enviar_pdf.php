<?php
require 'vendor/autoload.php';

use SendGrid\Mail\Mail;
use SendGrid\Mail\Attachment;

// Obtener la clave API de SendGrid de la variable de entorno
$sendgridApiKey = getenv('SENDGRID_API_KEY');

// Verificar si la clave API está presente
if (!$sendgridApiKey) {
    die("No se encontró la clave API de SendGrid. Asegúrate de configurar la variable de entorno SENDGRID_API_KEY.");
}

// Verificar si se enviaron los datos del formulario
if (isset($_POST['enviar'])) {
    // Obtener los datos del formulario
    $remitente = $_POST['remitente'];
    $destinatario = $_POST['destinatario'];
    $archivo_pdf = $_POST['archivo_pdf'];

    // Crear el objeto Email de SendGrid
    $email = new Mail();
    $email->setFrom($remitente, 'Remitente');
    $email->setSubject('Envío de PDF');
    $email->addTo($destinatario, 'Destinatario');
    $email->addContent('text/plain', 'Adjunto encontrarás mi presentación.');

    // Adjuntar el archivo PDF
    $pdf_attachment = new Attachment();
    $pdf_attachment->setContent(base64_encode(file_get_contents($archivo_pdf)));
    $pdf_attachment->setType('application/pdf');
    $pdf_attachment->setFilename($archivo_pdf);
    $pdf_attachment->setDisposition('attachment');
    $email->addAttachment($pdf_attachment);

    // Crear instancia de SendGrid
    $sendgrid = new SendGrid($sendgridApiKey);

    // Enviar el correo electrónico
    try {
        $response = $sendgrid->send($email);
        echo "El PDF ha sido enviado correctamente.";
    } catch (Exception $e) {
        echo "Hubo un error al enviar el PDF: {$e->getMessage()}";
    }
} else {
    echo "No se recibieron datos del formulario.";
}
?>
