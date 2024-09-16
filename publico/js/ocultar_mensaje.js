const mensajeExito = document.querySelector('.mensaje-exito');
const mensajeError = document.querySelector('.mensaje-error');

// Función para ocultar los mensajes después de 4 segundos
function ocultarMensaje(elemento) {
    if (elemento) {
        setTimeout(function() {
            elemento.style.visibility = 'hidden'; // Ocultar el mensaje
        }, 4000); // 4000 ms = 4 segundos
    }
}

// Ocultar los mensajes si existen
ocultarMensaje(mensajeExito);
ocultarMensaje(mensajeError);
