import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

# Datos del remitente y servidor SMTP para Outlook.com
remitente_email = '1364822@senati.pe'  # Cambia a tu dirección de correo de Outlook.com
remitente_password = 'JC221101f'  # Cambia a tu contraseña
servidor_smtp = 'smtp-mail.outlook.com'
puerto_smtp = 587

# Lista de destinatarios
destinatarios = ['cacereshilasacajhack@gmail.com']

# Construir el mensaje
mensaje = MIMEMultipart()
mensaje['From'] = remitente_email
mensaje['To'] = ', '.join(destinatarios)
mensaje['Subject'] = 'Tarjeta de Presentación'

# Cuerpo del correo con diseño HTML y CSS
cuerpo_correo = """
<html>
  <head>
    <style>
      body {
        font-family: 'Arial', sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
        text-align: center;
      }

      .card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        margin: 50px auto;
        overflow: hidden;
        padding: 20px;
      }

      .title {
        color: #333;
        font-size: 24px;
        font-weight: bold;
      }

      .content {
        color: #666;
        font-size: 16px;
        margin-top: 10px;
      }

      .footer {
        margin-top: 20px;
        color: #999;
        font-size: 14px;
      }
    </style>
  </head>
  <body>
    <div class="card">
      <div class="title">Nombre Apellido</div>
      <div class="content">
        <p>Cargo</p>
        <p>Empresa</p>
        <p>Contacto: contacto@empresa.com</p>
      </div>
      <div class="footer">Este es un mensaje personalizado.</div>
    </div>
  </body>
</html>
"""

mensaje.attach(MIMEText(cuerpo_correo, 'html'))

# Configuración de la conexión SMTP
conexion_smtp = smtplib.SMTP(servidor_smtp, puerto_smtp)
conexion_smtp.starttls()
conexion_smtp.login(remitente_email, remitente_password)

# Envío del correo electrónico
conexion_smtp.sendmail(remitente_email, destinatarios, mensaje.as_string())

# Cierre de la conexión SMTP
conexion_smtp.quit()
