import os
from sendgrid import SendGridAPIClient
from sendgrid.helpers.mail import Mail

# Crear un objeto Mail con la información del mensaje
mensaje = Mail(
    from_email='1364822@senati.pe',
    to_emails='cacereshilasacajhack@gmail.com',
    subject='¡Enviar con Twilio SendGrid es divertido!',
    html_content='<strong>y fácil de hacer en cualquier lugar, incluso con Python</strong>'
)

try:
    # Configurar el cliente de SendGrid con la clave de API almacenada en una variable de entorno
    sg = SendGridAPIClient(os.environ.get('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'))

    # Enviar el mensaje utilizando el cliente de SendGrid
    respuesta = sg.send(mensaje)

    # Imprimir información sobre la respuesta
    print("Código de estado:", respuesta.status_code)
    print("Cuerpo de la respuesta:", respuesta.body)
    print("Encabezados de la respuesta:", respuesta.headers)

except Exception as e:
    # Capturar y manejar cualquier excepción que pueda ocurrir durante el envío
    print("Error:", str(e))
