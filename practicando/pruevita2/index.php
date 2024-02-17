<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container" id="form-container">
    <!-- Formulario HTML -->
    <form id="saludoForm">
        <p>Su nombre: <input type="text" id="nombre" /></p>
        <p>Su edad: <input type="text" id="edad" /></p>
        <p><input type="submit" value="Enviar" /></p>
    </form>
</div>

<div class="container" id="saludo-container" style="display: none;">
    <!-- Saludo HTML -->
    <p id="saludoTexto"></p>
</div>

<script src="script.js"></script>
</body>
</html>
