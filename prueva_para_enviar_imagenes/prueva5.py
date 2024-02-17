import os
import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email.mime.image import MIMEImage

# Configuración de cuentas y servidor SMTP
correo_emisor = '1364822@senati.pe'  # Cambiar por tu correo
contraseña_emisor = 'JC221101f'  # Cambiar por tu contraseña
servidor_smtp = 'smtp.office365.com'
puerto_smtp = 587

# Configuración del destinatario y mensaje
correo_receptor = 'cacereshilasacajhack@gmail.com'

# Ruta de la imagen
ruta_imagen = 'imajenes/imagen1.png'  # Ruta relativa a tu script

# Verificar si la imagen existe
if os.path.isfile(ruta_imagen):
    # Construir el mensaje personalizado para cada profesor con HTML y CSS
    mensaje = f"""
    <html>
    <head>
    <style>
        /* Estilos CSS aquí */
    </style>
    </head>
    <body>
        <p>¡Hola!</p>
        <p>Este es tu contenido personalizado.</p>
        <img src="cid:imagen1.png" alt="Logo">
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

    # Cargar la imagen como parte del mensaje y referenciarla en el HTML
    with open(ruta_imagen, 'rb') as img_file:
        imagen_adjunta = MIMEImage(img_file.read())
        imagen_adjunta.add_header('Content-ID', '<imagen1.png>')
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
else:
    print('La imagen no existe en la ruta especificada.')
