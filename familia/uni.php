<?php
require 'vendor/autoload.php'; // Incluir el autoload de PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Conexión a la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'seguimiento');

// Establecer la conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conexion->connect_error) {
    die("Error al conectar a la base de datos: " . $conexion->connect_error);
}

// Consulta para obtener los datos de los profesores, cursos, sesiones y evaluaciones
$query = "
    SELECT Profesores.nombre AS nombre_profesor, 
           Cursos.nombre AS nombre_curso, 
           Sesiones.seccion, 
           Sesiones.dia AS fecha_sesion, 
           Sesiones.hora AS hora_sesion, 
           Evaluaciones.nombre_evaluacion, 
           Evaluaciones.fecha AS fecha_evaluacion, 
           Evaluaciones.hora AS hora_evaluacion,
           Profesores.correo AS correo_profesor
    FROM Profesores
    JOIN Sesiones ON Profesores.id_profesor = Sesiones.id_profesor
    JOIN Cursos ON Sesiones.id_curso = Cursos.id_curso
    JOIN Evaluaciones ON Cursos.id_curso = Evaluaciones.id_curso";

$result = $conexion->query($query);

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        try {
            // Contenido del correo electrónico
            $htmlContent = "<!DOCTYPE html>
                <html>
                <head>
                    <title>Detalles del Curso</title>
                    <meta charset='UTF-8'>
                </head>
                
                <body>
                    <h2>Detalles del Curso</h2>
                    <p>Nombre del Curso: {$row['nombre_curso']}</p>
                    <p>Sección: {$row['seccion']}</p>
                    <p>Fecha de Sesión: {$row['fecha_sesion']}</p>
                    <p>Hora de Sesión: {$row['hora_sesion']}</p>
                    <p>Nombre de la Evaluación: {$row['nombre_evaluacion']}</p>
                    <p>Fecha de Evaluación: {$row['fecha_evaluacion']}</p>
                    <p>Hora de Evaluación: {$row['hora_evaluacion']}</p>
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
            $email->addAddress($row['correo_profesor']);
            $email->CharSet = 'UTF-8';
            $email->Subject = "Detalles del Curso";
            $email->isHTML(true);
            $email->Body = $htmlContent;

            $email->send();
            echo "Correo enviado a {$row['correo_profesor']} con éxito<br>";
        } catch (Exception $e) {
            echo "Error al enviar el correo a {$row['correo_profesor']}: " . $e->getMessage() . "<br>";
        }
    }
} else {
    echo "No se encontraron resultados.";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
