CREATE DATABASE IF NOT EXISTS prueba;
USE prueba;


-- Eliminar la base de datos existente si es necesario
DROP DATABASE IF EXISTS prueba;


CREATE DATABASE IF NOT EXISTS prueba;
USE prueba;

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

-- Tabla Carreras
CREATE TABLE Carreras (
    CarreraID INT PRIMARY KEY,
    NombreCarrera VARCHAR(100),
    DuracionEnAnios INT
);

-- Tabla Cursos
CREATE TABLE Cursos (
    CursoID INT PRIMARY KEY,
    NombreCurso VARCHAR(100),
    Creditos INT
);

-- Tabla Docentes
CREATE TABLE Docentes (
    DocenteID INT PRIMARY KEY,
    Nombres VARCHAR(50),
    Apellidos VARCHAR(50),
    Direccion VARCHAR(100),
    Telefono VARCHAR(15),
    email VARCHAR(100)
);

-- Tabla sección
CREATE TABLE Seccion (
    SeccionID INT PRIMARY KEY,
    Nombres VARCHAR(50),
    Apellidos VARCHAR(50),
    Direccion VARCHAR(100),
    Telefono VARCHAR(15),
    email VARCHAR(100)
);

-- Tabla Sesiones
CREATE TABLE Sesiones (
    SesionID INT PRIMARY KEY,
    DocenteID INT,
    CursoID INT,
    SeccionID INT,
    Dia DATE,
    Hora TIME,
    TextoArgumentativo TEXT,
    FOREIGN KEY (DocenteID) REFERENCES Docentes(DocenteID),
    FOREIGN KEY (CursoID) REFERENCES Cursos(CursoID),
    FOREIGN KEY (SeccionID) REFERENCES Seccion(SeccionID)
);

-- Tabla Evaluaciones
CREATE TABLE Evaluaciones (
    EvaluacionID INT PRIMARY KEY,
    DocenteID INT,
    CursoID INT,
    Dia DATE,
    Hora TIME,
    TextoArgumentativo TEXT,
    FOREIGN KEY (DocenteID) REFERENCES Docentes(DocenteID),
    FOREIGN KEY (CursoID) REFERENCES Cursos(CursoID)
);

-- Tabla Inscripciones
CREATE TABLE Inscripciones (
    InscripcionID INT PRIMARY KEY,
    EstudianteID INT,
    CarreraID INT,
    FechaInscripcion DATE,
    FOREIGN KEY (EstudianteID) REFERENCES Estudiantes(EstudianteID),
    FOREIGN KEY (CarreraID) REFERENCES Carreras(CarreraID)
);

-- Tabla OfertaAcademica
CREATE TABLE OfertaAcademica (
    OfertaID INT PRIMARY KEY,
    CarreraID INT,
    CursoID INT,
    DocenteID INT,
    Aula VARCHAR(20),
    Horario VARCHAR(50),
    FOREIGN KEY (CarreraID) REFERENCES Carreras(CarreraID),
    FOREIGN KEY (CursoID) REFERENCES Cursos(CursoID),
    FOREIGN KEY (DocenteID) REFERENCES Docentes(DocenteID) -- Cambiado de Profesores a Docentes
);

-- Tabla Notas
CREATE TABLE Notas (
    NotaID INT PRIMARY KEY,
    EstudianteID INT,
    OfertaID INT,
    Nota FLOAT,
    FOREIGN KEY (EstudianteID) REFERENCES Estudiantes(EstudianteID),
    FOREIGN KEY (OfertaID) REFERENCES OfertaAcademica(OfertaID)
);

-- Tabla EstudiantesSesiones
CREATE TABLE EstudiantesSesiones (
    EstudianteSesionID INT PRIMARY KEY,
    EstudianteID INT,
    SesionID INT,
    Dia DATE,
    Hora TIME,
    TextoArgumentativo TEXT,
    FOREIGN KEY (EstudianteID) REFERENCES Estudiantes(EstudianteID),
    FOREIGN KEY (SesionID) REFERENCES Sesiones(SesionID),
    CONSTRAINT UC_EstudianteSesion UNIQUE (EstudianteID, SesionID)
);



-- Crear la nueva tabla
CREATE TABLE InformacionDocente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_docente VARCHAR(100),
    curso_seccion VARCHAR(100),
    listado_estudiantes TEXT,
    listado_sesiones TEXT,
    listado_evaluaciones TEXT,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    correo_docente VARCHAR(100) -- Se añade el campo para el correo del docente
);

drop table InformacionDocente;

CREATE TABLE InformacionDocente (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    DocenteID INT,
    EvaluacionID INT,
    SesionID INT,
    OfertaID INT,
    FOREIGN KEY (DocenteID) REFERENCES Docentes(DocenteID),
    FOREIGN KEY (EvaluacionID) REFERENCES Evaluaciones(EvaluacionID),
    FOREIGN KEY (SesionID) REFERENCES Sesiones(SesionID),
    FOREIGN KEY (OfertaID) REFERENCES OfertaAcademica(OfertaID)
);
SELECT * FROM InformacionDocente;



