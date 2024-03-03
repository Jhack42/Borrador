-- Eliminar la base de datos existente si es necesario
DROP DATABASE IF EXISTS seguimiento;

Create database seguimiento;
use  seguimiento;
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
    edad INT
);
-- ------------------------------------------------------------------------
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

ALTER TABLE Profesores
ADD fecha DATE NOT NULL;
ADD hora TIME NOT NULL;
-- ------------------------------------------------
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

-- Tabla de Sesiones
CREATE TABLE Sesiones (
    id_sesion INT AUTO_INCREMENT PRIMARY KEY,
    id_curso INT,
    id_profesor INT,
    id_estudiante INT,
    dia DATE,
    hora TIME,
    seccion VARCHAR(100),
    FOREIGN KEY (id_curso) REFERENCES Cursos(id_curso),
    FOREIGN KEY (id_profesor) REFERENCES Profesores(id_profesor),
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



-- Insertar datos en la tabla Estudiantes
INSERT INTO Estudiantes (nombre, apellido, correo, edad) VALUES
('Juan', 'Perez', 'juan@example.com', 20),
('Maria', 'Gomez', 'maria@example.com', 22),
('Carlos', 'Lopez', 'carlos@example.com', 21);

-- Insertar datos en la tabla Profesores
INSERT INTO Profesores (nombre, apellido, correo, edad) VALUES
('Laura', 'Martinez', 'laura@example.com', 35),
('Pedro', 'Diaz', 'pedro@example.com', 40),
('Ana', 'Rodriguez', 'ana@example.com', 38);

-- Insertar datos en la tabla Salones
INSERT INTO Salones (numero, ubicacion) VALUES
('101', 'Edificio A, Primer Piso'),
('202', 'Edificio B, Segundo Piso'),
('303', 'Edificio C, Tercer Piso');

-- Insertar datos en la tabla Cursos
INSERT INTO Cursos (nombre, id_salon) VALUES
('Matemáticas', 1),
('Historia', 2),
('Ciencias', 3);

-- Insertar datos en la tabla Sesiones
INSERT INTO Sesiones (id_curso, id_profesor, id_estudiante, dia, hora, seccion) VALUES
(1, 1, 1, '2024-02-21', '08:00:00', 'A'),
(2, 2, 2, '2024-02-22', '10:00:00', 'B'),
(3, 3, 3, '2024-02-23', '13:00:00', 'C');

-- Insertar datos en la tabla Evaluaciones
INSERT INTO Evaluaciones (id_curso, nombre_evaluacion, fecha, hora) VALUES
(1, 'Examen Parcial', '2024-03-15', '09:00:00'),
(2, 'Ensayo', '2024-03-20', '10:30:00'),
(3, 'Proyecto Final', '2024-03-25', '14:00:00');






-- Creación de la tabla alumnos
CREATE TABLE correo_de_bienvenida (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_profesor VARCHAR(100),
    nombre_curso VARCHAR(100),
    seccion VARCHAR(100),
    nombre_estudiante VARCHAR(100),
    apellido_estudiante VARCHAR(100),
    fecha_sesion DATE,
    hora_sesion TIME,
    nombre_evaluacion VARCHAR(100),
    fecha_evaluacion DATE,
    hora_evaluacion TIME
);

-- Creación de la tabla alumnos
-- Creación de la tabla alumnos
CREATE TABLE alumnos (
    id_alumno INT PRIMARY KEY,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    correo VARCHAR(100),
    edad INT
);

-- Creación de la tabla profesores
CREATE TABLE profesores (
    id_profesor INT PRIMARY KEY,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    correo VARCHAR(100),
    edad INT
    );

-- Creación de la tabla salon con FOREIGN KEY relacionada con la tabla profesores
CREATE TABLE salon (
    id_salon INT PRIMARY KEY,
    numero VARCHAR(100),
    ubicación VARCHAR(100)
);

CREATE TABLE curso (
    id_curso INT PRIMARY KEY,
    nombre VARCHAR(100)
);

 CREATE TABLE malla_curricular (
    id_malla_curricular INT PRIMARY KEY,
    nombre VARCHAR(100),
    id_curso INT,
    FOREIGN KEY (id_curso) REFERENCES salon(id_curso)
);
 
 
CREATE TABLE horario (
    id_horario INT PRIMARY KEY,
	id_sesion INT,
    FOREIGN KEY (id_sesion) REFERENCES sesion(id_sesion)
    );
    
CREATE TABLE sesion (
    id_sesion INT PRIMARY KEY,
    id_salon INT,
    
    id_profesor INT,
    id_alumno INT,
	Dia DATE,
    Hora TIME,
    sección VARCHAR(100),
    FOREIGN KEY (id_profesor) REFERENCES profesores(id_profesor),
    FOREIGN KEY (id_alumno) REFERENCES alumnos(id_alumno),
    FOREIGN KEY (id_salon) REFERENCES salon(id_salon)
    );
    
    
CREATE TABLE correo (
    id_correo INT PRIMARY KEY,
    nombre VARCHAR(100)
);

-- Datos para la tabla alumnos
INSERT INTO alumnos (id_alumno, nombre, edad, grado) VALUES
(1, 'Carlos', 15, 'Noveno'),
(2, 'Ana', 14, 'Octavo'),
(3, 'Juan', 16, 'Décimo'),
(4, 'María', 15, 'Noveno'),
(5, 'Luis', 13, 'Séptimo');

-- Datos para la tabla profesores
INSERT INTO profesores (id_profesor, nombre, especialidad, experiencia) VALUES
(1, 'Pedro', 'Matemáticas', 5),
(2, 'Laura', 'Ciencias', 8),
(3, 'Sofía', 'Literatura', 6),
(4, 'Daniel', 'Historia', 7),
(5, 'Elena', 'Inglés', 4);

-- Datos para la tabla salon
INSERT INTO salon (id_salon, id_profesor) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- Datos para la tabla clase
INSERT INTO clase (id_clase, id_salon, id_alumno) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5);

-- ------------------------------------------------------------------------------------------------------------------------
-- Eliminar la base de datos existente si es necesario
DROP DATABASE IF EXISTS seguimiento;

Create database seguimiento;
use  seguimiento;
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

-- Tabla de Sesiones
CREATE TABLE Sesiones (
    id_sesion INT AUTO_INCREMENT PRIMARY KEY,
    id_curso INT,
    id_profesor INT,
    id_estudiante INT,
    dia DATE,
    hora TIME,
    seccion VARCHAR(100),
    FOREIGN KEY (id_curso) REFERENCES Cursos(id_curso),
    FOREIGN KEY (id_profesor) REFERENCES Profesores(id_profesor),
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
