<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uni3</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="contenido_dinamico">
        <!-- Aquí se cargará el contenido dinámico -->
    </div>

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

            // Cargar el contenido inicialmente y luego cada segundo
            cargarContenidoPagina("uni18 copy.php");
            setInterval(function() {
                cargarContenidoPagina("uni18 copy.php");
            }, 1000); // 1000 milisegundos = 1 segundo
        });
    </script>
</body>
</html>
