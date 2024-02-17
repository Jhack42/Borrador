<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas Programadas</title>
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
        <a href="#" class="active" id="link_actualizar">Actualizar Tareas</a>
        <a href="#" id="link_otro_archivo">Mostrar Otro Archivo</a>
    </div>

    <!-- Contenido dinámico -->
    <div id="contenido_dinamico">
        <!-- Aquí se mostrará el contenido dinámico -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Función para cargar dinámicamente el contenido de una página
            function cargarContenidoPagina(url) {
                $.ajax({
                    url: url, // URL de la página a cargar
                    type: "GET",
                    success: function(data) {
                        $("#contenido_dinamico").html(data); // Actualizar el contenido dinámico
                    }
                });
            }

            // Manejar clic en el enlace "Actualizar Tareas"
            $("#link_actualizar").click(function(event) {
                event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace
                cargarContenidoPagina("actualizar_tareas.php"); // Cargar el contenido de actualizar_tareas.php
            });

            // Manejar clic en el enlace "Mostrar Otro Archivo"
            $("#link_otro_archivo").click(function(event) {
                event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace
                cargarContenidoPagina("prueva5.html"); // Cargar otro archivo
            });

            // Cargar el contenido de actualizar_tareas.php por defecto
            cargarContenidoPagina("actualizar_tareas.php");
        });
    </script>
</body>
</html>
