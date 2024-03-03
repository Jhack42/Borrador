<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="administrador_style.css">
</head>
<body>
    <h1>Panel de Administrador</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Correo</th>
            <th>Nombre</th>
            <th>Foto de Perfil</th> <!-- Agregamos una nueva columna para la foto de perfil -->
            <!-- Otros campos que desees mostrar -->
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['correo']; ?></td>
            <td><?php echo $row['nombre']; ?></td>
            <td><img src="imagen/<?php echo $row['foto_perfil']; ?>" alt="Foto de perfil" style="width: 100px;"></td> <!-- Mostrar la imagen -->
            <!-- Puedes ajustar el tamaño de la imagen según tus necesidades -->
            <!-- Mostrar otros campos -->
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>
