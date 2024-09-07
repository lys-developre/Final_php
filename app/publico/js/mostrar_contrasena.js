// Mostrar u ocultar la contraseña

// Solo ejecutamos la función cuando el DOM esté cargado.
document.addEventListener("DOMContentLoaded", function () {
    
    // Seleccionar el checkbox y el campo de contraseña para el formulario de registro
    const mostrarContrasenaRegistro = document.getElementById("mostrar-contrasena-registro");
    const campoContrasenaRegistro = document.getElementById("contrasena-registro");

    //si los campos existen ejecutamos la funcion de cambio
    if (mostrarContrasenaRegistro && campoContrasenaRegistro) {
        mostrarContrasenaRegistro.addEventListener("change", function () {
            campoContrasenaRegistro.type = this.checked ? "text" : "password";
        });
    }

    // Seleccionar el checkbox y el campo de contraseña para el formulario de login
    const mostrarContrasenaLogin = document.getElementById("mostrar-contrasena-login");
    const campoContrasenaLogin = document.getElementById("contrasena-login");

    //si los campos existen ejecutamos la funcion de cambio
    if (mostrarContrasenaLogin && campoContrasenaLogin) {
        mostrarContrasenaLogin.addEventListener("change", function () {
            campoContrasenaLogin.type = this.checked ? "text" : "password";
        });
    }
});


// todo ver la repeticion de codigo , fijarme como no repetir