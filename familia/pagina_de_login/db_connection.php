<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pagina_de_login';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
