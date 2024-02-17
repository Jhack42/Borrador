<?php
// Conexión a la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'prueba');

// Establecer conexión con la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Consulta SQL para seleccionar todos los registros de la tabla InformacionDocente
$docenteID = 1; // Reemplaza esto con el ID del docente que deseas consultar

$sql = "SELECT 
            ID,
            Docentes.Nombres AS NombreDocente,
            Docentes.Apellidos AS ApellidoDocente,
            Evaluaciones.EvaluacionID,
            Inscripciones.InscripcionID,
            OfertaAcademica.OfertaID
        FROM 
            InformacionDocente
        LEFT JOIN 
            Docentes ON InformacionDocente.DocenteID = Docentes.DocenteID
        LEFT JOIN 
            Evaluaciones ON InformacionDocente.EvaluacionID = Evaluaciones.EvaluacionID
        LEFT JOIN 
            Inscripciones ON InformacionDocente.InscripcionID = Inscripciones.InscripcionID
        LEFT JOIN 
            OfertaAcademica ON InformacionDocente.OfertaID = OfertaAcademica.OfertaID
        WHERE 
            InformacionDocente.DocenteID = $docenteID";

// Ejecutar la consulta
$resultado = $conexion->query($sql);

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    // Mostrar los datos obtenidos
    echo "<h2>Información del Docente</h2>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nombre Docente</th>
                <th>Apellido Docente</th>
                <th>Evaluacion ID</th>
                <th>Inscripcion ID</th>
                <th>Oferta ID</th>
            </tr>";
    
    // Recorrer los resultados y mostrar cada registro
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>".$fila['ID']."</td>
                <td>".$fila['NombreDocente']."</td>
                <td>".$fila['ApellidoDocente']."</td>
                <td>".$fila['EvaluacionID']."</td>
                <td>".$fila['InscripcionID']."</td>
                <td>".$fila['OfertaID']."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron registros para el docente con ID $docenteID";
}

// Cerrar la conexión
$conexion->close();
?>
