<!DOCTYPE html>
<html>
<head>
    <title>Programar Tarea</title>
</head>
<body>
    <h1>Programar Tarea</h1>
    <form action="enviar_email.php" method="post">
        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" required><br>
        <label for="hora">Hora:</label>
        <input type="time" name="hora" required><br>
        <input type="submit" value="Programar Tarea">
    </form>
</body>
</html>
