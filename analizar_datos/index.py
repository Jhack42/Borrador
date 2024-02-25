from http.server import BaseHTTPRequestHandler, HTTPServer
import pymysql

# Definir la conexión a la base de datos
DB_HOST = '127.0.0.1'
DB_USER = 'root'
DB_PASSWORD = ''
DB_NAME = 'seguimiento'

# Definir el manejador para procesar las solicitudes HTTP
class RequestHandler(BaseHTTPRequestHandler):
    def do_GET(self):
        # Conexión a la base de datos
        conexion = pymysql.connect(host=DB_HOST, user=DB_USER, password=DB_PASSWORD, database=DB_NAME)
        try:
            # Obtener los nombres de los profesores
            with conexion.cursor() as cursor:
                sql_profesores = "SELECT id_profesor, nombre FROM profesores"
                cursor.execute(sql_profesores)
                resultado_profesores = cursor.fetchall()

            # Mostrar formulario para seleccionar un profesor
            self.send_response(200)
            self.send_header('Content-type', 'text/html')
            self.end_headers()

            # Escribir el formulario HTML
            self.wfile.write(b"<html><head><title>Consulta de alumnos por profesor</title></head>")
            self.wfile.write(b"<body><h2>Consulta de alumnos por profesor</h2>")
            self.wfile.write(b"<form method='post' action=''>")
            self.wfile.write(b"<label for='profesor'>Seleccione un profesor:</label>")
            self.wfile.write(b"<select name='profesor' id='profesor'>")
            for row in resultado_profesores:
                self.wfile.write(f"<option value='{row[0]}'>{row[1]}</option>".encode('utf-8'))
            self.wfile.write(b"</select>")
            self.wfile.write(b"<button type='submit'>Consultar</button>")
            self.wfile.write(b"</form>")

            # Cerrar la conexión
            conexion.close()

        except pymysql.Error as e:
            self.send_response(500)
            self.send_header('Content-type', 'text/plain')
            self.end_headers()
            self.wfile.write(f"Error en la base de datos: {e}".encode('utf-8'))

    def do_POST(self):
        # Leer el cuerpo de la solicitud POST
        content_length = int(self.headers['Content-Length'])
        post_data = self.rfile.read(content_length).decode('utf-8')
        # Obtener el ID del profesor seleccionado del cuerpo de la solicitud
        id_profesor_seleccionado = post_data.split('=')[1]

        # Conexión a la base de datos
        conexion = pymysql.connect(host=DB_HOST, user=DB_USER, password=DB_PASSWORD, database=DB_NAME)
        try:
            # Consulta SQL para obtener los alumnos relacionados con el profesor seleccionado
            with conexion.cursor() as cursor:
                sql_alumnos = f"SELECT a.nombre AS nombre_alumno FROM profesores p INNER JOIN salon s ON p.id_profesor = s.id_profesor INNER JOIN clase c ON s.id_salon = c.id_salon INNER JOIN alumnos a ON c.id_alumno = a.id_alumno WHERE p.id_profesor = {id_profesor_seleccionado}"
                cursor.execute(sql_alumnos)
                resultado_alumnos = cursor.fetchall()

            # Consulta SQL para obtener el nombre del profesor seleccionado
            with conexion.cursor() as cursor:
                sql_nombre_profesor = f"SELECT nombre FROM profesores WHERE id_profesor = {id_profesor_seleccionado}"
                cursor.execute(sql_nombre_profesor)
                nombre_profesor = cursor.fetchone()[0]

            # Mostrar resultados de la consulta si se seleccionó un profesor
            self.send_response(200)
            self.send_header('Content-type', 'text/html')
            self.end_headers()
            self.wfile.write(b"<h3>Resultados:</h3>")
            self.wfile.write(f"El profesor {nombre_profesor} está en el salón 1 y sus alumnos son:<br>".encode('utf-8'))
            for row in resultado_alumnos:
                self.wfile.write(f"- {row[0]}<br>".encode('utf-8'))

        except pymysql.Error as e:
            self.send_response(500)
            self.send_header('Content-type', 'text/plain')
            self.end_headers()
            self.wfile.write(f"Error en la base de datos: {e}".encode('utf-8'))

        finally:
            conexion.close()

def main():
    # Definir la dirección IP y el puerto en el que se ejecutará el servidor
    host = 'localhost'
    port = 8000

    # Crear una instancia del servidor HTTP
    server = HTTPServer((host, port), RequestHandler)

    # Mostrar un mensaje para indicar que el servidor está en ejecución
    print(f"Servidor web activo en http://{host}:{port}")

    # Iniciar el servidor y esperar las solicitudes entrantes
    server.serve_forever()

if __name__ == "__main__":
    main()
