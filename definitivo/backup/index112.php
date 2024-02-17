<?php
// Conexión a la base de datos
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "prueba";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los datos de los docentes
$sqlDocentes = "SELECT * FROM Docentes";
$resultDocentes = $conn->query($sqlDocentes);

// Consulta para obtener las relaciones de otras tablas con DocenteID
$relatedTables = array("Sesiones", "Evaluaciones"); // Agrega más tablas según sea necesario

if ($resultDocentes->num_rows > 0) {
    while ($rowDocente = $resultDocentes->fetch_assoc()) {
        $docenteID = $rowDocente["DocenteID"];
        // Insertar datos del docente en la tabla InformacionDocente
        $insertQuery = "INSERT INTO InformacionDocente (DocenteID, Nombres, Apellidos, Direccion, Telefono) 
                        VALUES ('".$rowDocente["DocenteID"]."', '".$rowDocente["Nombres"]."', '".$rowDocente["Apellidos"]."', '".$rowDocente["Direccion"]."', '".$rowDocente["Telefono"]."')";
        $conn->query($insertQuery);
        // Insertar relaciones de otras tablas en la tabla InformacionDocente
        foreach ($relatedTables as $table) {
            $relatedSql = "SELECT * FROM $table WHERE DocenteID = $docenteID";
            $relatedResult = $conn->query($relatedSql);
            if ($relatedResult->num_rows > 0) {
                while ($relatedRow = $relatedResult->fetch_assoc()) {
                    // Insertar datos relacionados en la tabla InformacionDocente
                    $insertRelatedQuery = "INSERT INTO InformacionDocente (DocenteID, OtraTablaID, OtroCampo) 
                                            VALUES ('$docenteID', '".$relatedRow["OtraTablaID"]."', '".$relatedRow["OtroCampo"]."')";
                    $conn->query($insertRelatedQuery);
                }
            }
        }
    }
} else {
    echo "No se encontraron docentes";
}

$conn->close();
?>

