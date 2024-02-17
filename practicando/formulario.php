<!-- Formulario HTML -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <p>Su nombre: <input type="text" name="nombre" /></p>
    <p>Su edad: <input type="text" name="edad" /></p>
    <p><input type="submit" /></p>
</form>