-- Insertar datos de ejemplo en la tabla InformacionDocente
INSERT INTO InformacionDocente (nombre_docente, curso_seccion, listado_estudiantes, listado_sesiones, listado_evaluaciones, fecha, hora, correo_docente)
VALUES 
    ('Juan Pérez', 'Matemáticas - Sección A', 'Ana García, Luis Martínez, María López', 'Sesión 1, Sesión 2, Sesión 3', 'Evaluación 1, Evaluación 2, Evaluación 3', '2024-02-09', '13:00:00', 'cacereshilasacajhack@gmail.com'),
    ('María Rodríguez', 'Ciencias Naturales - Sección B', 'Pedro Ramírez, Laura Fernández, José Gutiérrez', 'Sesión 1, Sesión 2, Sesión 3', 'Evaluación 1, Evaluación 2, Evaluación 3', '2024-02-10', '13:30:00', 'cacereshilasacajhack@gmail.com'),
    ('Ana Martínez', 'Historia - Sección C', 'Carlos Sánchez, Sofía Jiménez, Daniel Pérez', 'Sesión 1, Sesión 2, Sesión 3', 'Evaluación 1, Evaluación 2, Evaluación 3', '2024-02-11', '13:15:00', 'cacereshilasacajhack@gmail.com');



-- Datos para la tabla Estudiantes
INSERT INTO Estudiantes (EstudianteID, Nombres, Apellidos, FechaNacimiento, Direccion, Telefono)
VALUES
    (1, 'Juan', 'Perez', '2000-05-10', 'Calle 123', '123-456-7890'),
    (2, 'Maria', 'Gonzalez', '2001-02-15', 'Avenida XYZ', '987-654-3210'),
    (3, 'Pedro', 'Rodriguez', '1999-11-20', 'Carrera 45', '555-123-4567');

-- Datos para la tabla Carreras
INSERT INTO Carreras (CarreraID, NombreCarrera, DuracionEnAnios)
VALUES
    (1, 'Ingeniería Informática', 5),
    (2, 'Administración de Empresas', 4),
    (3, 'Medicina', 7);

-- Datos para la tabla Cursos
INSERT INTO Cursos (CursoID, NombreCurso, Creditos)
VALUES
    (1, 'Programación I', 4),
    (2, 'Contabilidad Financiera', 3),
    (3, 'Anatomía Humana', 5);

-- Datos para la tabla Docentes
INSERT INTO Docentes (DocenteID, Nombres, Apellidos, Direccion, Telefono)
VALUES
    (1, 'Luis', 'Martinez', 'Avenida Principal', '111-222-3333'),
    (2, 'Ana', 'Garcia', 'Calle Secundaria', '444-555-6666'),
    (3, 'Carlos', 'Lopez', 'Carretera Norte', '777-888-9999');

-- Datos para la tabla Sesiones (suponiendo que los cursos y docentes ya existen)
INSERT INTO Sesiones (SesionID, DocenteID, CursoID, Dia, Hora, TextoArgumentativo)
VALUES
    (1, 1, 1, '2024-02-10', '09:00:00', 'Introducción a la programación'),
    (2, 2, 2, '2024-02-11', '10:30:00', 'Fundamentos de contabilidad'),
    (3, 3, 3, '2024-02-12', '08:00:00', 'Sistema musculoesquelético');

-- Datos para la tabla Evaluaciones (suponiendo que los cursos y docentes ya existen)
INSERT INTO Evaluaciones (EvaluacionID, DocenteID, CursoID, Dia, Hora, TextoArgumentativo)
VALUES
    (1, 1, 1, '2024-03-01', '09:00:00', 'Examen de programación básica'),
    (2, 2, 2, '2024-03-02', '10:30:00', 'Prueba de balances contables'),
    (3, 3, 3, '2024-03-03', '08:00:00', 'Examen de sistema musculoesquelético');

-- Datos para la tabla Inscripciones (suponiendo que los estudiantes y carreras ya existen)
INSERT INTO Inscripciones (InscripcionID, EstudianteID, CarreraID, FechaInscripcion)
VALUES
    (1, 1, 1, '2024-01-15'),
    (2, 2, 2, '2024-01-20'),
    (3, 3, 3, '2024-01-25');

-- Datos para la tabla OfertaAcademica (suponiendo que los cursos, docentes y carreras ya existen)
INSERT INTO OfertaAcademica (OfertaID, CarreraID, CursoID, DocenteID, Aula, Horario)
VALUES
    (1, 1, 1, 1, 'Aula 101', 'Lunes y Miércoles 09:00 - 10:30'),
    (2, 2, 2, 2, 'Aula 201', 'Martes y Jueves 10:30 - 12:00'),
    (3, 3, 3, 3, 'Aula 301', 'Lunes y Miércoles 08:00 - 09:30');

