// Seleccionamos el formulario y los campos que se van a validar
const form = document.querySelector('#form');
const usuarioInput = document.querySelector('#usuario');
const fechaInput = document.querySelector('#fecha');
const descripcionInput = document.querySelector('#descripcion');

// Función para validar el campo usuario
// Verifica que se haya seleccionado un usuario
function validateUsuario(usuario) {
    return usuario !== ''; // Verifica que no esté vacío
}

// Función para validar el campo fecha
// Verifica que se haya seleccionado una fecha válida
function validateFecha(fecha) {
    return fecha !== ''; // Verifica que no esté vacío
}

// Función para validar el campo descripción
// Verifica que la descripción tenga al menos 10 caracteres
function validateDescripcion(descripcion) {
    let regex = /^.{10,}$/; // Expresión regular: al menos 10 caracteres
    return regex.test(descripcion);
}

// Función genérica de validación para cada campo
// Se ejecuta cuando el usuario pierde el foco de un input ('blur')
function validateOnBlur(inputElement, validator, errorMessage) {
    inputElement.addEventListener('blur', function() {
        let value = inputElement.value; // Obtenemos el valor del input
        let valid = validator(value); // Llamamos al validador correspondiente
        let smallElement = inputElement.nextElementSibling; // Seleccionamos el siguiente elemento (donde se mostrará el error)

        if (!valid) {
            smallElement.textContent = errorMessage; // Mostramos el mensaje de error
            smallElement.style.color = "red";
            smallElement.style.visibility = "visible"; // Hacemos visible el error
        } else {
            smallElement.style.visibility = "hidden"; // Ocultamos el mensaje si es válido
            smallElement.textContent = ''; // Limpiamos el campo de error
        }
    });
}

// Función para limpiar los errores previos
// Elimina los mensajes de error antes de realizar una nueva validación
function limpiarErrores() {
    const errores = document.querySelectorAll('.mensaje-error');
    errores.forEach(function(error) {
        error.style.visibility = "hidden"; // Ocultamos el mensaje de error
        error.textContent = ''; // Limpiamos el contenido del error
    });
}

// Evento para capturar el envío del formulario
// Valida todos los campos al enviar el formulario
form.addEventListener('submit', function(e) {
    limpiarErrores(); // Limpiamos los errores previos antes de validar

    // Validamos cada campo del formulario
    let isUsuarioValid = validateUsuario(usuarioInput.value);
    let isFechaValid = validateFecha(fechaInput.value);
    let isDescripcionValid = validateDescripcion(descripcionInput.value);

    // Prevenimos el envío del formulario si algún campo no es válido
    if (!isUsuarioValid || !isFechaValid || !isDescripcionValid) {
        e.preventDefault(); // Detenemos el envío del formulario

        // Mostramos los mensajes de error correspondientes
        if (!isUsuarioValid) {
            usuarioInput.nextElementSibling.textContent = "Debe seleccionar un usuario.";
            usuarioInput.nextElementSibling.style.visibility = "visible";
        }
        if (!isFechaValid) {
            fechaInput.nextElementSibling.textContent = "Debe seleccionar una fecha válida.";
            fechaInput.nextElementSibling.style.visibility = "visible";
        }
        if (!isDescripcionValid) {
            descripcionInput.nextElementSibling.textContent = "La descripción debe tener al menos 10 caracteres.";
            descripcionInput.nextElementSibling.style.visibility = "visible";
        }
    }
});

// Ejecutamos la validación cuando el usuario pierde el foco ('blur') en los inputs
validateOnBlur(usuarioInput, validateUsuario, "Debe seleccionar un usuario.");
validateOnBlur(fechaInput, validateFecha, "Debe seleccionar una fecha válida.");
validateOnBlur(descripcionInput, validateDescripcion, "La descripción debe tener al menos 10 caracteres.");
