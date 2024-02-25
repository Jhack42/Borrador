CREATE DATABASE crear_base_de_datos;

USE crear_base_de_datos;
drop database crear_base_de_datos;
-- Tabla de Estudiantes
CREATE TABLE Estudiantes (
    id_estudiante INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    apellidos VARCHAR(100),
    dni VARCHAR(20),
    correo_electronico VARCHAR(100)
);

-- Tabla de Profesores
CREATE TABLE Profesores (
    id_profesor INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    apellidos VARCHAR(100),
    dni VARCHAR(20),
    correo_electronico VARCHAR(100)
);

-- Tabla de Salones
CREATE TABLE Salones (
    id_salon INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100)
);
drop table Cursos;
-- Tabla de Cursos
CREATE TABLE Cursos (
    id_curso INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    id_salon int,
    id_horario int,
    FOREIGN KEY (id_horario) REFERENCES Horario(id_horario),
    FOREIGN KEY (id_salon) REFERENCES Salones(id_salon)
);

-- Tabla de Carreras
CREATE TABLE Carreras (
    id_carrera INT AUTO_INCREMENT PRIMARY KEY,
    id_curso INT,
    nombres VARCHAR(100),
    FOREIGN KEY (id_curso) REFERENCES Cursos(id_curso)
);

-- Tabla de Matricula_Estudiantes
CREATE TABLE Matricula_Estudiantes (
    id_matri_estu INT AUTO_INCREMENT PRIMARY KEY,
    id_carrera int,
    id_estudiante INT,
    FOREIGN KEY (id_estudiante) REFERENCES Estudiantes(id_estudiante),
    FOREIGN KEY (id_carrera) REFERENCES Carreras(id_carrera)
);

-- Tabla de Matricula_Profesores
CREATE TABLE Matricula_Profesores (
    id_matri_profe INT AUTO_INCREMENT PRIMARY KEY,
    id_carrera int,
    id_profesor INT,
    FOREIGN KEY (id_profesor) REFERENCES Profesores(id_profesor),
    FOREIGN KEY (id_carrera) REFERENCES Carreras(id_carrera)
);

-- Tabla de Horario
CREATE TABLE Horario (
    id_horario INT AUTO_INCREMENT PRIMARY KEY,
    id_semana int,
    id_evaluacion int,
    FOREIGN KEY (id_semana) REFERENCES Semanas(id_semana),
    FOREIGN KEY (id_evaluacion) REFERENCES Evaluacion(id_evaluacion)
);

-- Tabla de Evaluacion
CREATE TABLE Evaluacion (
    id_evaluacion INT AUTO_INCREMENT PRIMARY KEY,
    id_lunes_eva1 int,
    id_martes_eva1 int,
    id_miercoles_eva1 int,
    id_jueves_eva1 int,
    id_viernes_eva1 int,
    id_savado_eva1 int,
    id_domingo_eva1 int,
    FOREIGN KEY (id_lunes_eva1) REFERENCES Lunes_Evaluacion_Semana1(id_lunes_eva1),
    FOREIGN KEY (id_martes_eva1) REFERENCES martes_Evaluacion_Semana1(id_martes_eva1),
    FOREIGN KEY (id_miercoles_eva1) REFERENCES miercoles_Evaluacion_Semana1(id_miercoles_eva1),
    FOREIGN KEY (id_jueves_eva1) REFERENCES jueves_Evaluacion_Semana1(id_jueves_eva1),
    FOREIGN KEY (id_viernes_eva1) REFERENCES viernes_Evaluacion_Semana1(id_viernes_eva1),
    FOREIGN KEY (id_savado_eva1) REFERENCES savado_Evaluacion_Semana1(id_savado_eva1),
    FOREIGN KEY (id_domingo_eva1) REFERENCES domingo_Evaluacion_Semana1(id_domingo_eva1)
);

-- Tabla de Lunes_Evaluacion_Semana1
CREATE TABLE Lunes_Evaluacion_Semana1 (
    id_lunes_eva1 INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    inicio DATETIME,
    fin DATETIME
);

-- Tabla de martes_Evaluacion_Semana1
CREATE TABLE martes_Evaluacion_Semana1 (
    id_martes_eva1 INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    inicio DATETIME,
    fin DATETIME
);

-- Tabla de miercoles_Evaluacion_Semana1
CREATE TABLE miercoles_Evaluacion_Semana1 (
    id_miercoles_eva1 INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    inicio DATETIME,
    fin DATETIME
);

