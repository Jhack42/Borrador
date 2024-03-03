<?php
// Establecer la zona horaria del sistema operativo Windows
date_default_timezone_set('America/Lima'); // Ajusta la zona horaria según tu ubicación

require 'vendor/autoload.php'; // Incluir el autoload de PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Conexión a la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'seguimiento');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener la hora actual del sistema operativo Windows
$hora_actual = date("H:i:s");

// Consulta para obtener los datos de los profesores programados para enviar correos
$sql = "SELECT id_profesor, nombre, apellido, correo, fecha, hora FROM Profesores WHERE fecha = CURDATE() AND hora <= CURTIME()";
$result = $conn->query($sql);

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    require 'vendor/autoload.php'; // Incluir el autoload de PHPMailer

    $fromEmail = "1364822@senati.pe"; // Dirección de correo electrónico del remitente
    $smtpHost = 'smtp-mail.outlook.com'; // Host del servidor SMTP de Outlook
    $smtpUsername = $fromEmail; // Nombre de usuario SMTP (correo electrónico del remitente)
    $smtpPassword = 'JC221101f'; // Contraseña SMTP (del correo electrónico del remitente)
    $smtpPort = 587; // Puerto SMTP
    $smtpSecure = 'tls'; // Tipo de cifrado TLS


    // Iterar sobre los resultados y enviar correos electrónicos
    while ($row = $result->fetch_assoc()) {
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
                        <p>Nombre: {$row['nombre']} {$row['apellido']}</p>
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

            $email->setFrom($smtpUsername);
            $email->addAddress($row['correo']);
            $email->CharSet = 'UTF-8';
            $email->Subject = "Carta de Presentación";
            $email->isHTML(true);
            $email->Body = $htmlContent;

            $email->send();
            echo "Correo enviado a {$row['correo']} con éxito<br>";
        } catch (Exception $e) {
            echo 'Error al enviar el correo a {$row["correo"]}: ' . $e->getMessage() . "<br>";
        }
    }
} else {
    echo "No hay profesores programados para enviar correos en este momento.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