-- Datos para la tabla Notas (suponiendo que los estudiantes y la oferta académica ya existen)
INSERT INTO Notas (NotaID, EstudianteID, OfertaID, Nota)
VALUES
    (1, 1, 1, 85),
    (2, 2, 2, 78),
    (3, 3, 3, 90);

-- Datos para la tabla EstudiantesSesiones (suponiendo que los estudiantes y sesiones ya existen)
INSERT INTO EstudiantesSesiones (EstudianteSesionID, EstudianteID, SesionID, Dia, Hora, TextoArgumentativo)
VALUES
    (1, 1, 1, '2024-02-10', '09:00:00', 'Asistió a la sesión y participó activamente'),
    (2, 2, 2, '2024-02-11', '10:30:00', 'Tuvo preguntas sobre los estados financieros'),
    (3, 3, 3, '2024-02-12', '08:00:00', 'Realizó demostraciones sobre los músculos');




-- Insertar datos en la nueva tabla
INSERT INTO InformacionDocente (nombre_docente, curso_seccion, listado_estudiantes, listado_sesiones, listado_evaluaciones, fecha, hora, correo_docente)
SELECT 
    CONCAT(d.Nombres, ' ', d.Apellidos) AS nombre_docente,
    CONCAT(c.NombreCurso, ' ', oa.Aula) AS curso_seccion,
    GROUP_CONCAT(CONCAT(e.Nombres, ' ', e.Apellidos) SEPARATOR ', ') AS listado_estudiantes,
    GROUP_CONCAT(CONCAT(s.Dia, ' ', s.Hora) SEPARATOR ', ') AS listado_sesiones,
    GROUP_CONCAT(CONCAT(ev.Dia, ' ', ev.Hora) SEPARATOR ', ') AS listado_evaluaciones,
    CURDATE() AS fecha,
    CURTIME() AS hora,
    d.Correo AS correo_docente
FROM 
    Sesiones s
JOIN 
    Docentes d ON s.DocenteID = d.DocenteID
JOIN 
    Cursos c ON s.CursoID = c.CursoID
JOIN 
    OfertaAcademica oa ON s.CursoID = oa.CursoID
JOIN 
    Evaluaciones ev ON s.DocenteID = ev.DocenteID AND s.CursoID = ev.CursoID
JOIN 
    Inscripciones i ON oa.CarreraID = i.CarreraID
JOIN 
    Estudiantes e ON i.EstudianteID = e.EstudianteID
GROUP BY 
    s.SesionID;
    
 
 INSERT INTO InformacionDocente (DocenteID) 
                  SELECT d.DocenteID FROM Docentes d
                  WHERE NOT EXISTS (
                      SELECT 1 FROM InformacionDocente id 
                      WHERE id.DocenteID = d.DocenteID
                  )
 SELECT 
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
 
 
SELECT EvaluacionID 
FROM Evaluaciones 
WHERE DocenteID IN (
    SELECT DocenteID 
    FROM Evaluaciones 
    GROUP BY DocenteID 
    HAVING COUNT(*) > 1
);

SELECT * FROM Docentes

SELECT TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME 
                 FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                 WHERE REFERENCED_TABLE_NAME = Docentes










-- Estudiantes
INSERT INTO Estudiantes (EstudianteID, Nombres, Apellidos, FechaNacimiento, Direccion, Telefono, email) 
VALUES
(1, 'Juan', 'Pérez', '1998-05-15', 'Calle 123', '123-456-7890', 'juan@example.com'),
(2, 'María', 'García', '1999-02-28', 'Avenida Principal', '987-654-3210', 'maria@example.com'),
(3, 'Carlos', 'López', '2000-10-10', 'Calle de la Montaña', '555-123-4567', 'carlos@example.com'),
(4, 'Luis', 'González', '1997-08-20', 'Calle 456', '333-444-5555', 'luis@example.com'),
(5, 'Ana', 'López', '1999-01-10', 'Avenida Central', '777-888-9999', 'ana@example.com'),
(6, 'Pedro', 'Martínez', '2001-05-03', 'Calle de los Pinos', '111-222-3333', 'pedro@example.com'),
(7, 'Laura', 'Sánchez', '1997-03-20', 'Avenida de las Flores', '555-666-7777', 'laura@example.com'),
(8, 'José', 'Gómez', '2000-12-05', 'Calle del Bosque', '999-888-7777', 'jose@example.com'),
(9, 'María', 'Díaz', '1998-09-12', 'Calle de los Libros', '222-333-4444', 'maria@example.com');

-- Carreras
INSERT INTO Carreras (CarreraID, NombreCarrera, DuracionEnAnios) 
VALUES
(1, 'Ingeniería Informática', 5),
(2, 'Administración de Empresas', 4),
(3, 'Medicina', 6),
(4, 'Derecho', 5),
(5, 'Arquitectura', 5),
(6, 'Psicología', 4),
(7, 'Ingeniería Civil', 5),
(8, 'Biología', 4),
(9, 'Química', 5);

