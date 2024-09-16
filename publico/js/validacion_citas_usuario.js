// Seleccionamos el formulario y los campos que se van a validar
const form = document.querySelector('#form');
const fechaInput = document.querySelector('#fecha');
const descripcionInput = document.querySelector('#descripcion');

// Función para validar el campo fecha

    function validateFecha(fecha) {
        if (fecha === '') {
            return false; // El campo está vacío
        }
        const hoy = new Date();
        const fechaSeleccionada = new Date(fecha);

        // Ajuste para considerar solo la fecha sin tiempo
        hoy.setHours(0, 0, 0, 0);

        return fechaSeleccionada >= hoy;
    }



// Función para validar el campo descripción
function validateDescripcion(descripcion) {
    let regex = /^.{10,}$/; // Expresión regular: al menos 10 caracteres
    return regex.test(descripcion);
}

// Función genérica de validación para cada campo
function validateOnBlur(inputElement, validator, errorMessage) {
    inputElement.addEventListener('blur', function () {
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
function limpiarErrores() {
    const errores = document.querySelectorAll('.mensaje-error');
    errores.forEach(function (error) {
        error.style.visibility = "hidden"; // Ocultamos el mensaje de error
        error.textContent = ''; // Limpiamos el contenido del error
    });
}

// Evento para capturar el envío del formulario
form.addEventListener('submit', function (e) {
    limpiarErrores(); // Limpiamos los errores previos antes de validar

    // Validamos cada campo del formulario
    let isFechaValid = validateFecha(fechaInput.value);
    let isDescripcionValid = validateDescripcion(descripcionInput.value);

    // Prevenimos el envío del formulario si algún campo no es válido
    if (!isFechaValid || !isDescripcionValid) {
        e.preventDefault(); // Detenemos el envío del formulario

        // Mostramos los mensajes de error correspondientes
        if (!isFechaValid) {

            fechaInput.nextElementSibling.textContent = "Debe seleccionar una fecha válida que no sea anterior a hoy.";
            fechaInput.nextElementSibling.style.visibility = "visible";

        }
        if (!isDescripcionValid) {
            descripcionInput.nextElementSibling.textContent = "La descripción debe tener al menos 10 caracteres.";
            descripcionInput.nextElementSibling.style.visibility = "visible";
        }
    }
});

// Ejecutamos la validación cuando el usuario pierde el foco ('blur') en los inputs
validateOnBlur(fechaInput, validateFecha, "Debe seleccionar una fecha válida que no sea anterior a hoy.");

validateOnBlur(descripcionInput, validateDescripcion, "La descripción debe tener al menos 10 caracteres.");
