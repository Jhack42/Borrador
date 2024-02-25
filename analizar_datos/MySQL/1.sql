-- Eliminar la base de datos existente si es necesario
DROP DATABASE IF EXISTS seguimiento;

Create database seguimiento;
use  seguimiento;


-- Creación de la tabla alumnos
CREATE TABLE alumnos (
    id_alumno INT PRIMARY KEY,
    nombre VARCHAR(100),
    edad INT,
    grado VARCHAR(50)
);

-- Creación de la tabla profesores
CREATE TABLE profesores (
    id_profesor INT PRIMARY KEY,
    nombre VARCHAR(100),
    especialidad VARCHAR(100),
    experiencia INT
);

-- Creación de la tabla salon con FOREIGN KEY relacionada con la tabla profesores
CREATE TABLE salon (
    id_salon INT PRIMARY KEY,
    id_profesor INT,
    FOREIGN KEY (id_profesor) REFERENCES profesores(id_profesor)
);

-- Creación de la tabla clase con FOREIGN KEY relacionadas con las tablas salon y alumnos
CREATE TABLE clase (
    id_clase INT PRIMARY KEY,
    id_salon INT,
    id_alumno INT,
    FOREIGN KEY (id_salon) REFERENCES salon(id_salon),
    FOREIGN KEY (id_alumno) REFERENCES alumnos(id_alumno)
); 