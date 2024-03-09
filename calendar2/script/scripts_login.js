        // Obtener referencias a los elementos del DOM
        const errorMessage = document.getElementById('error-message');
        const correoInput = document.getElementById('correo');
        const contraseñaInput = document.getElementById('contraseña');

        // Agregar un event listener al formulario para controlar el envío
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar que el formulario se envíe

            // Obtener los valores de los campos de correo y contraseña
            const correoValue = correoInput.value.trim();
            const contraseñaValue = contraseñaInput.value.trim();

            // Limpiar los campos de correo y contraseña
            correoInput.value = '';
            contraseñaInput.value = '';

            // Mostrar el mensaje de error
            errorMessage.style.display = 'block';

            // Enfoque de vuelta al campo de correo
            correoInput.focus();
        });