-- Tabla de jueves_Evaluacion_Semana1
CREATE TABLE jueves_Evaluacion_Semana1 (
    id_jueves_eva1 INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    inicio DATETIME,
    fin DATETIME
);

-- Tabla de viernes_Evaluacion_Semana1
CREATE TABLE viernes_Evaluacion_Semana1 (
    id_viernes_eva1 INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    inicio DATETIME,
    fin DATETIME
);

-- Tabla de savado_Evaluacion_Semana1
CREATE TABLE savado_Evaluacion_Semana1 (
    id_savado_eva1 INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    inicio DATETIME,
    fin DATETIME
);

-- Tabla de domingo_Evaluacion_Semana1
CREATE TABLE domingo_Evaluacion_Semana1 (
    id_domingo_eva1 INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    inicio DATETIME,
    fin DATETIME
);

-- Tabla de Evaluacion
CREATE TABLE Semanas (
    id_semana INT AUTO_INCREMENT PRIMARY KEY,
    id_lunes_1 int,
    id_martes_1 int,
    id_miercoles_1 int,
    id_jueves_1 int,
    id_viernes_1 int,
    id_savado_1 int,
    id_domingo_1 int,
    FOREIGN KEY (id_lunes_1) REFERENCES Lunes_Semana1(id_lunes_1),
    FOREIGN KEY (id_martes_1) REFERENCES martes_Semana1(id_martes_1),
    FOREIGN KEY (id_miercoles_1) REFERENCES miercoles_Semana1(id_miercoles_1),
    FOREIGN KEY (id_jueves_1) REFERENCES jueves_Semana1(id_jueves_1),
    FOREIGN KEY (id_viernes_1) REFERENCES viernes_Semana1(id_viernes_1),
    FOREIGN KEY (id_savado_1) REFERENCES savado_Semana1(id_savado_1),
    FOREIGN KEY (id_domingo_1) REFERENCES domingo_Semana1(id_domingo_1)
);

-- Tabla de Lunes_Semana1
CREATE TABLE Lunes_Semana1 (
    id_lunes_1 INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    inicio DATETIME,
    fin DATETIME
);

-- Tabla de martes_Semana1
CREATE TABLE martes_Semana1 (
    id_martes_1 INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    inicio DATETIME,
    fin DATETIME
);

-- Tabla de miercoles_Semana1
CREATE TABLE miercoles_Semana1 (
    id_miercoles_1 INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    inicio DATETIME,
    fin DATETIME
);

-- Tabla de jueves_Semana1
CREATE TABLE jueves_Semana1 (
    id_jueves_1 INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    inicio DATETIME,
    fin DATETIME
);

-- Tabla de viernes_Semana1
CREATE TABLE viernes_Semana1 (
    id_viernes_1 INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    inicio DATETIME,
    fin DATETIME
);

-- Tabla de savado_Semana1
CREATE TABLE savado_Semana1 (
    id_savado_1 INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    inicio DATETIME,
    fin DATETIME
);

-- Tabla de domingo_Semana1
CREATE TABLE domingo_Semana1 (
    id_domingo_1 INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    inicio DATETIME,
    fin DATETIME
);

CREATE TABLE Carreras (
    id_carrera INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100),
    id_curso int,
	FOREIGN KEY (id_curso) REFERENCES Cursos(id_curso)

);

-- Tabla de Cursos----------------------------------------------
CREATE TABLE Cursos (
    id_curso INT AUTO_INCREMENT PRIMARY KEY,
    nombre_curso VARCHAR(100),
    descripcion TEXT,
    id_profesor INT,
    FOREIGN KEY (id_profesor) REFERENCES Profesores(id_profesor)
);

-- Tabla de Sesiones de Curso
CREATE TABLE Sesiones_Curso (
    id_sesion INT AUTO_INCREMENT PRIMARY KEY,
    id_curso INT,
    fecha_inicio DATETIME,
    duracion_minutos INT,
    descripcion TEXT,
    FOREIGN KEY (id_curso) REFERENCES Cursos(id_curso)
);

-- Tabla de Evaluaciones
CREATE TABLE Evaluaciones (
    id_evaluacion INT AUTO_INCREMENT PRIMARY KEY,
    id_curso INT,
    nombre_evaluacion VARCHAR(100),
    fecha_evaluacion DATETIME,
    FOREIGN KEY (id_curso) REFERENCES Cursos(id_curso)
);