-- Cursos
INSERT INTO Cursos (CursoID, NombreCurso, Creditos) 
VALUES
(1, 'Programación Avanzada', 4),
(2, 'Contabilidad Financiera', 3),
(3, 'Anatomía Humana', 5),
(4, 'Diseño Estructural', 4),
(5, 'Psicología del Desarrollo', 3),
(6, 'Derecho Penal', 5),
(7, 'Dibujo Arquitectónico', 3),
(8, 'Biología Celular', 4),
(9, 'Química Orgánica', 5);

-- Docentes
INSERT INTO Docentes (DocenteID, Nombres, Apellidos, Direccion, Telefono, email) 
VALUES
(1, 'Pablo', 'Martínez', 'Calle del Maestro', '123-456-7890', 'pablo@example.com'),
(2, 'Ana', 'Rodríguez', 'Avenida de los Profesores', '987-654-3210', 'ana@example.com'),
(3, 'David', 'García', 'Calle de las Ciencias', '555-123-4567', 'david@example.com'),
(4, 'Laura', 'Sánchez', 'Avenida de las Flores', '555-666-7777', 'laura@example.com'),
(5, 'José', 'Gómez', 'Calle del Bosque', '999-888-7777', 'jose@example.com'),
(6, 'María', 'Díaz', 'Calle de los Libros', '222-333-4444', 'maria@example.com'),
(7, 'Sara', 'Fernández', 'Calle de los Pinceles', '333-444-5555', 'sara@example.com'),
(8, 'Daniel', 'Hernández', 'Avenida de las Ciencias', '777-888-9999', 'daniel@example.com'),
(9, 'Lucía', 'López', 'Calle de las Estrellas', '888-999-0000', 'lucia@example.com');

-- Sección
INSERT INTO Seccion (SeccionID, Nombres, Apellidos, Direccion, Telefono, email) 
VALUES
(1, 'Sofía', 'Hernández', 'Calle de las Rosas', '111-222-3333', 'sofia@example.com'),
(2, 'Mateo', 'Rodríguez', 'Avenida de las Palmeras', '444-555-6666', 'mateo@example.com'),
(3, 'Valentina', 'Gómez', 'Calle de las Flores', '777-888-9999', 'valentina@example.com'),
(4, 'Santiago', 'Pérez', 'Avenida de las Aves', '222-333-4444', 'santiago@example.com'),
(5, 'Isabella', 'Martínez', 'Calle de los Girasoles', '555-666-7777', 'isabella@example.com'),
(6, 'Benjamín', 'López', 'Avenida de las Estrellas', '888-999-0000', 'benjamin@example.com'),
(7, 'Emma', 'Díaz', 'Calle de las Mariposas', '111-222-3333', 'emma@example.com'),
(8, 'Lucas', 'Sánchez', 'Avenida de las Montañas', '444-555-6666', 'lucas@example.com'),
(9, 'Lucía', 'Rodríguez', 'Calle de los Volcanes', '777-888-9999', 'lucia@example.com');

-- Sesiones
INSERT INTO Sesiones (SesionID, DocenteID, CursoID, SeccionID, Dia, Hora, TextoArgumentativo) 
VALUES
(1, 1, 1, 1, '2024-02-13', '09:00:00', 'Introducción a la Programación Avanzada'),
(2, 2, 2, 2, '2024-02-14', '10:30:00', 'Fundamentos de Contabilidad'),
(3, 3, 3, 3, '2024-02-15', '08:00:00', 'Sistema Muscular y Óseo'),
(4, 4, 4, 4, '2024-02-16', '14:00:00', 'Introducción al Diseño Estructural'),
(5, 5, 5, 5, '2024-02-17', '09:30:00', 'Teorías de Desarrollo Psicológico'),
(6, 6, 6, 6, '2024-02-18', '11:00:00', 'Principios de Derecho Penal'),
(7, 7, 7, 7, '2024-02-19', '13:00:00', 'Fundamentos de Dibujo Arquitectónico'),
(8, 8, 8, 8, '2024-02-20', '15:00:00', 'Conceptos de Biología Celular'),
(9, 9, 9, 9, '2024-02-21', '16:30:00', 'Introducción a la Química Orgánica');

-- Evaluaciones
INSERT INTO Evaluaciones (EvaluacionID, DocenteID, CursoID, Dia, Hora, TextoArgumentativo) 
VALUES
(1, 1, 1, '2024-03-15', '09:00:00', 'Examen de Programación Avanzada'),
(2, 2, 2, '2024-03-16', '10:30:00', 'Examen de Contabilidad Financiera'),
(3, 3, 3, '2024-03-17', '08:00:00', 'Examen de Anatomía Humana'),
(4, 4, 4, '2024-03-18', '14:00:00', 'Examen de Diseño Estructural'),
(5, 5, 5, '2024-03-19', '09:30:00', 'Examen de Psicología del Desarrollo'),
(6, 6, 6, '2024-03-20', '11:00:00', 'Examen de Derecho Penal'),
(7, 7, 7, '2024-03-21', '13:00:00', 'Examen de Dibujo Arquitectónico'),
(8, 8, 8, '2024-03-22', '15:00:00', 'Examen de Biología Celular'),
(9, 9, 9, '2024-03-23', '16:30:00', 'Examen de Química Orgánica');

