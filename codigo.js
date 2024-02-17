// Ejemplo: Cambiar el color de fondo de la sección "Proyectos" al hacer clic
const proyectos = document.getElementById('proyectos');
// Mostrar y ocultar el chat al hacer clic en la imagen del botón de chat
const chatContainer = document.getElementById('chat-container');

proyectos.addEventListener('click', function() {
    proyectos.style.backgroundColor = '#f0f0f0';
});

function mostrarChat() {
    if (chatContainer.style.display === 'none') {
        chatContainer.style.display = 'block';
    } else {
        chatContainer.style.display = 'none';
    }
}

function cerrarChat() {
    chatContainer.style.display = 'none';
}

function enviarMensaje() {
    var userInput = document.getElementById("user-input").value;
    mostrarMensajeUsuario(userInput);

    var respuestaBot = obtenerRespuesta(userInput);
    mostrarMensajeBot(respuestaBot);

    document.getElementById("user-input").value = ''; // Limpiar el input después de enviar el mensaje
}

function obtenerRespuesta(pregunta) {
    var respuesta = "Lo siento, no tengo una respuesta para eso.";

    // Preguntas y respuestas predefinidas
    if (pregunta.toLowerCase().includes("hola")) {
        respuesta = "¡Hola! ¿En qué puedo ayudarte?";
    } else if (pregunta.toLowerCase().includes("proyectos")) {
        respuesta = "Puedes ver mis proyectos en la sección 'Proyectos'.";
    } else if (pregunta.toLowerCase().includes("contacto")) {
        respuesta = "Puedes encontrarme en la sección 'Contacto'.";
    }
    // Añade más preguntas y respuestas aquí

    return respuesta;
}

function mostrarMensajeUsuario(mensaje) {
    var chatConversacion = document.getElementById("chat-box");
    chatConversacion.innerHTML += `<div class="mensaje-usuario">${mensaje}</div>`;
    chatConversacion.scrollTop = chatConversacion.scrollHeight; // Desplaza hacia abajo al agregar un nuevo mensaje
}

function mostrarMensajeBot(mensaje) {
    var chatConversacion = document.getElementById("chat-box");
    chatConversacion.innerHTML += `<div class="mensaje-bot">${mensaje}</div>`;
    chatConversacion.scrollTop = chatConversacion.scrollHeight; // Desplaza hacia abajo al agregar un nuevo mensaje
}
