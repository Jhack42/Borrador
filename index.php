<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portafolio - CV</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<head>
    <style>
        :root {
            --primary-color: #ff6b6b; /* Rojo */
            --secondary-color: #5f27cd; /* Morado */
            --border-color: #e0e0e0; /* Gris claro para bordes */
            --background-color: #f9f9f9; /* Gris claro */
        }

        .custom-section {
            background-color: #ffffff; /* Blanco */
            border: 2px solid #64fdf0; /* Cambia el color del borde a rojo */
            border-radius: 10px;
            padding: 20px;
            margin: 20px auto; /* Centra el contenido en el medio */
            max-width: 1000px; /* Limita el ancho máximo del contenido */
            transition: transform 0.3s ease-in-out;
        }

        body {
            background-color: var(--background-color);
            text-align: center;
            margin: 0;
            font-family: 'Arial', sans-serif;
            transition: background-color 0.5s ease-in-out;
        }
    </style>
</head>

<!-- Sección con fondo de imagen -->
<!-- Imagen de perfil -->
<body>
    <div class="custom-section">
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
                <p>Estudiante de Ingeniería de Software con Inteligencia Artificial del instituto de Senati, Guito Ciclo. <br>Uso de las tecnologías de la información y las comunicaciones.</p>
            </section>
            <!-- Sección "Proyectos" -->
            <section id="proyectos">
                <h2>Proyectos</h2>
                <div class="proyecto">
                <h3>CRUD en PHP con Tablas Relacionales</h3>
                <p>El diseño web es fundamental para la interacción del usuario. <br>Busca la usabilidad y mejora la experiencia del usuario. <br>Un diseño atractivo y funcional marca la diferencia en la interacción con el usuario.</p>
                <a href="https://github.com/Jhack42/CRUD-en-PHP-con-tablas-relacionales" target="_blank">Enlace al proyecto en GitHub</a>
                <a href="CRUD-en-PHP-con-tablas-relacionales/index.php" class="boton">Ir a index.php</a>
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
    <!-- Botón de chat -->
    <img src="imajenes/chatbot.png" alt="Imagen del chat bot" onclick="mostrarChat()" width="50" id="chatbot-btn">

    <!-- Sección del chat oculta inicialmente -->
    <div class="chat-container" id="chat-container" style="display: none;">
        <div class="chat-header">
            <h2>Chat</h2>
        </div>
        <div class="chat-box" id="chat-box">
            <!-- Aquí aparecerán los mensajes -->
        </div>
        <div class="chat-input">
            <input type="text" id="user-input" placeholder="Escribe aquí...">
            <button onclick="enviarMensaje()">Enviar</button>
        </div>
    </div>

        <!-- Enlace a un archivo JavaScript externo -->
        <script src="codigo.js"></script>
    </div>
</body>
</html>