-- Inscripciones
INSERT INTO Inscripciones (InscripcionID, EstudianteID, CarreraID, FechaInscripcion) 
VALUES
(1, 1, 1, '2023-09-01'),
(2, 2, 2, '2023-09-05'),
(3, 3, 3, '2023-09-10'),
(4, 4, 4, '2023-09-15'),
(5, 5, 5, '2023-09-20'),
(6, 6, 6, '2023-09-25'),
(7, 7, 7, '2023-10-01'),
(8, 8, 8, '2023-10-05'),
(9, 9, 9, '2023-10-10');

-- OfertaAcademica
INSERT INTO OfertaAcademica (OfertaID, CarreraID, CursoID, DocenteID, Aula, Horario) 
VALUES
(1, 1, 1, 1, 'Aula 101', 'Lunes y Miércoles 9:00 - 11:00'),
(2, 2, 2, 2, 'Aula 102', 'Martes y Jueves 10:30 - 12:30'),
(3, 3, 3, 3, 'Aula 103', 'Lunes y Miércoles 8:00 - 10:00'),
(4, 4, 4, 4, 'Aula 104', 'Martes y Jueves 14:00 - 16:00'),
(5, 5, 5, 5, 'Aula 105', 'Lunes y Miércoles 9:30 - 11:30'),
(6, 6, 6, 6, 'Aula 106', 'Martes y Jueves 11:00 - 13:00'),
(7, 7, 7, 7, 'Aula 107', 'Lunes y Miércoles 13:00 - 15:00'),
(8, 8, 8, 8, 'Aula 108', 'Martes y Jueves 15:00 - 17:00'),
(9, 9, 9, 9, 'Aula 109', 'Lunes y Miércoles 16:30 - 18:30');

-- Notas
INSERT INTO Notas (NotaID, EstudianteID, OfertaID, Nota) 
VALUES
(1, 1, 1, 80),
(2, 2, 2, 75),
(3, 3, 3, 85),
(4, 4, 4, 70),
(5, 5, 5, 82),
(6, 6, 6, 78),
(7, 7, 7, 73),
(8, 8, 8, 79),
(9, 9, 9, 81);

-- EstudiantesSesiones
INSERT INTO EstudiantesSesiones (EstudianteSesionID, EstudianteID, SesionID, Dia, Hora, TextoArgumentativo) 
VALUES
(1, 1, 1, '2024-02-13', '09:00:00', 'Asistencia a Introducción a la Programación Avanzada'),
(2, 2, 2, '2024-02-14', '10:30:00', 'Asistencia a Fundamentos de Contabilidad'),
(3, 3, 3, '2024-02-15', '08:00:00', 'Asistencia a Sistema Muscular y Óseo'),
(4, 4, 4, '2024-02-16', '14:00:00', 'Asistencia a Introducción al Diseño Estructural'),
(5, 5, 5, '2024-02-17', '09:30:00', 'Asistencia a Teorías de Desarrollo Psicológico'),
(6, 6, 6, '2024-02-18', '11:00:00', 'Asistencia a Principios de Derecho Penal'),
(7, 7, 7, '2024-02-19', '13:00:00', 'Asistencia a Fundamentos de Dibujo Arquitectónico'),
(8, 8, 8, '2024-02-20', '15:00:00', 'Asistencia a Conceptos de Biología Celular'),
(9, 9, 9, '2024-02-21', '16:30:00', 'Asistencia a Introducción a la Química Orgánica');



CREATE TABLE docente_bienvenida (
    docente_bienvenidaID INT PRIMARY KEY AUTO_INCREMENT,
    tabla VARCHAR(255),
    columna VARCHAR(255),
    claves_foranea VARCHAR(255)
);

-- ----------------------------------------------------------------------------------------------------------------------------------------
-- Eliminar la base de datos existente si es necesario
DROP DATABASE IF EXISTS prueba;

CREATE DATABASE IF NOT EXISTS prueba;
USE prueba;

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

-- Tabla Carreras
CREATE TABLE Carreras (
    CarreraID INT PRIMARY KEY,
    NombreCarrera VARCHAR(100),
    DuracionEnAnios INT
);

-- Tabla Cursos
CREATE TABLE Cursos (
    CursoID INT PRIMARY KEY,
    NombreCurso VARCHAR(100),
    Creditos INT
);

-- Tabla Docentes
CREATE TABLE Docentes (
    DocenteID INT PRIMARY KEY,
    Nombres VARCHAR(50),
    Apellidos VARCHAR(50),
    Direccion VARCHAR(100),
    Telefono VARCHAR(15),
    email VARCHAR(100)
);

