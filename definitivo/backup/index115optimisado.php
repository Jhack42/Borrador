<?php
// Conexión a la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'prueba');

try {
    // Establecer conexión con la base de datos
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión a la base de datos: " . $conexion->connect_error);
    }

    // Consulta SQL para insertar los IDs de los docentes existentes en la tabla Docentes en la tabla InformacionDocente
    $sqlInsert = "INSERT INTO InformacionDocente (DocenteID) 
                  SELECT d.DocenteID FROM Docentes d
                  WHERE NOT EXISTS (
                      SELECT 1 FROM InformacionDocente id 
                      WHERE id.DocenteID = d.DocenteID
                  )";

    // Ejecutar la consulta de inserción
    if ($conexion->query($sqlInsert) === TRUE) {
        echo "Se han insertado los IDs de los docentes existentes en la tabla InformacionDocente.<br>";
    } else {
        throw new Exception("Error al insertar los IDs de los docentes: " . $conexion->error);
    }

    // Consulta SQL para seleccionar todos los registros de la tabla InformacionDocente
    $docenteID = 1; // Reemplaza esto con el ID del docente que deseas consultar

    $sqlSelect = "SELECT 
                    ID,
                    d.Nombres AS NombreDocente,
                    d.Apellidos AS ApellidoDocente,
                    e.EvaluacionID,
                    i.InscripcionID,
                    o.OfertaID
                FROM 
                    InformacionDocente id
                LEFT JOIN 
                    Docentes d ON id.DocenteID = d.DocenteID
                LEFT JOIN 
                    Evaluaciones e ON id.EvaluacionID = e.EvaluacionID
                LEFT JOIN 
                    Inscripciones i ON id.InscripcionID = i.InscripcionID
                LEFT JOIN 
                    OfertaAcademica o ON id.OfertaID = o.OfertaID
                WHERE 
                    id.DocenteID = ?";

    // Preparar la consulta
    $stmt = $conexion->prepare($sqlSelect);
    $stmt->bind_param("i", $docenteID);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verificar si hay resultados
    if ($resultado->num_rows > 0) {
        // Crear la tabla con la información obtenida
        $tabla = "<h2>Información del Docente</h2>";
        $tabla .= "<table border='1'>
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
            $tabla .= "<tr>
                        <td>".$fila['ID']."</td>
                        <td>".$fila['NombreDocente']."</td>
                        <td>".$fila['ApellidoDocente']."</td>
                        <td>".$fila['EvaluacionID']."</td>
                        <td>".$fila['InscripcionID']."</td>
                        <td>".$fila['OfertaID']."</td>
                    </tr>";
        }
        $tabla .= "</table>";

        echo $tabla;
    } else {
        echo "No se encontraron registros para el docente con ID $docenteID";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    // Cerrar la conexión
    if (isset($conexion)) {
        $conexion->close();
    }
}
?>