-- Eliminar la base de datos existente si es necesario
DROP DATABASE IF EXISTS seguimiento2;

Create database seguimiento2;
use  seguimiento2;
-- Tabla de Estudiantes
CREATE TABLE Estudiantes (
    id_estudiante INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    correo VARCHAR(100),
    edad INT
);

-- Tabla de Profesores
CREATE TABLE Profesores (
    id_profesor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    correo VARCHAR(100),
    edad INT,
    fecha DATE NOT NULL,
    hora TIME NOT NULL
);

-- Tabla de Salones
CREATE TABLE Salones (
    id_salon INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(100),
    ubicacion VARCHAR(100)
);

-- Tabla de Cursos
CREATE TABLE Cursos (
    id_curso INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    id_salon INT,
    FOREIGN KEY (id_salon) REFERENCES Salones(id_salon)
);

CREATE TABLE Sesiones (
    id_sesion INT AUTO_INCREMENT PRIMARY KEY,
    id_curso INT,
    id_profesor INT,
    dia DATE,
    hora TIME,
    seccion VARCHAR(100),
    FOREIGN KEY (id_curso) REFERENCES Cursos(id_curso),
    FOREIGN KEY (id_profesor) REFERENCES Profesores(id_profesor)
);

-- Crear tabla de relación entre Sesiones y Estudiantes
CREATE TABLE Sesiones_Estudiantes (
    id_sesion INT,
    id_estudiante INT,
    FOREIGN KEY (id_sesion) REFERENCES Sesiones(id_sesion),
    FOREIGN KEY (id_estudiante) REFERENCES Estudiantes(id_estudiante)
);


-- Tabla de Evaluaciones
CREATE TABLE Evaluaciones (
    id_evaluacion INT AUTO_INCREMENT PRIMARY KEY,
    id_curso INT,
    nombre_evaluacion VARCHAR(100),
    fecha DATE,
    hora TIME,
    FOREIGN KEY (id_curso) REFERENCES Cursos(id_curso)
);

INSERT INTO Estudiantes (nombre, apellido, correo, edad) VALUES
('Juan', 'Pérez', 'juan@example.com', 20),
('María', 'Gómez', 'maria@example.com', 22),
('Carlos', 'López', 'carlos@example.com', 21);

INSERT INTO Profesores (nombre, apellido, correo, edad, fecha, hora) VALUES
('Ana', 'Martínez', 'ana@example.com', 35, '2024-02-28', '08:30:00'),
('Pedro', 'Sánchez', 'pedro@example.com', 40, '2024-02-28', '10:00:00'),
('Sofía', 'Hernández', 'sofia@example.com', 38, '2024-02-28', '12:00:00');
 
 INSERT INTO Salones (numero, ubicacion) VALUES
('101', 'Edificio A, Primer Piso'),
('202', 'Edificio B, Segundo Piso'),
('303', 'Edificio C, Tercer Piso');

INSERT INTO Cursos (nombre, id_salon) VALUES
('Matemáticas', 1),
('Historia', 2),
('Ciencias', 3);

-- Suponiendo que los estudiantes, profesores y cursos ya están relacionados y tienen IDs válidos
INSERT INTO Sesiones (id_curso, id_profesor, id_estudiante, dia, hora, seccion) VALUES
(1, 1, 1, '2024-03-01', '08:00:00', 'Sección A'),
(2, 2, 2, '2024-03-02', '10:00:00', 'Sección B'),
(3, 3, 3, '2024-03-03', '12:00:00', 'Sección C');

-- Suponiendo que los cursos ya están relacionados y tienen IDs válidos
INSERT INTO Evaluaciones (id_curso, nombre_evaluacion, fecha, hora) VALUES
(1, 'Examen Parcial', '2024-03-10', '09:00:00'),
(2, 'Prueba de Lectura', '2024-03-15', '11:00:00'),
(3, 'Examen Final', '2024-03-20', '13:00:00');