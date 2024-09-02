document.addEventListener("DOMContentLoaded", function () {

    

    // Definición de constantes para las expresiones regulares utilizadas en la validación
    const REGEX_NOMBRE = /^[a-zA-ZÁÉÍÓÚÑáéíóúñ ]{2,45}$/;
    const REGEX_APELLIDOS = /^[a-zA-ZÁÉÍÓÚÑáéíóúñ ]{2,45}$/;
    const REGEX_CORREO = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const REGEX_TELEFONO = /^\+?\d{7,15}$/;
    const REGEX_CONTRASENA = /^(?=.*[A-Z])(?=.*\d)(?=.*[.,_\-!@#$%^&*])[a-zA-Z\d.,_\-!@#$%^&*]{4,30}$/;
    const REGEX_FECHA = /^\d{4}-\d{2}-\d{2}$/;
    const REGEX_DIRECCION = /^.{5,100}$/;

    // Referencias a los elementos del formulario
    const form = document.querySelector(".formulario-registro");

    //almacenamos en un objeto las referencias a los campos de el formulario
    const campos = {
        nombre: document.getElementById("nombre"),
        apellidos: document.getElementById("apellidos"),
        correo: document.getElementById("correo"),
        telefono: document.getElementById("telefono"),
        fecha_nacimiento: document.getElementById("fecha_nacimiento"),
        direccion: document.getElementById("direccion"),
        sexo: document.getElementById("sexo"),
        contrasena: document.getElementById("contrasena"),
    };

    // almacenamos en este objeto las referencias a los elementos que mostrarán los mensajes de error
    const mensajesError = {
        nombre: document.getElementById("error-nombre"),
        apellidos: document.getElementById("error-apellidos"),
        correo: document.getElementById("error-correo"),
        telefono: document.getElementById("error-telefono"),
        fecha_nacimiento: document.getElementById("error-fecha_nacimiento"),
        direccion: document.getElementById("error-direccion"),
        sexo: document.getElementById("error-sexo"),
        contrasena: document.getElementById("error-contrasena"),
    };

    // Con esta funcio validamos el campo usando la reguex , devuelve (true/false).
    function validarCampo(valor, regex) {
        return regex.test(valor.trim());
    }

    /*
    * Estas funciones validan los valores ingresados en los campos del formulario usando expresiones regulares.   
    * - Cada función (`validarNombre`, `validarCorreo`, etc.) llama a `validarCampo` para comprobar si el valor cumple con su regex.
    * - Si el valor es inválido, se muestra un mensaje de error; si es válido, el mensaje de error se limpia.
    * - esto lo usaremos para verificar si enviamos el formulario  o no y para ver si mostramos mensaje de error en los campos o no.
    */

    function validarNombre() {
        const esValido = validarCampo(campos.nombre.value, REGEX_NOMBRE);
        mensajesError.nombre.textContent = esValido ? "" : "El nombre debe tener entre 2 y 45 caracteres y solo contener letras.";
        return esValido;
    }

    function validarApellidos() {
        const esValido = validarCampo(campos.apellidos.value, REGEX_APELLIDOS);
        mensajesError.apellidos.textContent = esValido ? "" : "Los apellidos deben tener entre 2 y 45 caracteres y solo contener letras.";
        return esValido;
    }

    function validarCorreo() {
        const esValido = validarCampo(campos.correo.value, REGEX_CORREO);
        mensajesError.correo.textContent = esValido ? "" : "Ingrese un correo electrónico válido.";
        return esValido;
    }

    function validarTelefono() {
        const esValido = validarCampo(campos.telefono.value, REGEX_TELEFONO);
        mensajesError.telefono.textContent = esValido ? "" : "El número de teléfono debe contener entre 7 y 15 dígitos.";
        return esValido;
    }

    function validarFechaNacimiento() {
        const esValido = validarCampo(campos.fecha_nacimiento.value, REGEX_FECHA);
        mensajesError.fecha_nacimiento.textContent = esValido ? "" : "Ingrese una fecha válida en formato AAAA-MM-DD.";
        return esValido;
    }

    function validarDireccion() {
        const esValido = validarCampo(campos.direccion.value, REGEX_DIRECCION);
        mensajesError.direccion.textContent = esValido ? "" : "La dirección debe tener entre 5 y 100 caracteres.";
        return esValido;
    }

    function validarSexo() {
        const esValido = campos.sexo.value !== "";
        mensajesError.sexo.textContent = esValido ? "" : "Seleccione una opción de sexo.";
        return esValido;
    }

    function validarContrasena() {
        const esValido = validarCampo(campos.contrasena.value, REGEX_CONTRASENA);
        mensajesError.contrasena.textContent = esValido ? "" : "La contraseña debe tener entre 4 y 10 caracteres, incluyendo una mayúscula, un número y un símbolo.";
        return esValido;
    }

    // Asignamos los eventos de validacion cuando el usuario haga blur para mostrar o no si ingreso un campo erroneo.
    campos.nombre.addEventListener("blur", validarNombre);
    campos.apellidos.addEventListener("blur", validarApellidos);
    campos.correo.addEventListener("blur", validarCorreo);
    campos.telefono.addEventListener("blur", validarTelefono);
    campos.fecha_nacimiento.addEventListener("blur", validarFechaNacimiento);
    campos.direccion.addEventListener("blur", validarDireccion);
    campos.sexo.addEventListener("blur", validarSexo);
    campos.contrasena.addEventListener("blur", validarContrasena);



    // Manejamos el envio de el formulario , le agregamos una escucha de evento para que cuando el usuario quiera enviarlo solo pueda si todas las validaciones fueron con respuesta true, y si no es asi no lo enviaremos ademas de evitar que se envie por defecto.
    form.addEventListener("submit", function (event) {

        

        // Prevenir el envío hasta que todos los campos sean válidos
        const esFormularioValido = validarNombre() &&
            validarApellidos() &&
            validarCorreo() &&
            validarTelefono() &&
            validarFechaNacimiento() &&
            validarDireccion() &&
            validarSexo() &&
            validarContrasena();

        if (!esFormularioValido) {
            
            event.preventDefault(); // Evita el envío del formulario si hay errores
        }
        
    });

    // Mostrar u ocultar la contraseña
    document.getElementById("mostrar-contrasena").addEventListener("change", function () {
        campos.contrasena.type = this.checked ? "text" : "password";
    });
});
