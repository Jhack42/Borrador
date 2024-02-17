document.getElementById('saludoForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita que se envíe el formulario por defecto
    
    // Obtiene los valores del formulario
    var nombre = document.getElementById('nombre').value;
    var edad = document.getElementById('edad').value;
    
    // Muestra el saludo
    var saludoContainer = document.getElementById('saludo-container');
    var saludoTexto = document.getElementById('saludoTexto');
    saludoTexto.textContent = 'Hola ' + nombre + '. Usted tiene ' + edad + ' años.';
    saludoContainer.style.display = 'block';
    
    // Oculta el formulario
    document.getElementById('form-container').style.display = 'none';
});
