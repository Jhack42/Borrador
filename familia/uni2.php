<?php
header('Content-Type: text/html; charset=utf-8');
// Establecer la zona horaria del sistema operativo Windows
date_default_timezone_set('America/Lima'); // Ajusta la zona horaria según tu ubicación

// Obtener la hora actual del sistema operativo Windows
$hora_actual = date("H:i:s");

echo "Hora actual del sistema operativo Windows: $hora_actual<br><br>";

require 'vendor/autoload.php'; // Incluir el autoload de PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$fromEmail = "1364822@senati.pe"; // Dirección de correo electrónico del remitente
$smtpHost = 'smtp-mail.outlook.com'; // Host del servidor SMTP de Outlook
$smtpUsername = $fromEmail; // Nombre de usuario SMTP (correo electrónico del remitente)
$smtpPassword = 'JC221101f'; // Contraseña SMTP (del correo electrónico del remitente)
$smtpPort = 587; // Puerto SMTP
$smtpSecure = 'tls'; // Tipo de cifrado TLS

// Conexión a la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'seguimiento');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener los datos de los profesores y sus horarios
$sql = "SELECT id_profesor, nombre, apellido, correo, fecha, hora FROM Profesores";
$result = $conn->query($sql);

// Mostrar resultados y enviar correos si es necesario
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        try {
            // Contenido del correo electrónico
            $htmlContent = "<!DOCTYPE html>
                <html>
                <head>
                    <title>Detalles del Profesor y Horario</title>
                    <meta charset='UTF-8'>
                </head>
                <body>
                    <h2>Detalles del Profesor y Horario</h2>
                    <p>Nombre del Profesor: {$row['nombre']} {$row['apellido']}</p>
                    <p>Correo Electrónico: {$row['correo']}</p>
                    <p>Fecha de Horario: {$row['fecha']}</p>
                    <p>Hora de Horario: {$row['hora']}</p>
                </body>
                </html>";

            // Envío del correo electrónico
            $email = new PHPMailer(true);
            $email->isSMTP();
            $email->Host = $smtpHost;
            $email->SMTPAuth = true;
            $email->Username = $smtpUsername;
            $email->Password = $smtpPassword;
            $email->Port = $smtpPort;
            $email->SMTPSecure = $smtpSecure;

            $email->setFrom($fromEmail);
            $email->addAddress($row['correo']);
            $email->CharSet = 'UTF-8';
            $email->Subject = "Detalles del Profesor y Horario";
            $email->isHTML(true);
            $email->Body = $htmlContent;

            $email->send();
            echo "Correo enviado a {$row['correo']} con éxito<br>";
        } catch (Exception $e) {
            echo 'Error al enviar el correo a {$row["correo"]}: ' . $e->getMessage() . "<br>";
        }
    }
} else {
    echo "No se encontraron profesores.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
