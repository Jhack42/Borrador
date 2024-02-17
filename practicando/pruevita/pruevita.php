<?php
// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $edad = (int)$_POST['edad'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saludo</title>
    <style>
        /* Aquí puedes añadir estilos CSS si lo deseas */
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
    </style>
</head>
<body>

<div class="container">
    <!-- Saludo HTML -->
    <p>Hola <?php echo $nombre; ?>. Usted tiene <?php echo $edad; ?> años.</p>
</div>

</body>
</html>

<?php
} else {
    // Muestra el formulario si no se ha enviado
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <style>
        /* Aquí puedes añadir estilos CSS si lo deseas */
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
    </style>
</head>
<body>

<div class="container">
    <!-- Formulario HTML -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <p>Su nombre: <input type="text" name="nombre" /></p>
        <p>Su edad: <input type="text" name="edad" /></p>
        <p><input type="submit" /></p>
    </form>
</div>

</body>
</html>

<?php
}
?>