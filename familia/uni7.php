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

$smtpHost = 'smtp-mail.outlook.com'; // Host del servidor SMTP de Outlook
$smtpUsername = 'tu_correo@example.com'; // Nombre de usuario SMTP (correo electrónico del remitente)
$smtpPassword = 'tu_contraseña'; // Contraseña SMTP (del correo electrónico del remitente)
$smtpPort = 587; // Puerto SMTP
$smtpSecure = 'tls'; // Tipo de cifrado TLS

// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "seguimiento";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos de los profesores
$sql_profesores = "SELECT * FROM Profesores";

$result_profesores = $conn->query($sql_profesores);

// Procesar resultados de la consulta de profesores
if ($result_profesores->num_rows > 0) {
    while ($row = $result_profesores->fetch_assoc()) {
        $nombre_profesor = $row['nombre'];
        $correo_profesor = $row['correo'];
        $fecha_envio = $row['fecha'];
        $hora_envio = $row['hora'];

        try {
            $currentDateTime = new DateTime();
            $taskDateTime = new DateTime($fecha_envio . ' ' . $hora_envio);
            $interval = $currentDateTime->diff($taskDateTime);
            $timeLeft = $interval->format('%R%a días %H horas %I minutos %S segundos');

            if ($timeLeft[0] === '-') {
                // Si el tiempo restante es negativo, significa que la fecha y hora ya han pasado
                echo "El correo fue enviado el {$fecha_envio} a las {$hora_envio} a {$correo_profesor}<br>";
            } elseif ($timeLeft === '+0 días 00 horas 00 minutos 00 segundos') {
                // Si el tiempo restante es cero y el correo aún no se ha enviado
                // Contenido del correo electrónico
                $htmlContent = "<!DOCTYPE html>
                        <html>
                        <head>
                            <title>Recordatorio de Evento</title>
                            <meta charset='UTF-8'>
                        </head>
                        
                        <body>
                            <h2>Recordatorio de Evento</h2>
                            <p>Estimado {$nombre_profesor},</p>
                            <p>Este es un recordatorio de su evento programado para el {$fecha_envio} a las {$hora_envio}.</p>
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

                $email->setFrom($smtpUsername);
                $email->addAddress($correo_profesor);
                $email->CharSet = 'UTF-8';
                $email->Subject = "Recordatorio de Evento";
                $email->isHTML(true);
                $email->Body = $htmlContent;

                $email->send();
                echo "Correo enviado a {$correo_profesor} con éxito<br>";
            } else {
                // Mostrar el estado actual del correo electrónico
                echo "Cargando..."; // Este es solo un ejemplo, puedes personalizarlo según tus necesidades
            }
        } catch (Exception $e) {
            echo "Error al enviar el correo a {$correo_profesor}: " . $e->getMessage() . "<br>";
        }
    }
} else {
    echo "No se encontraron resultados.";
}

$conn->close();
?>
