import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email.mime.image import MIMEImage
import os

# Ruta de la imagen
ruta_imagen = 'imajenes/imagen1.png'  # Ruta relativa a tu script

# Verificar si la imagen existe
if os.path.isfile(ruta_imagen):
    with open(ruta_imagen, 'rb') as img_file:
        imagen_adjunta = MIMEImage(img_file.read())
        imagen_adjunta.add_header('Content-ID', '<imagen1.png>')
else:
    print('La imagen no existe en la ruta especificada:', ruta_imagen)

# Datos del remitente y servidor SMTP para Outlook.com
remitente_email = '1364822@senati.pe'  # Cambia a tu dirección de correo de Outlook.com
remitente_password = 'JC221101f'  # Cambia a tu contraseña
servidor_smtp = 'smtp-mail.outlook.com'
puerto_smtp = 587

# Lista de destinatarios
destinatarios = ['cacereshilasacajhack@gmail.com']

try:
    for destinatario_email in destinatarios:

        # Contenido del correo en HTML
        contenido_correo_html = f"""
        <html>
          <head>
            <!-- Estilos y estructura HTML -->
          </head>
          <body>
            <div>
              <!-- Contenido del correo -->
              <p>Este es un ejemplo de correo electrónico.</p>
            </div>
          </body>
        </html>
        """

        mensaje = MIMEMultipart("alternative")
        mensaje['From'] = remitente_email
        mensaje['To'] = destinatario_email
        mensaje['Subject'] = 'Asunto del correo'

        parte_html = MIMEText(contenido_correo_html, "html")
        mensaje.attach(parte_html)

        # Adjuntar la imagen al correo
        if 'imagen_adjunta' in locals():
            mensaje.attach(imagen_adjunta)

        # Envío de correos usando TLS (STARTTLS)
        with smtplib.SMTP(servidor_smtp, puerto_smtp) as servidor:
            servidor.starttls()
            servidor.login(remitente_email, remitente_password)
            servidor.sendmail(remitente_email, destinatario_email, mensaje.as_string())
        print(f'Correo enviado a {destinatario_email}')

except smtplib.SMTPException as e:
    print(f'Error al enviar correo: {e}')
