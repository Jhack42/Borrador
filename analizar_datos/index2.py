from http.server import HTTPServer, BaseHTTPRequestHandler

# Definir el manejador para procesar las solicitudes HTTP
class SimpleHTTPRequestHandler(BaseHTTPRequestHandler):
    def do_GET(self):
        # Definir la respuesta HTTP
        self.send_response(200)  # Código de respuesta: 200 OK
        self.send_header('Content-type', 'text/html')
        self.end_headers()
        
        # El contenido que se enviará como respuesta
        message = "¡Hola mundo desde Python! Este es mi primer servidor web."
        # Codificar el mensaje para enviarlo como bytes
        self.wfile.write(bytes(message, "utf8"))

# Definir la dirección IP y el puerto en el que se ejecutará el servidor
host = 'localhost'
port = 8000

# Crear una instancia del servidor HTTP
httpd = HTTPServer((host, port), SimpleHTTPRequestHandler)

# Mostrar un mensaje para indicar que el servidor está en ejecución
print(f"Servidor web activo en http://{host}:{port}")

# Iniciar el servidor y esperar las solicitudes entrantes
httpd.serve_forever()
