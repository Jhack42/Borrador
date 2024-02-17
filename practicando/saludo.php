<?php
// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $edad = (int)$_POST['edad'];
?>

<!-- Saludo HTML -->
<p>Hola <?php echo $nombre; ?>. Usted tiene <?php echo $edad; ?> años.</p>

<?php
} else {
    // Muestra el formulario si no se ha enviado
    include 'formulario.php';
}
?>
