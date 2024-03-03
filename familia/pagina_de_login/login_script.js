document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");

    loginForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Evita que se envíe el formulario por defecto

        // Validación de campos (puedes agregar tu lógica de validación aquí)
        const correo = document.getElementById("correo").value;
        const contraseña = document.getElementById("contraseña").value;

        if (correo.trim() === "" || contraseña.trim() === "") {
            alert("Por favor, completa todos los campos.");
            return;
        }

        // Envío del formulario
        // Puedes usar AJAX para enviar los datos del formulario al servidor
        // Aquí puedes agregar tu código AJAX para enviar los datos del formulario al servidor
        console.log("Datos del formulario:", correo, contraseña);
    });
});
