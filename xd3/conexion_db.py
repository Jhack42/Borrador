import mysql.connector

# Configuración de la conexión a la base de datos
config = {
    'user': 'usuariobdmaster',
    'password': '0&NZ[K^sQvxrbpAoUuec:4nx}6o(NnEN',
    'host': 'ls-cb055ae103843b7e39ee201ffc92e75020ab3b35.czsykmeayn9j.us-east-1.rds.amazonaws.com',
    'port': '3306',
    'database': 'NombreDeTuBaseDeDatos',  # Reemplaza con el nombre de tu base de datos
}

try:
    # Conexión a la base de datos
    connection = mysql.connector.connect(**config)

    if connection.is_connected():
        print("Conexión exitosa a la base de datos MySQL")

        # Crear una nueva base de datos
        cursor = connection.cursor()
        cursor.execute("CREATE DATABASE IF NOT EXISTS NombreDeTuBaseDeDatos")

        # Usar la nueva base de datos
        cursor.execute("USE NombreDeTuBaseDeDatos")

        # Crear tablas en la base de datos
        cursor.execute("""
            CREATE TABLE IF NOT EXISTS tabla1 (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(255),
                edad INT
            )
        """)

        cursor.execute("""
            CREATE TABLE IF NOT EXISTS tabla2 (
                id INT AUTO_INCREMENT PRIMARY KEY,
                descripcion VARCHAR(255),
                fecha DATE
            )
        """)

        print("Base de datos y tablas creadas exitosamente")

except mysql.connector.Error as error:
    print("Error al conectarse a la base de datos:", error)

finally:
    # Cierre de la conexión
    if 'connection' in locals() and connection.is_connected():
        connection.close()
        print("Conexión a la base de datos cerrada")
