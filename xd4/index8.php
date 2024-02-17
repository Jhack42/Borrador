<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas Programadas</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Función para actualizar dinámicamente el contenido de la primera tabla
            function actualizarContenidoTabla1() {
                $.ajax({
                    url: "actualizar_tareas.php", // Archivo PHP que maneja la lógica de actualización
                    type: "GET",
                    success: function(data) {
                        $("#tabla_tareas_1").html(data); // Actualizar el contenido de la primera tabla
                    }
                });
            }

            // Función para actualizar dinámicamente el contenido de la segunda tabla
            function actualizarContenidoTabla2() {
                $.ajax({
                    url: "actualizar_tareas.php", // Archivo PHP que maneja la lógica de actualización
                    type: "GET",
                    success: function(data) {
                        $("#tabla_tareas_2").html(data); // Actualizar el contenido de la segunda tabla
                    }
                });
            }

            // Actualizar el contenido de la primera tabla cada 1 segundo
            setInterval(actualizarContenidoTabla1, 1000); // 1000 milisegundos = 1 segundo

            // Actualizar el contenido de la segunda tabla cada 1 segundo
            setInterval(actualizarContenidoTabla2, 1000); // 1000 milisegundos = 1 segundo
        });
    </script>
</head>
<body>
    <h1>Tareas Programadas</h1>
    <div id="tabla_tareas_1">
        <!-- Aquí se mostrará dinámicamente el contenido de la primera tabla -->
    </div>
    <div id="tabla_tareas_2">
        <!-- Aquí se mostrará dinámicamente el contenido de la segunda tabla -->
    </div>
</body>
</html>
