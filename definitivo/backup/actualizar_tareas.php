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
define('DB_NAME', 'prueba');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener los datos de los docentes
$sql = "SELECT nombre_docente, curso_seccion, listado_estudiantes, listado_sesiones, listado_evaluaciones, correo_docente FROM InformacionDocente";
$result = $conn->query($sql);

// Mostrar resultados en el correo electrónico
while ($row = $result->fetch_assoc()) {
    try {
        // Contenido del correo electrónico
        $htmlContent = "<!DOCTYPE html>
            <html>
            <head>
                <title>Bienvenido al ciclo 2022-1</title>
                <meta charset='UTF-8'>
            </head>
            <body>
                <div class='container'>
                    <div class='encabezado'>
                        <div class='texto-uni-orce' style='display: inline-block;'>
                            UNI<br>ORCE
                        </div>
                        <img class='img-container' src='https://i.postimg.cc/pL366K17/imagen1.png' alt='imagen1.png'>
                    </div>
                    <div class='content'>
                        <p>Bienvenido {$row['nombre_docente']}</p>
                        <ul>
                            <li>al ciclo 2022-1</li>
                            <li>{$row['curso_seccion']}</li>
                            <li>Listado de estudiantes: {$row['listado_estudiantes']}</li>
                            <li>Donde cargar su material</li>
                            <li>Listado de sesiones, fecha y hora: {$row['listado_sesiones']}</li>
                            <li>Listado de evaluaciones, fecha y hora, cargar sus evaluaciones: {$row['listado_evaluaciones']}</li>
                        </ul>
                        <p>¡Esperamos un excelente ciclo!</p>
                    </div>
                    <div class='pie_de_página'>
                        <div class='contenedor_invisible'>
                            <div class='text_direccion' style='text-align: right;'>
                                <p style='text-align: left;'>Contacto</p>
                                <p style='text-align: left;'>Av. Túpac Amaru 210 - Rímac.</p>
                                <p style='text-align: left;'>Apartado 1301. Lima - Perú</p>
                                <p style='text-align: left;'>Telf.: 4811070</p>
                            </div>
                        </div>
                        <div class='text' style='display: block; text-align: center;'>
                            <p>2022 © Derechos Reservados</p>
                        </div>
                    </div>        
                </div>
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
        $email->addAddress($row['correo_docente']);
        $email->CharSet = 'UTF-8';
        $email->Subject = "Bienvenido al ciclo 2022-1";
        $email->isHTML(true);
        $email->Body = $htmlContent;

        $email->send();
        echo "Correo enviado a {$row['correo_docente']} con éxito<br>";
    } catch (Exception $e) {
        echo 'Error al enviar el correo a {$row["correo_docente"]}: ' . $e->getMessage() . "<br>";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