-- Tabla sección
CREATE TABLE Seccion (
    SeccionID INT PRIMARY KEY,
    Nombres VARCHAR(50),
    Apellidos VARCHAR(50),
    Direccion VARCHAR(100),
    Telefono VARCHAR(15),
    email VARCHAR(100)
);

-- Tabla Sesiones
CREATE TABLE Sesiones (
    SesionID INT PRIMARY KEY,
    DocenteID INT,
    CursoID INT,
    SeccionID INT,
    Dia DATE,
    Hora TIME,
    TextoArgumentativo TEXT,
    FOREIGN KEY (DocenteID) REFERENCES Docentes(DocenteID),
    FOREIGN KEY (CursoID) REFERENCES Cursos(CursoID),
    FOREIGN KEY (SeccionID) REFERENCES Seccion(SeccionID)
);

-- Tabla Evaluaciones
CREATE TABLE Evaluaciones (
    EvaluacionID INT PRIMARY KEY,
    DocenteID INT,
    CursoID INT,
    Dia DATE,
    Hora TIME,
    TextoArgumentativo TEXT,
    FOREIGN KEY (DocenteID) REFERENCES Docentes(DocenteID),
    FOREIGN KEY (CursoID) REFERENCES Cursos(CursoID)
);

-- Tabla Inscripciones
CREATE TABLE Inscripciones (
    InscripcionID INT PRIMARY KEY,
    EstudianteID INT,
    CarreraID INT,
    FechaInscripcion DATE,
    FOREIGN KEY (EstudianteID) REFERENCES Estudiantes(EstudianteID),
    FOREIGN KEY (CarreraID) REFERENCES Carreras(CarreraID)
);

-- Tabla OfertaAcademica
CREATE TABLE OfertaAcademica (
    OfertaID INT PRIMARY KEY,
    CarreraID INT,
    CursoID INT,
    DocenteID INT,
    Aula VARCHAR(20),
    Horario VARCHAR(50),
    FOREIGN KEY (CarreraID) REFERENCES Carreras(CarreraID),
    FOREIGN KEY (CursoID) REFERENCES Cursos(CursoID),
    FOREIGN KEY (DocenteID) REFERENCES Docentes(DocenteID) -- Cambiado de Profesores a Docentes
);

-- Tabla Notas
CREATE TABLE Notas (
    NotaID INT PRIMARY KEY,
    EstudianteID INT,
    OfertaID INT,
    Nota FLOAT,
    FOREIGN KEY (EstudianteID) REFERENCES Estudiantes(EstudianteID),
    FOREIGN KEY (OfertaID) REFERENCES OfertaAcademica(OfertaID)
);

-- Tabla EstudiantesSesiones
CREATE TABLE EstudiantesSesiones (
    EstudianteSesionID INT PRIMARY KEY,
    EstudianteID INT,
    SesionID INT,
    Dia DATE,
    Hora TIME,
    TextoArgumentativo TEXT,
    FOREIGN KEY (EstudianteID) REFERENCES Estudiantes(EstudianteID),
    FOREIGN KEY (SesionID) REFERENCES Sesiones(SesionID)
);

-- Tabla EstudiantesSesiones
-- CREATE TABLE EstudiantesSesiones (
--    EstudianteSesionID INT PRIMARY KEY,
--    EstudianteID INT,
--    SesionID INT,
--    Dia DATE,
--    Hora TIME,
--    TextoArgumentativo TEXT,
--    FOREIGN KEY (EstudianteID) REFERENCES Estudiantes(EstudianteID),
--    FOREIGN KEY (SesionID) REFERENCES Sesiones(SesionID),
--    CONSTRAINT UC_EstudianteSesion UNIQUE (EstudianteID, SesionID)
-- );


-- Estudiantes
INSERT INTO Estudiantes (EstudianteID, Nombres, Apellidos, FechaNacimiento, Direccion, Telefono, email) 
VALUES
(1, 'Juan', 'Pérez', '1998-05-15', 'Calle 123', '123-456-7890', 'juan@example.com'),
(2, 'María', 'García', '1999-02-28', 'Avenida Principal', '987-654-3210', 'maria@example.com'),
(3, 'Carlos', 'López', '2000-10-10', 'Calle de la Montaña', '555-123-4567', 'carlos@example.com'),
(4, 'Luis', 'González', '1997-08-20', 'Calle 456', '333-444-5555', 'luis@example.com'),
(5, 'Ana', 'López', '1999-01-10', 'Avenida Central', '777-888-9999', 'ana@example.com'),
(6, 'Pedro', 'Martínez', '2001-05-03', 'Calle de los Pinos', '111-222-3333', 'pedro@example.com'),
(7, 'Laura', 'Sánchez', '1997-03-20', 'Avenida de las Flores', '555-666-7777', 'laura@example.com'),
(8, 'José', 'Gómez', '2000-12-05', 'Calle del Bosque', '999-888-7777', 'jose@example.com'),
(9, 'María', 'Díaz', '1998-09-12', 'Calle de los Libros', '222-333-4444', 'maria@example.com');

