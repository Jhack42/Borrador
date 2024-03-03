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

// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "seguimiento";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos de las personas y sus habilidades y hijos
$sql = "SELECT 
            persona.id,
            persona.nombre,
            persona.correo,
            GROUP_CONCAT(DISTINCT habilidades.habilidad ORDER BY habilidades.habilidad SEPARATOR ', ') AS habilidades,
            GROUP_CONCAT(DISTINCT hijos.hijo_nombre ORDER BY hijos.hijo_nombre SEPARATOR ', ') AS nombres_hijos,
            persona.fecha,
            persona.hora
        FROM 
            persona
        LEFT JOIN 
            habilidades ON persona.id = habilidades.persona_id
        LEFT JOIN 
            hijos ON persona.id = hijos.persona_id
        GROUP BY 
            persona.id, persona.nombre, persona.correo, persona.fecha, persona.hora";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Habilidades</th>
            <th>Nombres de los hijos</th>
            <th>Fecha de envío</th>
            <th>Hora de envío</th>
            <th>Estado del correo</th>
        </tr>";

    while ($row = $result->fetch_assoc()) {
        try {
            $nombre = $row['nombre'];
            $correo = $row['correo'];
            $habilidades = $row['habilidades'];
            $nombres_hijos = $row['nombres_hijos'];
            $fecha = $row['fecha'];
            $hora = $row['hora'];

            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$nombre}</td>
                    <td>{$correo}</td>
                    <td>{$habilidades}</td>
                    <td>{$nombres_hijos}</td>
                    <td>{$fecha}</td>
                    <td>{$hora}</td>
                    <td>";

            $currentDateTime = new DateTime();
            $taskDateTime = new DateTime($fecha . ' ' . $hora);
            $interval = $currentDateTime->diff($taskDateTime);
            $timeLeft = $interval->format('%R%a días %H horas %I minutos %S segundos');

            if ($timeLeft[0] === '-') {
                // Si el tiempo restante es negativo, significa que la fecha y hora ya han pasado
                echo "El correo fue enviado el {$fecha} a las {$hora}<br>";
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
                            <p><strong>Habilidades:</strong> {$habilidades}</p>
                            <p><strong>Nombres de los hijos:</strong> {$nombres_hijos}</p>
                            <p><strong>Fecha de envío:</strong> {$fecha}</p>
                            <p><strong>Hora de envío:</strong> {$hora}</p>
                        </body>
                        </html>";
                // Envío del correo electrónico
                // Código de envío del correo electrónico...
            } else {
                // Mostrar el estado actual del correo electrónico
                echo "Cargando..."; // Puedes personalizar este mensaje según tus necesidades
            }

            echo "</td>
                </tr>";
        } catch (Exception $e) {
            echo "Error al enviar el correo a {$correo}: " . $e->getMessage() . "<br>";
        }
    }
    echo "</table>";
} else {
    echo "No se encontraron profesores.";
}
$conn->close();
?>