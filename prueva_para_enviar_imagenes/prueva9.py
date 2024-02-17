import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email.mime.image import MIMEImage
import base64

# Datos del remitente y servidor SMTP para Outlook.com
remitente_email = '1364822@senati.pe'  # Cambia a tu dirección de correo de Outlook.com
remitente_password = 'JC221101f'  # Cambia a tu contraseña
servidor_smtp = 'smtp-mail.outlook.com'
puerto_smtp = 587

# Lista de destinatarios
destinatarios = ['cacereshilasacajhack@gmail.com']

# Ruta de la imagen de perfil
ruta_imagen = 'C:\\xampp\\htdocs\\Borrador\\prueva_para_enviar_imagenes\\imajenes\\escine.jpg'

# Leer la imagen y convertirla a base64
with open(ruta_imagen, 'rb') as imagen_file:
    imagen_base64 = base64.b64encode(imagen_file.read()).decode('utf-8')

# Construir el mensaje
mensaje = MIMEMultipart()
mensaje['From'] = remitente_email
mensaje['To'] = ', '.join(destinatarios)
mensaje['Subject'] = 'Tarjeta de Presentación con Imagen'

# Cuerpo del correo con diseño HTML y CSS y la imagen embebida
cuerpo_correo = f"""
<html>
  <head>
    <style>
      body {{
        font-family: 'Arial', sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
        text-align: center;
      }}

      .card {{
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        margin: 50px auto;
        overflow: hidden;
        padding: 20px;
      }}

      .title {{
        color: #333;
        font-size: 24px;
        font-weight: bold;
      }}

      .content {{
        color: #666;
        font-size: 16px;
        margin-top: 10px;
      }}

      .footer {{
        margin-top: 20px;
        color: #999;
        font-size: 14px;
      }}

      .profile-img {{
        width: 100%;
        border-radius: 50%;
        margin-top: 20px;
      }}
    </style>
  </head>
  <body>
    <div class="card">
      <img src="data:image/jpg;base64,{imagen_base64}" alt="Imagen de Perfil" class="profile-img">
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
