<?php
// Conexión a la base de datos (reemplaza con tus propios datos)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calendar";

// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Procesa los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $descripcion = $_POST['descripcion'];

    // Inserta los datos en la base de datos
    $sql = "INSERT INTO eventos (titulo, fecha_inicio, fecha_fin, descripcion)
            VALUES ('$titulo', '$fecha_inicio', '$fecha_fin', '$descripcion')";

    if ($conn->query($sql) === TRUE) {
        echo "Evento creado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Cierra la conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Eventos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label, input, textarea {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
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
        <div class="container">
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
