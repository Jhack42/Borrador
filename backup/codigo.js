// código.js
// Ejemplo: Cambiar el color de fondo de la sección "Proyectos" al hacer clic
const proyectos = document.getElementById('proyectos');

proyectos.addEventListener('click', function() {
    proyectos.style.backgroundColor = '#f0f0f0';
});

function enviarMensaje() {
    var userInput = document.getElementById("user-input").value;
    mostrarMensajeUsuario(userInput);

    var respuestaBot = obtenerRespuesta(userInput);
    mostrarMensajeBot(respuestaBot);


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
    var chatBox = document.getElementById("chat-box");
    chatBox.innerHTML += `<div class="mensaje-usuario">${mensaje}</div>`;
}

function mostrarMensajeBot(mensaje) {
    var chatBox = document.getElementById("chat-box");
    chatBox.innerHTML += `<div class="mensaje-bot">${mensaje}</div>`;
}
