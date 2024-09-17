const mensajeExito = document.querySelector('.mensaje-exito');
const mensajeError = document.querySelector('.mensaje-error');

// Función para ocultar los mensajes después de 4 segundos
function ocultarMensaje(elemento) {
    if (elemento) {
        setTimeout(function() {
            elemento.style.visibility = 'hidden'; // Ocultar el mensaje
        }, 3000); // 3000 ms = 3 segundos
    }
}

// Ocultar los mensajes si existen
ocultarMensaje(mensajeExito);
ocultarMensaje(mensajeError);
