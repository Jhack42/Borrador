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
$sql = "SELECT
            nombre,
            correo
        FROM
            Profesores";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        try {
            $nombre_profesor = $row['nombre'];
            $correo_profesor = $row['correo'];

            // Contenido del correo electrónico
            $htmlContent = "<!DOCTYPE html>
                        <html>
                        <head>
                            <title>Bienvenido {$nombre_profesor}</title>
                            <meta charset='UTF-8'>
                        </head>
                        
                        <body>
                            <h2>Bienvenido {$nombre_profesor}</h2>
                            <p>al ciclo 2022-1</p>
                            <p><curso sección></p>
                            <h3>Listado de estudiantes</h3>
                            <p><em>Deberá aparecer una lista de los estudiantes relacionados</em></p>
                            <h3>Donde cargar su material</h3>
                            <h3>Listado de sesiones, fecha y hora</h3>
                            <p><em>Deberá aparecer una tabla con el listado de las sesiones, fecha y hora</em></p>
                            <h3>Listado de evaluaciones, fecha y hora, cargar sus evaluaciones</h3>
                            <p><em>Deberá aparecer una tabla con el listado de las evaluaciones, fecha y hora</em></p>
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
            $email->Subject = "Bienvenido {$nombre_profesor} al ciclo 2022-1";
            $email->isHTML(true);
            $email->Body = $htmlContent;

            $email->send();
            echo "Correo enviado a {$correo_profesor} con éxito<br>";
        } catch (Exception $e) {
            echo "Error al enviar el correo a {$correo_profesor}: " . $e->getMessage() . "<br>";
        }
    }
} else {
    echo "No se encontraron profesores.";
}

$conn->close();
?>
