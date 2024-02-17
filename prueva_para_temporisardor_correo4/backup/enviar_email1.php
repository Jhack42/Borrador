<?php
require 'vendor/autoload.php'; // Carga la biblioteca de SendGrid

// Obtener la fecha y hora ingresadas por el usuario
$fecha = isset($_POST['fecha']) ? $_POST['fecha'] : null;
$hora = isset($_POST['hora']) ? $_POST['hora'] : null;

if ($fecha === null || $hora === null) {
    echo "Error: Datos de fecha y hora no proporcionados correctamente.";
    exit;
}

// Combinar fecha y hora en un formato de fecha y hora de UNIX
$fecha_hora_unix = strtotime("$fecha $hora");

// Ruta completa al archivo php.exe de XAMPP
$php_executable = 'C:\xampp\php\php.exe';

// Ruta completa al script enviar_email.php
$script_path = 'C:\xampp\htdocs\Borrador\prueva_para_temporisardor_correo4\enviar_email.php';


// Formatear la fecha y hora para el comando schtasks
$fecha_hora_formateada = date('H:i', $fecha_hora_unix);

// Nombre de la tarea
$tarea_nombre = "EnviarCorreoTask";

// Eliminar la tarea existente si ya está programada
exec("schtasks /delete /tn \"$tarea_nombre\" /f");

// Crear la línea de tarea programada en Windows
$cron_line = "schtasks /create /sc once /st $fecha_hora_formateada /tn \"$tarea_nombre\" /tr \"$php_executable $script_path\" > output.txt 2>&1";

// Programar la tarea cron
exec($cron_line, $output, $return_var);

// Verificar si la tarea se programó correctamente
if ($return_var === 0) {
    // Mensaje de éxito
    echo "<p>Tarea programada correctamente para el $fecha a las $hora en Windows.</p>";

    // Configuración de SendGrid
    $apiKey = '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'; // Reemplaza con tu propia clave API de SendGrid

    // Crea el objeto SendGrid con tu clave API
    $sendgrid = new \SendGrid($apiKey);

    // Construye el correo electrónico con una plantilla HTML
    $html_content = "<!DOCTYPE html> <!-- Resto del contenido HTML --> </html>";

    // Crea el objeto de correo electrónico y establece el contenido HTML
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("cacereshilasacajhack@gmail.com", "Remitente");
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
} else {
    // Mensaje de error
    echo "<p>Error al programar la tarea.</p>";
    // Puedes imprimir detalles del error si es necesario
    echo "<pre>" . implode("\n", $output) . "</pre>";
}
?>
