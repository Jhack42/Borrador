<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas Programadas</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Función para actualizar dinámicamente el contenido de la tabla
            function actualizarContenido(archivo) {
                $.ajax({
                    url: archivo,
                    type: "GET",
                    success: function(data) {
                        $("#tabla_tareas").html(data); // Actualizar el contenido de la tabla
                    }
                });
            }

            // Manejar el clic en los elementos de navegación
            $(".nav-item").click(function() {
                var archivo = $(this).data("archivo");
                actualizarContenido(archivo);

                // Desactivar la clase 'active' de todos los elementos de navegación
                $(".nav-item").removeClass("active");

                // Activar la clase 'active' solo en el elemento clicado
                $(this).addClass("active");
            });

            // Por defecto, cargar "actualizar_tareas.php" al iniciar la página
            actualizarContenido("actualizar_tareas.php");

        });
    </script>
    <style>
        .navbar {
            background-color: #333;
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .navbar a.active {
            background-color: #666;
            color: white;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a class="nav-item active" data-archivo="actualizar_tareas.php">Actualizar Tareas</a>
        <a class="nav-item" data-archivo="actualizar_tareas.php">Otro Archivo</a>
        <a class="nav-item" data-archivo="actualizar_tareas.php">Tercer Archivo</a>
    </div>
    <h1>Tareas Programadas</h1>
    <div id="tabla_tareas">
        <!-- Aquí se mostrará dinámicamente el contenido de la tabla -->
    </div>
</body>
</html>
