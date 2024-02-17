<?php
require 'vendor/autoload.php';

// Obtén la clave API de SendGrid de la variable de entorno
$sendgridApiKey = getenv('SENDGRID_API_KEY');

// Verifica si la clave API está presente
if (!$sendgridApiKey) {
    die("No se encontró la clave API de SendGrid. Asegúrate de configurar la variable de entorno SENDGRID_API_KEY.");
}

$sendgrid = new SendGrid($sendgridApiKey);
$email = new \SendGrid\Mail\Mail();

$email->setFrom("1364822@senati.pe", "Remitente");
$email->setSubject("Envío de PDF");
$email->addTo("cacereshilasacajhack@gmail.com", "Destinatario");
$email->addContent(
    "text/plain", "Adjunto encontrarás mi presentación."
);

// Adjuntar el archivo PDF
$archivo_adjunto = file_get_contents('mi_presentacion.pdf');
$archivo_codificado = base64_encode($archivo_adjunto);
$email->addAttachment(
    $archivo_codificado,
    "application/pdf",
    "mi_presentacion.pdf",
    "attachment"
);

try {
    $response = $sendgrid->send($email);
    echo "El PDF ha sido enviado correctamente.";
} catch (Exception $e) {
    echo "Hubo un error al enviar el PDF: {$e->getMessage()}";
}
?>