-- Carreras
INSERT INTO Carreras (CarreraID, NombreCarrera, DuracionEnAnios) 
VALUES
(1, 'Ingeniería Informática', 5),
(2, 'Administración de Empresas', 4),
(3, 'Medicina', 6),
(4, 'Derecho', 5),
(5, 'Arquitectura', 5),
(6, 'Psicología', 4),
(7, 'Ingeniería Civil', 5),
(8, 'Biología', 4),
(9, 'Química', 5);

-- Cursos
INSERT INTO Cursos (CursoID, NombreCurso, Creditos) 
VALUES
(1, 'Programación Avanzada', 4),
(2, 'Contabilidad Financiera', 3),
(3, 'Anatomía Humana', 5),
(4, 'Diseño Estructural', 4),
(5, 'Psicología del Desarrollo', 3),
(6, 'Derecho Penal', 5),
(7, 'Dibujo Arquitectónico', 3),
(8, 'Biología Celular', 4),
(9, 'Química Orgánica', 5);

-- Docentes
INSERT INTO Docentes (DocenteID, Nombres, Apellidos, Direccion, Telefono, email) 
VALUES
(1, 'Pablo', 'Martínez', 'Calle del Maestro', '123-456-7890', 'pablo@example.com'),
(2, 'Ana', 'Rodríguez', 'Avenida de los Profesores', '987-654-3210', 'ana@example.com'),
(3, 'David', 'García', 'Calle de las Ciencias', '555-123-4567', 'david@example.com'),
(4, 'Laura', 'Sánchez', 'Avenida de las Flores', '555-666-7777', 'laura@example.com'),
(5, 'José', 'Gómez', 'Calle del Bosque', '999-888-7777', 'jose@example.com'),
(6, 'María', 'Díaz', 'Calle de los Libros', '222-333-4444', 'maria@example.com'),
(7, 'Sara', 'Fernández', 'Calle de los Pinceles', '333-444-5555', 'sara@example.com'),
(8, 'Daniel', 'Hernández', 'Avenida de las Ciencias', '777-888-9999', 'daniel@example.com'),
(9, 'Lucía', 'López', 'Calle de las Estrellas', '888-999-0000', 'lucia@example.com');

-- Sección
INSERT INTO Seccion (SeccionID, Nombres, Apellidos, Direccion, Telefono, email) 
VALUES
(1, 'Sofía', 'Hernández', 'Calle de las Rosas', '111-222-3333', 'sofia@example.com'),
(2, 'Mateo', 'Rodríguez', 'Avenida de las Palmeras', '444-555-6666', 'mateo@example.com'),
(3, 'Valentina', 'Gómez', 'Calle de las Flores', '777-888-9999', 'valentina@example.com'),
(4, 'Santiago', 'Pérez', 'Avenida de las Aves', '222-333-4444', 'santiago@example.com'),
(5, 'Isabella', 'Martínez', 'Calle de los Girasoles', '555-666-7777', 'isabella@example.com'),
(6, 'Benjamín', 'López', 'Avenida de las Estrellas', '888-999-0000', 'benjamin@example.com'),
(7, 'Emma', 'Díaz', 'Calle de las Mariposas', '111-222-3333', 'emma@example.com'),
(8, 'Lucas', 'Sánchez', 'Avenida de las Montañas', '444-555-6666', 'lucas@example.com'),
(9, 'Lucía', 'Rodríguez', 'Calle de los Volcanes', '777-888-9999', 'lucia@example.com');

-- Sesiones
INSERT INTO Sesiones (SesionID, DocenteID, CursoID, SeccionID, Dia, Hora, TextoArgumentativo) 
VALUES
(1, 1, 1, 1, '2024-02-13', '09:00:00', 'Introducción a la Programación Avanzada'),
(2, 2, 2, 2, '2024-02-14', '10:30:00', 'Fundamentos de Contabilidad'),
(3, 3, 3, 3, '2024-02-15', '08:00:00', 'Sistema Muscular y Óseo'),
(4, 4, 4, 4, '2024-02-16', '14:00:00', 'Introducción al Diseño Estructural'),
(5, 5, 5, 5, '2024-02-17', '09:30:00', 'Teorías de Desarrollo Psicológico'),
(6, 6, 6, 6, '2024-02-18', '11:00:00', 'Principios de Derecho Penal'),
(7, 7, 7, 7, '2024-02-19', '13:00:00', 'Fundamentos de Dibujo Arquitectónico'),
(8, 8, 8, 8, '2024-02-20', '15:00:00', 'Conceptos de Biología Celular'),
(9, 9, 9, 9, '2024-02-21', '16:30:00', 'Introducción a la Química Orgánica');

