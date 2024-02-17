import smtplib
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
from email.mime.application import MIMEApplication
import schedule
import time

def enviar_correo(destinatario, asunto, cuerpo_html, adjunto=None):
    remitente = '1364822@senati.pe'
    clave = 'JC221101f'
    servidor_smtp = 'smtp-mail.outlook.com'
    puerto_smtp = 587

    mensaje = MIMEMultipart()
    mensaje['From'] = remitente
    mensaje['To'] = destinatario
    mensaje['Subject'] = asunto

    # Cambia 'plain' a 'html' aquí
    mensaje.attach(MIMEText(cuerpo_html, 'html'))

    if adjunto:
        with open(adjunto, 'rb') as archivo:
            adjunto_mime = MIMEApplication(archivo.read(), _subtype="pdf")
            adjunto_mime.add_header('Content-Disposition', f'attachment; filename={adjunto}')
            mensaje.attach(adjunto_mime)

    try:
        with smtplib.SMTP(servidor_smtp, puerto_smtp) as servidor:
            servidor.starttls()
            servidor.login(remitente, clave)
            servidor.sendmail(remitente, destinatario, mensaje.as_string())
        print(f'Correo enviado a {destinatario} - {time.strftime("%Y-%m-%d %H:%M:%S")}')
    except Exception as e:
        print(f'Error al enviar el correo a {destinatario}: {str(e)}')

def programar_envio_correo(destinatario, asunto, cuerpo_html, adjunto=None, hora_programada=None):
    if not hora_programada:
        enviar_correo(destinatario, asunto, cuerpo_html, adjunto)
        return

    schedule.every().day.at(hora_programada).do(enviar_correo, destinatario, asunto, cuerpo_html, adjunto)

    while True:
        schedule.run_pending()
        time.sleep(1)

# Ejemplo de uso
destinatario = 'cacereshilasacajhack@gmail.com'
asunto = 'Asunto del correo'
cuerpo_html = '<html><body><p>Hola, este es un correo HTML.</p></body></html>'
adjunto = 'archivo.pdf'
hora_programada = '16:15'

programar_envio_correo(destinatario, asunto, cuerpo_html, adjunto, hora_programada)
