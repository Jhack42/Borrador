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
define('DB_NAME', 'programar_tarea_mysql5');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener las tareas programadas
$sql = "SELECT id, fecha, hora, nombres, apellidos, dni, carrera, correo FROM tareas_programadas";
$result = $conn->query($sql);

// Mostrar resultados en la tabla y enviar correos si es necesario
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>DNI</th>
            <th>Carrera</th>
            <th>Correo</th>
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
            <td>{$row['nombres']}</td>
            <td>{$row['apellidos']}</td>
            <td>{$row['dni']}</td>
            <td>{$row['carrera']}</td>
            <td>{$row['correo']}</td>
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
                </head>
                <body>

                <div class='custom-section'>
                    <h2 class='card-title'>¡Descubre lo Mejor de Mí!</h2>

                    <!-- Datos Personales -->
                    <section class='custom-section'>
                        <h3 class='text-info'>Datos Personales</h3>
                        <p>Nombre: {$row['nombres']} {$row['apellidos']}</p>
                        <p>DNI: {$row['dni']}</p>
                        <p>Carrera: {$row['carrera']}</p>
                        <p>Correo Electrónico: <a href='mailto:{$row['correo']}'>{$row['correo']}</a></p>
                        <!-- Agrega más información según sea necesario -->
                    </section>

                    <!-- Puedes agregar más secciones según sea necesario -->

                    <!-- Llamada a la acción -->
                    <section class='custom-section'>
                        <p>¡No te pierdas la oportunidad de trabajar conmigo! Contáctame ahora para discutir cómo puedo contribuir a tu equipo.</p>
                        <p>¡Espero saber de ti pronto!</p>
                        <a href='mailto:{$row['correo']}'>Contactar Ahora</a>
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
            $email->addAddress($row['correo']);
            $email->Subject = "Carta de Presentación";
            $email->isHTML(true);
            $email->Body = $htmlContent;

            $email->send();
            echo "Correo enviado a {$row['correo']} con éxito<br>";
        } catch (Exception $e) {
            echo 'Error al enviar el correo a {$row["correo"]}: ' . $e->getMessage() . "<br>";
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
