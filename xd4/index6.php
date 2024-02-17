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
            function actualizarContenido() {
                $.ajax({
                    url: "actualizar_tareas.php", // Archivo PHP que maneja la lógica de actualización
                    type: "GET",
                    success: function(data) {
                        $("#tabla_tareas").html(data); // Actualizar el contenido de la tabla
                    }
                });
            }

            // Actualizar el contenido cada 1 segundo
            setInterval(actualizarContenido, 1000); // 1000 milisegundos = 1 segundo
        });
    </script>
</head>
<body>
    <h1>Tareas Programadas</h1>
    <div id="tabla_tareas">
        <!-- Aquí se mostrará dinámicamente el contenido de la tabla -->
    </div>
</body>
</html>
