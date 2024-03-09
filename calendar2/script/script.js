// Función para mostrar la ventana emergente si el usuario no está registrado
function mostrarVentanaNoRegistrado() {
    // Mostrar una ventana emergente con el mensaje
    alert('No estás registrado');
}

// Función para abrir el modal y cargar contenido externo
function abrirModal() {
    // Obtener el contenido del archivo otroarchivo.html mediante AJAX
    fetch('otroarchivo.html')
        .then(response => response.text())
        .then(data => {
            // Insertar el contenido en el modal
            document.getElementById('modalContent').innerHTML = data;
            // Mostrar el modal
            document.getElementById('myModal').style.display = 'block';
        })
        .catch(error => {
            console.error('Error al cargar el contenido:', error);
        });
}

// Función para cerrar el modal
function cerrarModal() {
    document.getElementById('myModal').style.display = 'none';
}

// Función para guardar la edición (puedes realizar acciones adicionales aquí)
function guardarEdicion() {
    // Obtener el contenido editado
    const contenidoEditado = document.getElementById('contenidoEditable').value;

    // Cerrar el modal después de guardar
    cerrarModal();
}

// Aquí puedes agregar más funciones JavaScript según sea necesario
