<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portafolio - CV</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<!-- Sección con fondo de imagen -->
<!-- Imagen de perfil -->
<body>
    <!-- Contenido HTML aquí -->
    <img src="imajenes/perfil cara sin fondo.png" alt="Mi foto de perfil" class="foto-perfil">

    <header>

        <h1>Mi Portafolio</h1>
        <nav>
            <ul>
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#sobre-mi">Sobre Mí</a></li>
                <li><a href="#proyectos">Proyectos</a></li>
                <li><a href="#contacto">Contacto</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="inicio">
            <h2>Bienvenido a mi portafolio</h2>
            <p>¡Aquí encontrarás información sobre mi trayectoria, proyectos y más!</p>
        </section>
        <section id="sobre-mi">
            <h2>Sobre Mí</h2>
            <p>Aquí puedes escribir algo sobre ti, tu experiencia, habilidades, etc.</p>
        </section>
        <!-- Sección "Proyectos" -->
        <section id="proyectos">
            <h2>Proyectos</h2>
            <div class="proyecto">
                <h3>Nombre del Proyecto 1</h3>
                <p>Descripción del proyecto...</p>
            </div>
            <div class="proyecto">
                <h3>Nombre del Proyecto 2</h3>
                <p>Descripción del proyecto...</p>
            </div>
            <!-- Puedes agregar más proyectos aquí -->
        </section>
        <!-- Sección "Contacto" -->
        <section id="contacto">
            <h2>Contacto</h2>
            <p>Información de contacto: correo electrónico, redes sociales, etc.</p>
        </section>
    </main>
    <img src="boton-chat.png" alt="Botón de chat" id="boton-chat">

    <div class="chat-bot" id="chat-bot">
        <div class="chat-header">
            <h2>Chat Bot</h2>
            <button onclick="cerrarChat()">Cerrar</button>
        </div>
        <div class="chat-conversacion" id="chat-conversacion">
            <!-- Aquí aparecerán los mensajes del chat -->
        </div>
        <div class="chat-input">
            <input type="text" id="user-input" placeholder="Escribe aquí...">
            <button onclick="enviarMensaje()">Enviar</button>
        </div>
    </div>

    <!-- Enlace a un archivo JavaScript externo -->
    <script src="codigo.js"></script>
</body>
</html>
