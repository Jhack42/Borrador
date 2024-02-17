import os
import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email.mime.image import MIMEImage
import requests
from io import BytesIO

# Configuración de cuentas y servidor SMTP
correo_emisor = '1364822@senati.pe'  # Cambiar por tu correo
contraseña_emisor = 'JC221101f'  # Cambiar por tu contraseña
servidor_smtp = 'smtp.office365.com'
puerto_smtp = 587

# Configuración del destinatario y mensaje
correo_receptor = 'cacereshilasacajhack@gmail.com'

# URL directa de la imagen en Google Drive
url_imagen = 'https://drive.google.com/uc?id=1Wic0oLqjqfwHeYqSkHoqXi5y335DPmDD'

# Descargar la imagen desde la URL
response = requests.get(url_imagen)
imagen_bytes = BytesIO(response.content)

# Construir el mensaje personalizado para cada profesor con HTML y CSS
mensaje = f"""
<html>
<head>
<style>
    /* Estilos CSS aquí */
    .logo {{
        position: absolute;
        top: 10px; /* Ajusta la posición vertical según tus preferencias */
        right: 10px; /* Ajusta la posición horizontal según tus preferencias */
        max-width: 100px; /* Ajusta el tamaño máximo según tus preferencias */
        height: auto;
    }}
</style>
</head>
<body>
    <p>¡Hola!</p>
    <p>Este es tu contenido personalizado.</p>
    <img class="logo" src="cid:imagen_incrustada" alt="Logo">
</body>
</html>
"""

# Configuración del mensaje MIME
mensaje_mime = MIMEMultipart()
mensaje_mime['From'] = correo_emisor
mensaje_mime['To'] = correo_receptor
mensaje_mime['Subject'] = 'Asunto del correo'

# Adjuntar el cuerpo del mensaje en formato HTML
mensaje_mime.attach(MIMEText(mensaje, 'html'))

# Añadir la imagen descargada como parte del mensaje y referenciarla en el HTML
imagen_adjunta = MIMEImage(imagen_bytes.read(), name='imagen.png')
imagen_adjunta.add_header('Content-ID', '<imagen_incrustada>')
mensaje_mime.attach(imagen_adjunta)

# Conectar al servidor SMTP y enviar el mensaje
try:
    servidor_smtp_obj = smtplib.SMTP(servidor_smtp, puerto_smtp)
    servidor_smtp_obj.starttls()
    servidor_smtp_obj.login(correo_emisor, contraseña_emisor)
    servidor_smtp_obj.sendmail(correo_emisor, correo_receptor, mensaje_mime.as_string())
    print('Correo enviado correctamente')
except Exception as e:
    print(f'Error al enviar el correo: {e}')
finally:
    servidor_smtp_obj.quit()
