import subprocess
import os
import socket

# Ruta al directorio donde quieres ejecutar el script PHP
ruta_directorio = 'C:/Users/jhack/Documents/xampp/'

# Ruta al script PHP
ruta_script_php = 'C:/xampp/php/pear/PEAR/Installer/Role/script.php'

# Cambiar el directorio de trabajo actual
os.chdir(ruta_directorio)

# Incluir el archivo Common.php antes de ejecutar el script PHP
ruta_common_php = 'C:/xampp/php/pear/PEAR/Installer/Role/Common.php'
include_statement = f'require_once "{ruta_common_php}";'

# Mensaje antes de ejecutar el script PHP
print("Ejecutando el script PHP...")

# Ejecutar el script PHP
subprocess.call(['php', '-r', include_statement, ruta_script_php])

# Mensaje después de ejecutar el script PHP
print("El script PHP se ha ejecutado correctamente.")

# Obtener la dirección del localhost
host = socket.gethostname()
direccion_localhost = socket.gethostbyname(host)
print(f"La dirección del localhost es: http://{direccion_localhost}/")
