function mostrarNotificacion() {
    if (Notification.permission === 'granted') {
        const notificacion = new Notification('¡Hola!', {
            body: 'Esta es una notificación de prueba.',
            icon: 'imagen/caracol_loading.png'
        });

        notificacion.onclick = function() {
            window.focus();
        };

        setTimeout(() => {
            notificacion.close();
        }, 5000);
    } else if (Notification.permission !== 'denied') {
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                mostrarNotificacion();
            }
        });
    }
}
