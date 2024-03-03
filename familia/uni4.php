<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Lima');

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$fromEmail = "tu_correo@example.com"; // Reemplaza con tu dirección de correo
$smtpHost = 'smtp-mail.outlook.com';
$smtpUsername = $fromEmail;
$smtpPassword = 'tu_contraseña';
$smtpPort = 587;
$smtpSecure = 'tls';

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'seguimiento');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$query = "
    SELECT id_profesor, fecha, hora, nombre, curso_seccion, listado_estudiantes, listado_sesiones, listado_evaluaciones, correo
    FROM Profesores
";

$result = $conn->query($query);

echo "<table border='1'>
        <tr>
            <th>ID Profesor</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Nombre</th>
            <th>Curso y Sección</th>
            <th>Listado de Estudiantes</th>
            <th>Listado de Sesiones</th>
            <th>Listado de Evaluaciones</th>
            <th>Correo</th>
            <th>Tiempo Restante</th>
            <th>Estado del Correo</th>
        </tr>";

while ($row = $result->fetch_assoc()) {
    $currentDateTime = new DateTime();
    $taskDateTime = new DateTime($row['fecha'] . ' ' . $row['hora']);
    $interval = $currentDateTime->diff($taskDateTime);

    $timeLeft = $interval->format('%R%a días %H horas %I minutos %S segundos');

    echo "<tr>
            <td>{$row['id_profesor']}</td>
            <td>{$row['fecha']}</td>
            <td>{$row['hora']}</td>
            <td>{$row['nombre']}</td>
            <td>{$row['curso_seccion']}</td>
            <td>{$row['listado_estudiantes']}</td>
            <td>{$row['listado_sesiones']}</td>
            <td>{$row['listado_evaluaciones']}</td>
            <td>{$row['correo']}</td>
            <td>{$timeLeft}</td>
            <td>";

    if ($timeLeft[0] === '-') {
        echo "Fue enviado el {$row['fecha']} a las {$row['hora']}<br>";
    } elseif ($timeLeft === '+0 días 00 horas 00 minutos 00 segundos') {
        try {
            $htmlContent = "<!DOCTYPE html>
                <html>
                <head>
                    <title>Carta de Presentación</title>
                    <meta charset='UTF-8'>
                </head>
                <body>
                    <!-- Contenido del correo -->
                </body>
                </html>";

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
            $email->Subject = "Carta de Presentación";
            $email->isHTML(true);
            $email->Body = $htmlContent;

            $email->send();
            echo "Correo enviado a {$row['correo']} con éxito<br>";
        } catch (Exception $e) {
            echo "Error al enviar el correo a {$row['correo']}: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "Cargando..."; // Puedes personalizar según tus necesidades
    }

    echo "</td>
        </tr>";
}

echo "</table>";

$conn->close();
?>
