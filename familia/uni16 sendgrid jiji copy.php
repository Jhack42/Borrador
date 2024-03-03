<?php
header('Content-Type: text/html; charset=utf-8');

// Establecer la zona horaria del sistema operativo Windows
date_default_timezone_set('America/Lima');

// Obtener la hora actual del sistema operativo Windows
$hora_actual = date("H:i:s");

echo "Hora actual del sistema operativo Windows: $hora_actual<br><br>";

// Requiere la librería de SendGrid
require 'vendor/autoload.php'; 

use SendGrid\Mail\Mail;
use SendGrid\Mail\TypeException;
use SendGrid\Mail\From;

// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "seguimiento";

// Conexión a la base de datos
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
    // Reemplaza 'tu-api-key' con tu propia clave API de SendGrid
    $apiKey = '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';

    $email = new Mail();
    $email->setFrom(new From("1364822@senati.pe", "UNI-ORCE")); // Cambia el correo y el nombre del remitente según tus necesidades
    $email->addTo($correo); // Agrega el destinatario
    $email->setSubject('Datos Personales');
    $email->addContent("text/html", $htmlContent);

    $sendgrid = new \SendGrid($apiKey);
    try {
        $response = $sendgrid->send($email);
        if ($response->statusCode() == 202) {
            return true; // Correo enviado con éxito
        } else {
            return "Error al enviar el correo. Código de estado: " . $response->statusCode();
        }
    } catch (TypeException $e) {
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
                        /*margin-bottom: 20px;*/
                        border-radius: 10px;
                        text-align: left; /* Alineación del texto a la izquierda dentro del encabezado */
                    }
            
                    .texto-uni-orce {
                        margin-left: 19px;
                        font-size: 48px;
                        font-weight: bold;
                        text-transform: uppercase;
                        margin-right: 20px;
                        color: #711610
                    }
                    /* Estilos para la imagen dentro del encabezado */
                    /* Estilos para la imagen dentro del encabezado */
                    .img-container {
                        margin-top: auto;
                        /*float: left; /* Alineación a la derecha */
                        margin-bottom: auto;
                        margin-left: auto;
                        width: 24%; /* Ancho de la imagen al 100% del contenedor en pantallas pequeñas */
                        /*width: 120px;  Ancho de la imagen */
                        margin-right: 19px; /* Espacio entre la imagen y el contenido adyacente */
                    }
                    table {
                        border-collapse: collapse;
                        width: 100%;
                        border-radius: 10px; /* Añade bordes redondeados a toda la tabla */
                        border-color: aqua;
                        overflow: hidden; /* Asegura que los bordes redondeados se apliquen correctamente */
                    }

                    th, td {
                        border: 1px solid maroon;
                        text-align: left;
                        padding: 8px;
                    }

                    th {
                        background-color: rgb(230, 217, 170);
                    }

                    tr:nth-child(even) {
                        background-color: #ffffff;
                    }
                    /*------------content-------------*/
                    .content {
                        background-color: white;
                        padding: 20px;
                        color: #711610
                    }
                    .contenedor_invisible {
                        margin-top: auto;
                        margin-bottom: auto;
                        margin-left: auto;
                        display: flex;
                        justify-content: flex-end; /* Alinea el contenido a la derecha */
                    }
                    .pie_de_página {
                        background-color: rgb(230, 217, 170);
                        border-radius: 10px;
                        padding: 10px; /* Añade un padding de 5px al pie de página */
                    }
                    .text_direccion {
                        margin-top: auto;
                        margin-bottom: auto;
                        margin-left: auto;
                        text-align: right;
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
                        <!-- <img class='img-container' src='https://i.imgur.com/ON5gjNa.png' alt='imagen1.png'> -->
                        <!-- <img class='img-container' src='https://tinypic.host/images/2024/03/02/unnamed-1.png' alt='imagen1.png'> -->
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
                        <div class='text_direccion' style='text-align: right; margin-top: auto; margin-bottom: auto; margin-left: auto;'>
                                <p style='text-align: left; font-size: 12px;'>Contacto</p>
                                <p style='text-align: left; font-size: 12px;'>Av. Túpac Amaru 210 - Rímac.</p>
                                <p style='text-align: left; font-size: 12px;'>Apartado 1301. Lima - Perú</p>
                                <p style='text-align: left; font-size: 12px;'>Telf.: 4811070</p>
                            </div>
                        </div>
                        <!-- Texto -->
                        <div class='text' style='display: block; text-align: center;'>
                            <p style='font-size: 12px;'>2022 © Derechos Reservados</p>
                        </div>
                    </div>
                    
                    <!-- Texto -->
    
                </div>
            </body>
            </html>"; 

            // Envío del correo electrónico
            $enviado = enviarCorreo($correo, $htmlContent);
            if ($enviado === true) {
                $table .= "Correo enviado con éxito";
            } else {
                $table .= "Error al enviar el correo: $enviado";
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
