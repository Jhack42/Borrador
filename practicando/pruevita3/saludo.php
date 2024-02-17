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
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <!-- Saludo HTML -->
    <p>Hola <?php echo $nombre; ?>. Usted tiene <?php echo $edad; ?> años.</p>
</div>

</body>
</html>

<?php
}
?>
