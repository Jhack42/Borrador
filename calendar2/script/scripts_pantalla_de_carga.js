// Función que se ejecuta cuando la página se ha cargado completamente
window.addEventListener('load', function() {
    // Ocultar la pantalla de carga
    document.getElementById('loader-wrapper').style.display = 'none';
    // Mostrar el contenido de la página
    document.getElementById('content').style.display = 'block';
});
