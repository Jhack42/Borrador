<?php
// Conexión a la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'seguimiento');

$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conexion->connect_error) {
    die("Error al conectar a la base de datos: " . $conexion->connect_error);
}

// Consulta para obtener los datos del profesor, curso, estudiantes, sesiones y evaluaciones
$query = "
    SELECT Profesores.nombre AS nombre_profesor, 
           Cursos.nombre AS nombre_curso, 
           Sesiones.seccion, 
           Estudiantes.nombre AS nombre_estudiante, 
           Estudiantes.apellido AS apellido_estudiante, 
           Sesiones.dia AS fecha_sesion, 
           Sesiones.hora AS hora_sesion, 
           Evaluaciones.nombre_evaluacion, 
           Evaluaciones.fecha AS fecha_evaluacion, 
           Evaluaciones.hora AS hora_evaluacion
    FROM Profesores
    JOIN Sesiones ON Profesores.id_profesor = Sesiones.id_profesor
    JOIN Cursos ON Sesiones.id_curso = Cursos.id_curso
    JOIN Estudiantes ON Sesiones.id_estudiante = Estudiantes.id_estudiante
    JOIN Evaluaciones ON Cursos.id_curso = Evaluaciones.id_curso";
    
$result = $conexion->query($query);

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Incluir la clase de PHPMailer
    require 'vendor/autoload.php';
    

    $fromEmail = "1364822@senati.pe"; // Dirección de correo electrónico del remitente
    $smtpHost = 'smtp-mail.outlook.com'; // Host del servidor SMTP de Outlook
    $smtpUsername = $fromEmail; // Nombre de usuario SMTP (correo electrónico del remitente)
    $smtpPassword = 'JC221101f'; // Contraseña SMTP (del correo electrónico del remitente)
    $smtpPort = 587; // Puerto SMTP
    $smtpSecure = 'tls'; // Tipo de cifrado TLS


    // Crear instancia de PHPMailer
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    // Configurar el envío de correo
    $mail->isSMTP();
    $mail->Host = $smtpHost;
    $mail->SMTPAuth = true;
    $mail->Username = $smtpUsername;
    $mail->Password = $smtpPassword;
    $mail->Port = $smtpPort;
    $mail->SMTPSecure = $smtpSecure;

    // Establecer detalles del mensaje
    $mail->setFrom($smtpUsername);
    $mail->Subject = 'Detalles del seguimiento';

    // Comenzar a construir el contenido del correo
    $message = "Detalles del seguimiento:<br>";

    // Recorrer los resultados de la consulta y agregar detalles al mensaje
    while ($row = $result->fetch_assoc()) {
        $message .= "Profesor: {$row['nombre_profesor']}<br>";
        $message .= "Curso: {$row['nombre_curso']} - Sección: {$row['seccion']}<br>";
        $message .= "Estudiante: {$row['nombre_estudiante']} {$row['apellido_estudiante']}<br>";
        $message .= "Fecha de sesión: {$row['fecha_sesion']} - Hora: {$row['hora_sesion']}<br>";
        $message .= "Evaluación: {$row['nombre_evaluacion']} - Fecha: {$row['fecha_evaluacion']} - Hora: {$row['hora_evaluacion']}<br>";
        $message .= "<br>";
    }

    // Establecer el contenido del mensaje
    $mail->isHTML(true);
    $mail->Body = $message;

    // Dirección de correo electrónico de destino
    $mail->addAddress('destinatario@dominio.com');

    // Enviar correo electrónico
    if ($mail->send()) {
        echo 'Correo electrónico enviado con éxito';
    } else {
        echo 'Error al enviar el correo electrónico: ' . $mail->ErrorInfo;
    }
} else {
    echo "No se encontraron resultados.";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
