<?php
header('Content-Type: text/html; charset=utf-8');

// Establecer la zona horaria del sistema operativo Windows
date_default_timezone_set('America/Lima');

// Obtener la hora actual del sistema operativo Windows
$hora_actual = date("H:i:s");

echo "Hora actual del sistema operativo Windows: $hora_actual<br><br>";

// Constantes para la configuración del servidor SMTP
define('SMTP_HOST', 'smtp-mail.outlook.com');
define('SMTP_USERNAME', 'tu_correo@dominio.com');
define('SMTP_PASSWORD', 'tu_contraseña');
define('SMTP_PORT', 587);
define('SMTP_SECURE', 'tls');

require 'vendor/autoload.php'; // Incluir el autoload de PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "seguimiento3";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos de los profesores y sus cursos
$sql = "SELECT 
            Profesores.id_profesor,
            CONCAT(Profesores.nombre, ' ', Profesores.apellido) AS nombre_profesor,
            Profesores.correo,
            Profesores.edad,
            Profesores.fecha_ingreso,
            Profesores.hora_ingreso,
            Cursos.nombre_curso,
            Cursos.seccion,
            GROUP_CONCAT(CONCAT(Estudiantes.nombre, ' ', Estudiantes.apellido) SEPARATOR ', ') AS estudiantes,
            Sesiones.fecha AS fecha_sesion,
            Sesiones.hora AS hora_sesion,
            Evaluaciones.nombre_evaluacion,
            Evaluaciones.fecha AS fecha_evaluacion,
            Evaluaciones.hora AS hora_evaluacion
        FROM 
            Profesores
        INNER JOIN Cursos ON Profesores.id_profesor = Cursos.id_profesor
        INNER JOIN Estudiantes ON Cursos.id_curso = Estudiantes.id_curso
        INNER JOIN Sesiones ON Cursos.id_curso = Sesiones.id_curso
        INNER JOIN Evaluaciones ON Cursos.id_curso = Evaluaciones.id_curso
        GROUP BY 
            Profesores.id_profesor,
            Profesores.nombre,
            Profesores.apellido,
            Profesores.correo,
            Profesores.edad,
            Profesores.fecha_ingreso,
            Profesores.hora_ingreso,
            Cursos.nombre_curso,
            Cursos.seccion,
            Sesiones.fecha,
            Sesiones.hora,
            Evaluaciones.nombre_evaluacion,
            Evaluaciones.fecha,
            Evaluaciones.hora";


$result = $conn->query($sql);

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
        $email->Subject = "Bienvenido al ciclo 2022-1";
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
                    <th>Fecha de ingreso</th>
                    <th>Hora de ingreso</th>
                    <th>Estado del correo</th>
                </tr>";

    while ($row = $result->fetch_assoc()) {
        $id_profesor = $row['id_profesor'];
        $nombre = $row['nombre_profesor'];
        $correo = $row['correo'];
        $edad = $row['edad'];
        $fecha_ingreso = $row['fecha_ingreso'];
        $hora_ingreso = $row['hora_ingreso'];
        $nombre_curso = $row['nombre_curso'];
        $seccion = $row['seccion'];
        $estudiantes = $row['estudiantes'];
        $fecha_sesion = $row['fecha_sesion'];
        $hora_sesion = $row['hora_sesion'];
        $nombre_evaluacion = $row['nombre_evaluacion'];
        $fecha_evaluacion = $row['fecha_evaluacion'];
        $hora_evaluacion = $row['hora_evaluacion'];

        // Separar los nombres de los estudiantes por guiones
        $estudiantesArray = explode(", ", $estudiantes);
        $estudiantesFormatted = "";
        foreach ($estudiantesArray as $estudiante) {
            $estudiantesFormatted .= "- $estudiante<br>";
        }

        // Contenido del correo electrónico
        $htmlContent = "<!DOCTYPE html>
            <html>
            <head>
                <title>Bienvenido al ciclo 2022-1</title>
                <meta charset='UTF-8'>
            </head>
            <body>
                <h2>Bienvenido $nombre</h2>
                <p>al ciclo 2022-1</p>
                <p>$nombre_curso - $seccion</p>
                <h3>Listado de estudiantes</h3>
                $estudiantesFormatted
                <p>Donde cargar su material</p>
                <h3>Listado de sesiones</h3>
                <table border='1'>
                    <tr>
                        <th>Fecha de sesión</th>
                        <th>Hora de sesión</th>
                    </tr>
                    <tr>
                        <td>$fecha_sesion</td>
                        <td>$hora_sesion</td>
                    </tr>
                </table>
                <h3>Listado de evaluaciones</h3>
                <table border='1'>
                    <tr>
                        <th>Nombre de evaluación</th>
                        <th>Fecha de evaluación</th>
                        <th>Hora de evaluación</th>
                    </tr>
                    <tr>
                        <td>$nombre_evaluacion</td>
                        <td>$fecha_evaluacion</td>
                        <td>$hora_evaluacion</td>
                    </tr>
                </table>
            </body>
            </html>";

        // Envío del correo electrónico
        $envioCorreo = enviarCorreo($correo, $htmlContent);
        if ($envioCorreo === true) {
            $table .= "<tr>
                        <td>$id_profesor</td>
                        <td>$nombre</td>
                        <td>$correo</td>
                        <td>$edad</td>
                        <td>$fecha_ingreso</td>
                        <td>$hora_ingreso</td>
                        <td>Correo enviado a $correo con éxito</td>
                    </tr>";
        } else {
            $table .= "<tr>
                        <td>$id_profesor</td>
                        <td>$nombre</td>
                        <td>$correo</td>
                        <td>$edad</td>
                        <td>$fecha_ingreso</td>
                        <td>$hora_ingreso</td>
                        <td>Error al enviar el correo: $envioCorreo</td>
                    </tr>";
        }
    }

    $table .= "</table>";
    return $table;
}

if ($result->num_rows > 0) {
    echo obtenerTablaProfesores($result);
} else {
    echo "No se encontraron profesores.";
}

$conn->close();
?>
