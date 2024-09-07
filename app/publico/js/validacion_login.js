document.addEventListener("DOMContentLoaded", function () {

    // Definición de expresiones regulares para validación
    const REGEX_CORREO = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const REGEX_CONTRASENA = /^(?=.*[A-Z])(?=.*\d)(?=.*[.,_\-!@#$%^&*])[a-zA-Z\d.,_\-!@#$%^&*]{4,100}$/;

    // Referencias directas a los elementos del formulario
    const correo = document.getElementById("correo");
    const contrasena = document.getElementById("contrasena");

    // Referencias a los elementos donde se mostrarán los mensajes de error
    const errorCorreo = document.getElementById("error-correo");
    const errorContrasena = document.getElementById("error-contrasena");

    // Función para validar un campo con una expresión regular
    function validarCampo(valor, regex) {
        return regex.test(valor.trim());
    }

    // Validación del correo electrónico
    function validarCorreo() {
        const esValido = validarCampo(correo.value, REGEX_CORREO);
        errorCorreo.textContent = esValido ? "" : "Ingrese un correo electrónico válido.";
        return esValido;
    }

    // Validación de la contraseña
    function validarContrasena() {
        const esValido = validarCampo(contrasena.value, REGEX_CONTRASENA);
        errorContrasena.textContent = esValido ? "" : "La contraseña debe tener entre 4 y 30 caracteres, incluyendo una mayúscula, un número y un símbolo.";
        return esValido;
    }

    // Asignación de eventos de validación a los campos
    correo.addEventListener("blur", validarCorreo);
    contrasena.addEventListener("blur", validarContrasena);

    // Manejo del envío del formulario
    document.querySelector(".formulario-login").addEventListener("submit", function (event) {
        const esFormularioValido = validarCorreo() && validarContrasena();
        if (!esFormularioValido) {
            event.preventDefault(); // Evita el envío del formulario si hay errores
        }
    });

});
