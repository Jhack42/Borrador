import os
from sendgrid import SendGridAPIClient
from sendgrid.helpers.mail import Mail, Content, MimeType

# Obtén la clave API desde una variable de entorno
sendgrid_key = os.environ.get('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')

print("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", sendgrid_key)

if sendgrid_key is None:
    print("Error: No se ha configurado la clave API de SendGrid.")
else:
    # Crea el objeto SendGridAPIClient con la clave API
    sg = SendGridAPIClient(sendgrid_key)

    # Construye tu correo electrónico con una plantilla HTML
    html_content = """
    <html>
      <head>
        <title>Correo Electrónico Personalizado</title>
      </head>
      <body>
        <h1>¡Hola!</h1>
        <p>Este es un correo electrónico personalizado con contenido dinámico.</p>
        <p>Espero que encuentres útil este mensaje.</p>
      </body>
    </html>
    """

    message = Mail(
        from_email='1364822@senati.pe',
        to_emails='cacereshilasacajhack@gmail.com',
        subject='Asunto del Correo',
        content=Content(MimeType.html, html_content))

    # Envía el correo electrónico
    response = sg.send(message)
    print(response.status_code)
