// script.js

document.addEventListener('DOMContentLoaded', function() {
    const formLogin = document.getElementById('form-login');

    if (formLogin) {
        formLogin.addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar que el formulario se envíe de forma predeterminada

            const formData = new FormData(formLogin); // Obtener datos del formulario

            // Enviar datos al servidor mediante AJAX
            fetch('login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    // Redireccionar a la página de perfil si el inicio de sesión fue exitoso
                    window.location.href = 'perfil.php';
                } else {
                    // Mostrar un mensaje de error si el inicio de sesión falla
                    console.error('Error en el inicio de sesión');
                }
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX:', error);
            });
        });
    }
});
