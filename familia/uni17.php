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
            Profesores.id_profesor,
            Profesores.nombre AS nombre_profesor,
            Profesores.apellido,
            Profesores.correo,
            Profesores.edad,
            Profesores.fecha,
            Profesores.hora,
            Cursos.nombre AS nombre_curso,
            Sesiones.seccion,
            GROUP_CONCAT(CONCAT(Estudiantes.nombre, ' ', Estudiantes.apellido) SEPARATOR ', ') AS estudiantes,
            Sesiones.dia AS fecha_sesion,
            Sesiones.hora AS hora_sesion,
            Evaluaciones.nombre_evaluacion,
            Evaluaciones.fecha AS fecha_evaluacion,
            Evaluaciones.hora AS hora_evaluacion
        FROM 
            Profesores
        INNER JOIN Sesiones ON Profesores.id_profesor = Sesiones.id_profesor
        INNER JOIN Cursos ON Sesiones.id_curso = Cursos.id_curso
        INNER JOIN Estudiantes ON Sesiones.id_estudiante = Estudiantes.id_estudiante
        INNER JOIN Evaluaciones ON Cursos.id_curso = Evaluaciones.id_curso
        GROUP BY 
            Profesores.id_profesor,
            Profesores.nombre,
            Profesores.apellido,
            Profesores.correo,
            Profesores.edad,
            Profesores.fecha,
            Profesores.hora,
            Cursos.nombre,
            Sesiones.seccion,
            Sesiones.dia,
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
        $nombre = $row['nombre_profesor'] . ' ' . $row['apellido'];
        $correo = $row['correo'];
        $edad = $row['edad'];
        $fecha = $row['fecha'];
        $hora = $row['hora'];
        $nombre_curso = $row['nombre_curso'];
        $seccion = $row['seccion'];
        $estudiantes = $row['estudiantes'];
        $fecha_sesion = $row['fecha_sesion'];
        $hora_sesion = $row['hora_sesion'];
        $nombre_evaluacion = $row['nombre_evaluacion'];
        $fecha_evaluacion = $row['fecha_evaluacion'];
        $hora_evaluacion = $row['hora_evaluacion'];

        $currentDateTime = new DateTime();
        $taskDateTime = new DateTime($fecha . ' ' . $hora);
        $interval = $currentDateTime->diff($taskDateTime);
        $timeLeft = $interval->format('%R%a días %H horas %I minutos %S segundos');

        $table .= "<tr>
                    <td>{$id_profesor}</td>
                    <td>{$nombre}</td>
                    <td>{$correo}</td>
                    <td>{$edad}</td>
                    <td>{$fecha}</td>
                    <td>{$hora}</td>
                    <td>";

        if ($timeLeft[0] === '-') {
            // Si el tiempo restante es negativo, significa que la fecha y hora ya han pasado
            $table .= "El correo fue enviado el {$fecha} a las {$hora}<br>";
        } elseif ($timeLeft === '+0 días 00 horas 00 minutos 00 segundos') {
            // Si el tiempo restante es cero y el correo aún no se ha enviado
            // Contenido del correo electrónico
            $htmlContent = "<!DOCTYPE html>
            <html>
            <head>
                <title>Bienvenido al ciclo 2022-1</title>
                <meta charset='UTF-8'>
                <style>
                    /* Estilos CSS para el diseño del mensaje */
                    .container {
                        font-family: Arial, sans-serif;
                        background-color: #ffffff;
                        padding: 20px;
                        width: 100%;
                        max-width: 600px;
                        margin: 20px auto;
                        border: 2px solid maroon;
                        border-radius: 10px;
                        text-align: center;
                    }
                    /*------------encabezado-------------*/
                    .encabezado {
                        background-color: rgb(230, 217, 170);
                        padding: 10px;
                        display: flex;
                        align-items: center; /* Alinea verticalmente el texto y la imagen */
                        font-weight: bold;
                        font-size: 24px;
                        margin-bottom: 20px;
                        border-radius: 10px;
                        text-align: left; /* Alineación del texto a la izquierda dentro del encabezado */
                    }
            
                    .texto-uni-orce {
                        font-size: 48px;
                        font-weight: bold;
                        text-transform: uppercase;
                        margin-right: 20px;
                        color: #711610
                    }
                    /* Estilos para la imagen dentro del encabezado */
                    .img-container {
                        float: right; /* Alineación a la derecha */
                        margin-left: auto;
                        width: 90px; /* Ancho de la imagen */
                        margin-right: 20px; /* Espacio entre la imagen y el contenido adyacente */
                    }
            
                    .imagen {
                        width: 90px; /* Ancho de la imagen */
                        max-width: 100px;/* Ajusta el tamaño de la imagen según sea necesario */
                        margin-left: auto; /* Empuja la imagen a la derecha */
                    }
                    /*------------content-------------*/
                    .content {
                        background-color: white;
                        padding: 20px;
                        color: #711610
                    }
                    .contenedor_invisible {
                        display: flex;
                        justify-content: flex-end; /* Alinea el contenido a la derecha */
                    }
                    .pie_de_página {
                        background-color: rgb(230, 217, 170);
                        border-radius: 10px;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <!-- Encabezado -->
                    <div class='encabezado'>
                        <div class='texto-uni-orce' style='display: inline-block;'>
                            UNI<br>ORCE
                        </div>
                        <img class='img-container' src='https://i.postimg.cc/pL366K17/imagen1.png' alt='imagen1.png'>
                    </div>
                    <!-- Contenido -->
                    <div class='content'>
                        <h2>Bienvenido {$nombre}</h2>
                        <p>al ciclo 2022-1</p>
                        <p>{$nombre_curso} - {$seccion}</p>
                        <h3>Listado de estudiantes</h3>
                        <p>{$estudiantes}</p>
                        <p>Donde cargar su material</p>
                        <h3>Listado de sesiones</h3>
                        <table border='1'>
                            <tr>
                                <th>Sección</th>
                                <th>Fecha de sesión</th>
                                <th>Hora de sesión</th>
                            </tr>
                            <tr>
                                <td>{$seccion}</td>
                                <td>{$fecha_sesion}</td>
                                <td>{$hora_sesion}</td>
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
                                <td>{$nombre_evaluacion}</td>
                                <td>{$fecha_evaluacion}</td>
                                <td>{$hora_evaluacion}</td>
                            </tr>
                        </table>
                    </div>
                    <!-- Pie de página -->
                    <div class='pie_de_página'>
                        <!-- Dirección -->
                        <div class='contenedor_invisible'>
                            <div class='text_direccion' style='text-align: right;'>
                                <p style='text-align: left;'>Contacto</p>
                                <p style='text-align: left;'>Av. Túpac Amaru 210 - Rímac.</p>
                                <p style='text-align: left;'>Apartado 1301. Lima - Perú</p>
                                <p style='text-align: left;'>Telf.: 4811070</p>
                            </div>
                        </div>
                        <!-- Texto -->
                        <div class='text' style='display: block; text-align: center;'>
                            <p>2022 © Derechos Reservados</p>
                        </div>
                    </div>        
                </div>
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

if ($result->num_rows > 0) {
    echo obtenerTablaProfesores($result);
} else {
    echo "No se encontraron profesores.";
}

$conn->close();
?>