-- Evaluaciones
INSERT INTO Evaluaciones (EvaluacionID, DocenteID, CursoID, Dia, Hora, TextoArgumentativo) 
VALUES
(1, 1, 1, '2024-03-15', '09:00:00', 'Examen de Programación Avanzada'),
(2, 2, 2, '2024-03-16', '10:30:00', 'Examen de Contabilidad Financiera'),
(3, 3, 3, '2024-03-17', '08:00:00', 'Examen de Anatomía Humana'),
(4, 4, 4, '2024-03-18', '14:00:00', 'Examen de Diseño Estructural'),
(5, 5, 5, '2024-03-19', '09:30:00', 'Examen de Psicología del Desarrollo'),
(6, 6, 6, '2024-03-20', '11:00:00', 'Examen de Derecho Penal'),
(7, 7, 7, '2024-03-21', '13:00:00', 'Examen de Dibujo Arquitectónico'),
(8, 8, 8, '2024-03-22', '15:00:00', 'Examen de Biología Celular'),
(9, 9, 9, '2024-03-23', '16:30:00', 'Examen de Química Orgánica');

-- Inscripciones
INSERT INTO Inscripciones (InscripcionID, EstudianteID, CarreraID, FechaInscripcion) 
VALUES
(1, 1, 1, '2023-09-01'),
(2, 2, 2, '2023-09-05'),
(3, 3, 3, '2023-09-10'),
(4, 4, 4, '2023-09-15'),
(5, 5, 5, '2023-09-20'),
(6, 6, 6, '2023-09-25'),
(7, 7, 7, '2023-10-01'),
(8, 8, 8, '2023-10-05'),
(9, 9, 9, '2023-10-10');

-- OfertaAcademica
INSERT INTO OfertaAcademica (OfertaID, CarreraID, CursoID, DocenteID, Aula, Horario) 
VALUES
(1, 1, 1, 1, 'Aula 101', 'Lunes y Miércoles 9:00 - 11:00'),
(2, 2, 2, 2, 'Aula 102', 'Martes y Jueves 10:30 - 12:30'),
(3, 3, 3, 3, 'Aula 103', 'Lunes y Miércoles 8:00 - 10:00'),
(4, 4, 4, 4, 'Aula 104', 'Martes y Jueves 14:00 - 16:00'),
(5, 5, 5, 5, 'Aula 105', 'Lunes y Miércoles 9:30 - 11:30'),
(6, 6, 6, 6, 'Aula 106', 'Martes y Jueves 11:00 - 13:00'),
(7, 7, 7, 7, 'Aula 107', 'Lunes y Miércoles 13:00 - 15:00'),
(8, 8, 8, 8, 'Aula 108', 'Martes y Jueves 15:00 - 17:00'),
(9, 9, 9, 9, 'Aula 109', 'Lunes y Miércoles 16:30 - 18:30');

-- Notas
INSERT INTO Notas (NotaID, EstudianteID, OfertaID, Nota) 
VALUES
(1, 1, 1, 80),
(2, 2, 2, 75),
(3, 3, 3, 85),
(4, 4, 4, 70),
(5, 5, 5, 82),
(6, 6, 6, 78),
(7, 7, 7, 73),
(8, 8, 8, 79),
(9, 9, 9, 81);

-- EstudiantesSesiones
INSERT INTO EstudiantesSesiones (EstudianteSesionID, EstudianteID, SesionID, Dia, Hora, TextoArgumentativo) 
VALUES
(1, 1, 1, '2024-02-13', '09:00:00', 'Asistencia a Introducción a la Programación Avanzada'),
(2, 2, 2, '2024-02-14', '10:30:00', 'Asistencia a Fundamentos de Contabilidad'),
(3, 3, 3, '2024-02-15', '08:00:00', 'Asistencia a Sistema Muscular y Óseo'),
(4, 4, 4, '2024-02-16', '14:00:00', 'Asistencia a Introducción al Diseño Estructural'),
(5, 5, 5, '2024-02-17', '09:30:00', 'Asistencia a Teorías de Desarrollo Psicológico'),
(6, 6, 6, '2024-02-18', '11:00:00', 'Asistencia a Principios de Derecho Penal'),
(7, 7, 7, '2024-02-19', '13:00:00', 'Asistencia a Fundamentos de Dibujo Arquitectónico'),
(8, 8, 8, '2024-02-20', '15:00:00', 'Asistencia a Conceptos de Biología Celular'),
(9, 9, 9, '2024-02-21', '16:30:00', 'Asistencia a Introducción a la Química Orgánica');



CREATE TABLE docente_bienvenida (
    docente_bienvenidaID INT PRIMARY KEY AUTO_INCREMENT,
    tabla VARCHAR(255),
    columna VARCHAR(255),
    claves_foranea VARCHAR(255),
    valor_predeterminado INT,
    columna2 VARCHAR(255),
    claves_foranea2 VARCHAR(255),
    valor_predeterminado2 INT,
    claves_foranea3 VARCHAR(255),
    tabla3 VARCHAR(255),
	foreign_key_columna2 VARCHAR(255) -- para guardar el nombre de la segunda columna que contiene el FOREIGN KEY

);



INSERT INTO docente_bienvenida (tabla, columna, claves_foranea) VALUES ('Docentes', 'Evaluaciones', 'DocenteID');









