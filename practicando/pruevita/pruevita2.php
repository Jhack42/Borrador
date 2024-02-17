<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario y Saludo</title>
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/7263/7263747.png" type="image/x-icon">
    <style>
        /* Estilos CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
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

<script>
document.getElementById('saludoForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita que se envíe el formulario por defecto
    
    // Obtiene los valores del formulario
    var nombre = document.getElementById('nombre').value;
    var edad = document.getElementById('edad').value;
    
    // Muestra el saludo
    var saludoTexto = document.getElementById('saludoTexto');
    saludoTexto.textContent = 'Hola ' + nombre + '. Usted tiene ' + edad + ' años.';
    
    // Muestra el contenedor del saludo y oculta el formulario
    document.getElementById('form-container').style.display = 'none';
    document.getElementById('saludo-container').style.display = 'block';
});
</script>

</body>
</html>
