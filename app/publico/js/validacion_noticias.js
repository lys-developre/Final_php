// Seleccionamos el formulario y los campos que se van a validar
const form = document.querySelector('#form');
const tituloInput = document.querySelector('#titulo');
const textoInput = document.querySelector('#texto');
const imagenInput = document.querySelector('#imagen');

// Función para validar el campo título
// Verifica que el título tenga al menos 3 caracteres
function validateTitulo(titulo) {
    let regex = /^.{3,}$/; // Expresión regular: al menos 3 caracteres
    return regex.test(titulo);
}

// Función para validar el campo texto
// Verifica que el texto tenga al menos 10 caracteres
function validateTexto(texto) {
    let regex = /^.{10,}$/; // Expresión regular: al menos 10 caracteres
    return regex.test(texto);
}

// Función para validar la imagen
// Verifica que se haya seleccionado una imagen y que sea de formato válido (jpg, png)
function validateImagen(imagen) {
    if (imagen.files.length === 0) {
        return false; // Si no hay imagen, retorna falso
    } else {
        const archivo = imagen.files[0];
        const tiposValidos = ["image/jpeg", "image/png", "image/jpg"]; // Solo permitimos ciertos formatos
        return tiposValidos.includes(archivo.type); // Verificamos que el tipo de archivo esté en los permitidos
    }
}

// Función genérica de validación para cada campo
// Se ejecuta cuando el usuario pierde el foco de un input ('blur')
function validateOnBlur(inputElement, validator, errorMessage) {
    inputElement.addEventListener('blur', function() {
        let value = inputElement.type === 'file' ? inputElement : inputElement.value; // Diferenciamos entre archivos y textos
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
    let isTituloValid = validateTitulo(tituloInput.value);
    let isTextoValid = validateTexto(textoInput.value);
    let isImagenValid = validateImagen(imagenInput);

    // Prevenimos el envío del formulario si algún campo no es válido
    if (!isTituloValid || !isTextoValid || !isImagenValid) {
        e.preventDefault(); // Detenemos el envío del formulario

        // Mostramos los mensajes de error correspondientes
        if (!isTituloValid) {
            tituloInput.nextElementSibling.textContent = "El título debe tener al menos 3 caracteres.";
            tituloInput.nextElementSibling.style.visibility = "visible";
        }
        if (!isTextoValid) {
            textoInput.nextElementSibling.textContent = "El texto debe tener al menos 10 caracteres.";
            textoInput.nextElementSibling.style.visibility = "visible";
        }
        if (!isImagenValid) {
            imagenInput.nextElementSibling.textContent = "No se ingresó una imagen o el formato no es válido (solo jpg o png).";
            imagenInput.nextElementSibling.style.visibility = "visible";
        }
    }
});

// Ejecutamos la validación cuando el usuario pierde el foco ('blur') en los inputs
validateOnBlur(tituloInput, validateTitulo, "El título debe tener al menos 3 caracteres.");
validateOnBlur(textoInput, validateTexto, "El texto debe tener al menos 10 caracteres.");
validateOnBlur(imagenInput, validateImagen, "Formato de imagen no válido (solo jpg o png).");
