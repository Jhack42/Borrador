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
        <!-- Agregar más campos según sea necesario -->
        
        <input type="submit" value="Programar Tarea">
    </form>
</body>
</html>
