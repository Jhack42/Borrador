<?php
require 'vendor/autoload.php'; // Incluir el autoload de PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "familia";

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
    while ($row = $result->fetch_assoc()) {
        try {
            $nombre = $row['nombre'];
            $correo = $row['correo'];
            $habilidades = $row['habilidades'];
            $nombres_hijos = $row['nombres_hijos'];
            $fecha = $row['fecha'];
            $hora = $row['hora'];

            // Contenido del correo electrónico
            $htmlContent = "<!DOCTYPE html>
                <html>
                <head>
                    <title>Datos Personales</title>
                    <meta charset='UTF-8'>
                </head>
                
                <body>
                    <h2>Datos Personales</h2>
                    <p><strong>Nombre:</strong> $nombre</p>
                    <p><strong>Correo:</strong> $correo</p>
                    <p><strong>Habilidades:</strong> $habilidades</p>
                    <p><strong>Nombres de los hijos:</strong> $nombres_hijos</p>
                    <p><strong>Fecha de envío:</strong> $fecha</p>
                    <p><strong>Hora de envío:</strong> $hora</p>
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
            $email->addAddress($correo);
            $email->CharSet = 'UTF-8';
            $email->Subject = "Datos Personales";
            $email->isHTML(true);
            $email->Body = $htmlContent;

            $email->send();
            echo "Correo enviado a $correo con éxito<br>";
        } catch (Exception $e) {
            echo 'Error al enviar el correo a $correo: ' . $e->getMessage() . "<br>";
        }
    }
} else {
    echo "No se encontraron resultados.";
}

$conn->close();
?>
