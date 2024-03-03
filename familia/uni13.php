<?php
header('Content-Type: text/html; charset=utf-8');

// Establecer la zona horaria del sistema operativo Windows
date_default_timezone_set('America/Lima');

// Obtener la hora actual del sistema operativo Windows
$hora_actual = date("H:i:s");

echo "Hora actual del sistema operativo Windows: $hora_actual<br><br>";

// Constantes para la configuración del servidor SMTP
define('SMTP_HOST', 'smtp-mail.outlook.com');
define('SMTP_USERNAME', '1364822@senati.pe');
define('SMTP_PASSWORD', 'JC221101f');
define('SMTP_PORT', 587);
define('SMTP_SECURE', 'tls');

require 'vendor/autoload.php'; // Incluir el autoload de PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarCorreo($correo, $htmlContent) {
    try {
        $email = new PHPMailer(true);
        $email->isSMTP();
        $email->Host = SMTP_HOST;
        $email->SMTPAuth = true;
        $email->Username = SMTP_USERNAME;
        $email->Password = SMTP_PASSWORD;
        $email->Port = SMTP_PORT;
        $email->SMTPSecure = SMTP_SECURE;

        $email->setFrom(SMTP_USERNAME);
        $email->addAddress($correo);
        $email->CharSet = 'UTF-8';
        $email->Subject = "Datos Personales";
        $email->isHTML(true);
        $email->Body = $htmlContent;

        $email->send();
        return true; // Correo enviado con éxito
    } catch (Exception $e) {
        return $e->getMessage(); // Devuelve el mensaje de error si falla el envío
    }
}

function obtenerTablaProfesores($result) {
    $table = "<table border='1'>
                <tr>
                    <th>ID Profesor</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Edad</th>
                    <th>Fecha de envío</th>
                    <th>Hora de envío</th>
                    <th>Estado del correo</th>
                </tr>";

    while ($row = $result->fetch_assoc()) {
        $id_profesor = $row['id_profesor'];
        $nombre = $row['nombre'] . ' ' . $row['apellido'];
        $correo = $row['correo'];
        $edad = $row['edad'];
        $fecha = $row['fecha'];
        $hora = $row['hora'];

        $table .= "<tr>
                    <td>{$id_profesor}</td>
                    <td>{$nombre}</td>
                    <td>{$correo}</td>
                    <td>{$edad}</td>
                    <td>{$fecha}</td>
                    <td>{$hora}</td>
                    <td>";

        $currentDateTime = new DateTime();
        $taskDateTime = new DateTime($fecha . ' ' . $hora);
        $interval = $currentDateTime->diff($taskDateTime);
        $timeLeft = $interval->format('%R%a días %H horas %I minutos %S segundos');

        if ($timeLeft[0] === '-') {
            // Si el tiempo restante es negativo, significa que la fecha y hora ya han pasado
            $table .= "El correo fue enviado el {$fecha} a las {$hora}<br>";
        } elseif ($timeLeft === '+0 días 00 horas 00 minutos 00 segundos') {
            // Si el tiempo restante es cero y el correo aún no se ha enviado
            // Contenido del correo electrónico
            $htmlContent = "<!DOCTYPE html>
                            <html>
                            <head>
                                <title>Datos Personales</title>
                                <meta charset='UTF-8'>
                            </head>
                            
                            <body>
                                <h2>Datos Personales</h2>
                                <p><strong>Nombre:</strong> {$nombre}</p>
                                <p><strong>Correo:</strong> {$correo}</p>
                                <p><strong>Edad:</strong> {$edad}</p>
                                <p><strong>Fecha de envío:</strong> {$fecha}</p>
                                <p><strong>Hora de envío:</strong> {$hora}</p>
                            </body>
                            </html>";

            // Envío del correo electrónico
            $envioCorreo = enviarCorreo($correo, $htmlContent);
            if ($envioCorreo === true) {
                $table .= "Correo enviado a {$correo} con éxito<br>";
            } else {
                $table .= "Error al enviar el correo: {$envioCorreo}<br>";
            }
        } else {
            // Mostrar el estado actual del correo electrónico
            $table .= "Cargando...";
        }

        $table .= "</td></tr>";
    }

    $table .= "</table>";
    return $table;
}

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
            id_profesor,
            nombre,
            apellido,
            correo,
            edad,
            fecha,
            hora
        FROM 
            Profesores";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo obtenerTablaProfesores($result);
} else {
    echo "No se encontraron profesores.";
}

$conn->close();
?>
