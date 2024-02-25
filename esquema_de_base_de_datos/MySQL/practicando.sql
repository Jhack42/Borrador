

CREATE DATABASE IF NOT EXISTS practicando;
USE practicando;
-- Tabla Estudiantes
CREATE TABLE Estudiantes (
    EstudianteID INT PRIMARY KEY,
    Nombres VARCHAR(50),
    Apellidos VARCHAR(50),
    FechaNacimiento DATE,
    Direccion VARCHAR(100),
    Telefono VARCHAR(15),
    email VARCHAR(100)
);

SELECT COUNT(*) AS total_tablas
FROM information_schema.tables
WHERE table_schema = 'practicando';


SELECT table_name
FROM information_schema.tables
WHERE table_schema = 'practicando';
