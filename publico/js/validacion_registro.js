// Seleccionamos las variables y los inputs del formulario
const register_form = document.querySelector(".formulario-registro");

const userName = document.querySelector("#nombre");
const userApellidos = document.querySelector("#apellidos");
const userEmail = document.querySelector("#correo");
const userUsuario = document.querySelector("#usuario");
const userTelefono = document.querySelector("#telefono");
const userFechaNacimiento = document.querySelector("#fecha_nacimiento");
const userDireccion = document.querySelector("#direccion");
const userSexo = document.querySelector("#sexo");
const userPassword = document.querySelector("#contrasena-registro");

// Funciones de validación con mensajes de error específicos
function validateName(name) {
  let regex = /^[a-zA-ZÁÉÍÓÚÑáéíóúñ ]{2,45}$/;
  if (!regex.test(name)) return "El nombre debe tener entre 2 y 45 caracteres alfabéticos.";
  return "";
}

function validateApellidos(apellidos) {
  let regex = /^[a-zA-ZÁÉÍÓÚÑáéíóúñ ]{2,45}$/;
  if (!regex.test(apellidos)) return "Los apellidos deben tener entre 2 y 45 caracteres alfabéticos.";
  return "";
}

function validateEmail(email) {
  let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!regex.test(email)) return "El correo electrónico no es válido.";
  return "";
}

function validateUsuario(usuario) {
  let regex = /^[a-zA-Z0-9]{4,20}$/;
  if (!regex.test(usuario)) return "El nombre de usuario debe tener entre 4 y 20 caracteres alfanuméricos.";
  return "";
}

function validateTelefono(telefono) {
  let regex = /^\+?\d{7,15}$/;
  if (!regex.test(telefono)) return "El teléfono debe tener entre 7 y 15 dígitos.";
  return "";
}

function validateFecha(fecha) {
  let regex = /^\d{4}-\d{2}-\d{2}$/;
  if (!regex.test(fecha)) return "La fecha de nacimiento debe estar en el formato AAAA-MM-DD.";
  return "";
}

function validateDireccion(direccion) {
  if (direccion.length < 5 || direccion.length > 100) return "La dirección debe tener entre 5 y 100 caracteres.";
  return "";
}

function validatePassword(password) {
  let regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[.,_\-!@#$%^&*])[a-zA-Z\d.,_\-!@#$%^&*]{4,100}$/;
  if (!regex.test(password)) return "La contraseña debe tener al menos una mayúscula, un número y un símbolo.";
  return "";
}

function validateSexo(sexo) {
  if (sexo === "") return "Selecciona una opción de sexo.";
  return "";
}

// Función para mostrar mensajes de error
function showError(inputElement, errorMessage) {
  let smallElement = inputElement.nextElementSibling;
  if (errorMessage) {
    inputElement.classList.add("input-error");
    smallElement.textContent = errorMessage;
    smallElement.style.visibility = "visible";
  } else {
    inputElement.classList.remove("input-error");
    smallElement.style.visibility = "hidden";
    smallElement.textContent = "";
  }
}

// Definimos las funciones de validación que se ejecutarán al salir del input
function validateOnBlur(inputElement, validator) {
  inputElement.addEventListener("blur", function () {
    let value = inputElement.value;
    let errorMessage = validator(value);
    showError(inputElement, errorMessage);
  });
}

// Capturamos el evento del envío del formulario para controlar si hay errores.
register_form.addEventListener("submit", function (e) {
  let isFormValid = true;

  let validations = [
    { input: userName, validator: validateName },
    { input: userApellidos, validator: validateApellidos },
    { input: userEmail, validator: validateEmail },
    { input: userUsuario, validator: validateUsuario },
    { input: userTelefono, validator: validateTelefono },
    { input: userFechaNacimiento, validator: validateFecha },
    { input: userDireccion, validator: validateDireccion },
    { input: userSexo, validator: validateSexo },
    { input: userPassword, validator: validatePassword },
  ];

  validations.forEach(({ input, validator }) => {
    let errorMessage = validator(input.value);
    showError(input, errorMessage);
    if (errorMessage) isFormValid = false;
  });

  if (!isFormValid) {
    // Prevenimos el envío del formulario si alguna validación falla
    e.preventDefault();
  }
});

// Ejecutamos las funciones de validación en el evento blur
validateOnBlur(userName, validateName);
validateOnBlur(userApellidos, validateApellidos);
validateOnBlur(userEmail, validateEmail);
validateOnBlur(userUsuario, validateUsuario);
validateOnBlur(userTelefono, validateTelefono);
validateOnBlur(userFechaNacimiento, validateFecha);
validateOnBlur(userDireccion, validateDireccion);
validateOnBlur(userPassword, validatePassword);
