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
$servername = "localhost";
$username = "root";
$password = "";
$database = "seguimiento";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener los datos de los docentes
$sql = "SELECT id, fecha, hora, nombre_docente, curso_seccion, listado_estudiantes, listado_sesiones, listado_evaluaciones, correo_docente FROM InformacionDocente";
$result = $conn->query($sql);

// Mostrar resultados en la tabla y enviar correos si es necesario
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Nombre Docente</th>
            <th>Curso y Sección</th>
            <th>Listado de Estudiantes</th>
            <th>Listado de Sesiones</th>
            <th>Listado de Evaluaciones</th>
            <th>Correo Docente</th>
            <th>Tiempo Restante</th>
            <th>Estado del Correo</th>
        </tr>";

while ($row = $result->fetch_assoc()) {
    $currentDateTime = new DateTime();
    $taskDateTime = new DateTime($row['fecha'] . ' ' . $row['hora']);
    $interval = $currentDateTime->diff($taskDateTime);
    
    // Formato de tiempo restante con segundos incluidos
    $timeLeft = $interval->format('%R%a días %H horas %I minutos %S segundos');
    
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['fecha']}</td>
            <td>{$row['hora']}</td>
            <td>{$row['nombre_docente']}</td>
            <td>{$row['curso_seccion']}</td>
            <td>{$row['listado_estudiantes']}</td>
            <td>{$row['listado_sesiones']}</td>
            <td>{$row['listado_evaluaciones']}</td>
            <td>{$row['correo_docente']}</td>
            <td>{$timeLeft}</td>
            <td>"; // Nuevo td para los mensajes de éxito o error

    if ($timeLeft[0] === '-') {
        // Si el tiempo restante es negativo, significa que la fecha y hora ya han pasado
        echo "Fue enviado el {$row['fecha']} a las {$row['hora']}<br>";
    } elseif ($timeLeft === '+0 días 00 horas 00 minutos 00 segundos') {
        // Si el tiempo restante es cero y el correo aún no se ha enviado
        try {
            // Contenido del correo electrónico
            $htmlContent = "<!DOCTYPE html>
                <html>
                <head>
                    <title>Carta de Presentación</title>
                    <meta charset='UTF-8'>
                </head>
                
                <body>

                <div class='custom-section'>
                    <h2 class='card-title'>¡Descubre lo Mejor de Mí!</h2>

                    <!-- Datos Personales -->
                    <section class='custom-section'>
                        <h3 class='text-info'>Datos Personales</h3>
                        <p>Nombre: {$row['nombre_docente']}</p>
                        <p>Curso y Sección: {$row['curso_seccion']}</p>
                        <p>Listado de Estudiantes: {$row['listado_estudiantes']}</p>
                        <p>Listado de Sesiones: {$row['listado_sesiones']}</p>
                        <p>Listado de Evaluaciones: {$row['listado_evaluaciones']}</p>
                        <p>Correo Electrónico: <a href='mailto:{$row['correo_docente']}'>{$row['correo_docente']}</a></p>
                        <!-- Agrega más información según sea necesario -->
                    </section>

                    <!-- Puedes agregar más secciones según sea necesario -->

                    <!-- Llamada a la acción -->
                    <section class='custom-section'>
                        <p>¡No te pierdas la oportunidad de trabajar conmigo! Contáctame ahora para discutir cómo puedo contribuir a tu equipo.</p>
                        <p>¡Espero saber de ti pronto!</p>
                        <a href='mailto:{$row['correo_docente']}'>Contactar Ahora</a>
                    </section>

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
            $email->Subject = "Carta de Presentación";
            $email->isHTML(true);
            $email->Body = $htmlContent;

            $email->send();
            echo "Correo enviado a {$row['correo_docente']} con éxito<br>";
        } catch (Exception $e) {
            echo 'Error al enviar el correo a {$row["correo_docente"]}: ' . $e->getMessage() . "<br>";
        }
    } else {
        // Mostrar el estado actual del correo electrónico
        echo "Cargando..."; // Este es solo un ejemplo, puedes personalizarlo según tus necesidades
    }

    echo "</td>
        </tr>";
}

echo "</table>";

// Cerrar la conexión a la base de datos
$conn->close();
?>
