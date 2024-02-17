import os
from sendgrid import SendGridAPIClient
from sendgrid.helpers.mail import Mail

# Configura tu clave API
sendgrid_key = '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'
sg = SendGridAPIClient(sendgrid_key)

# Construye tu correo electrónico
message = Mail(
    from_email='1364822@senati.pe',
    to_emails='cacereshilasacajhack@gmail.com',
    subject='Asunto del Correo',
    html_content='<p>Contenido del correo electrónico</p>')

# Envía el correo electrónico
response = sg.send(message)
print(response.status_code)
