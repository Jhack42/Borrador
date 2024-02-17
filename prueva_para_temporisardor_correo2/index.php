<!DOCTYPE html>
<html>
<head>
    <title>Programar Tarea</title>
</head>
<body>
    <h1>Programar Tarea</h1>
    <form action="guardar_tarea.php" method="post">
        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" required><br>
        <label for="hora">Hora:</label>
        <input type="time" name="hora" required><br>
        <label for="tarea_nombre">Nombre de Tarea:</label>
        <input type="text" name="tarea_nombre" required><br>
        <label for="script_path">Ruta del Script:</label>
        <input type="text" name="script_path" required><br>
        <label for="destinatario">Correo del Destinatario:</label>
        <input type="email" name="destinatario" required><br>
        <input type="submit" value="Programar Tarea">
    </form>
</body>
</html>
