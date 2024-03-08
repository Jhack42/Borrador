<?php
session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

$correo = $_SESSION['correo'];
$row = []; // Inicializamos $row para evitar los errores de advertencia

// Consulta para obtener los datos del usuario
$sql_usuario = "SELECT * FROM usuarios WHERE correo='$correo'";
$resultado_usuario = $conn->query($sql_usuario);

if ($resultado_usuario->num_rows > 0) {
    // Si se encontraron resultados, asignamos los datos del usuario a $row
    $row = $resultado_usuario->fetch_assoc();
}

// Verifica si se ha enviado un archivo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["foto_perfil"])) {
    $target_directory = "uploads/"; // Directorio donde se guardarán las fotos de perfil
    $target_file = $target_directory . basename($_FILES["foto_perfil"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verifica si el archivo es una imagen real
    $check = getimagesize($_FILES["foto_perfil"]["tmp_name"]);
    if ($check === false) {
        $uploadOk = 0;
    }

    // Verifica si el archivo ya existe
    if (file_exists($target_file)) {
        echo "Lo siento, el archivo ya existe.";
        $uploadOk = 0;
    }

    // Verifica el tamaño del archivo
    if ($_FILES["foto_perfil"]["size"] > 500000) {
        echo "Lo siento, tu archivo es demasiado grande.";
        $uploadOk = 0;
    }

    // Permite solo ciertos formatos de archivo
    $allowed_extensions = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_extensions)) {
        echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
        $uploadOk = 0;
    }

    // Verifica si $uploadOk está configurado en 0 por un error
    if ($uploadOk == 0) {
        echo "Lo siento, tu archivo no fue subido.";
    } else {
        // Si todo está bien, intenta subir el archivo
        if (move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $target_file)) {
            // Guarda la ruta de la imagen en la base de datos
            $ruta_imagen = $target_file;
            $sql_update = "UPDATE usuarios SET foto_perfil='$ruta_imagen' WHERE correo='$correo'";
            if ($conn->query($sql_update) === TRUE) {
                echo "¡La foto de perfil se ha subido correctamente!";
            } else {
                echo "Error al actualizar la foto de perfil: " . $conn->error;
            }
        } else {
            echo "Lo siento, hubo un error al subir tu archivo.";
        }
    }
}

// Consulta para obtener los eventos
$sql_eventos = "SELECT * FROM eventos";
$resultado_eventos = $conn->query($sql_eventos);

// Crear un array para almacenar los eventos
$eventos = [];

while ($row_evento = $resultado_eventos->fetch_assoc()) {
    $evento = [
        'title' => $row_evento['titulo'],
        'start' => $row_evento['fecha_inicio'],
        'end' => $row_evento['fecha_fin'],
        'description' => $row_evento['descripcion']
    ];
    array_push($eventos, $evento);
}

// Convertir el array de eventos a formato JSON
$json_eventos = json_encode($eventos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
    <link href='lib/fullcalendar/main.css' rel='stylesheet' />
    <script src='lib/moment/main.min.js'></script>
    <script src='lib/jquery/main.min.js'></script>
    <script src='lib/fullcalendar/main.min.js'></script>
    <link rel="stylesheet" href="css/style_perfil.css">
</head>
<body>
    <div class="container">
        <h2>Perfil del Usuario</h2>
        <div class="perfil-info">
            <p><strong>Nombre:</strong> <?php echo $row['nombre']; ?></p>
            <p><strong>Correo electrónico:</strong> <?php echo $row['correo']; ?></p>
            <!-- Mostrar la foto de perfil si está disponible -->
            <?php if (!empty($row['foto_perfil'])) { ?>
                <img src="imagen/<?php echo $row['foto_perfil']; ?>" alt="Foto de perfil">
            <?php } else { ?>
                <p>No hay foto de perfil</p>
            <?php } ?>
            <!-- Agrega más información del perfil aquí si es necesario -->
        </div>
        <div class="editar-perfil">
            <a href="editar_perfil.php">Editar perfil</a>
            <!-- Agrega un enlace para permitir al usuario editar su perfil -->
        </div>
        <div class="cambiar-contraseña">
            <a href="cambiar_contraseña.php">Cambiar contraseña</a>
            <!-- Agrega un enlace para permitir al usuario cambiar su contraseña -->
        </div>
        <div class="logout">
            <a href="logout.php">Cerrar sesión</a>
            <!-- Agrega un enlace para permitir al usuario cerrar sesión -->
        </div>

        <!-- Agregar en el cuerpo de tu página de perfil del usuario -->
        <div id='calendar'></div>

    <!-- Formulario de registro de eventos -->
    <div class="container" id="registro-eventos">
        <h2>Registro de Eventos</h2>
        <form action="insertar_evento.php" method="post">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" required>

            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="datetime-local" id="fecha_fin" name="fecha_fin" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4"></textarea>

            <input type="submit" value="Registrar Evento">
        </form>
    </div>

    </div>

    <!-- Incluir FullCalendar y sus dependencias -->
    <link href='lib/fullcalendar/main.css' rel='stylesheet' />
    <script src='lib/moment/main.min.js'></script>
    <script src='lib/jquery/main.min.js'></script>
    <script src='lib/fullcalendar/main.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: <?php echo $json_eventos; ?>,
            });

            calendar.render();
        });
    </script>
</body>

</html>
