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




// Definimos las funciones que nos permitirán realizar la validación de los inputs
function validateName(name) {
  let regex = /^[a-zA-ZÁÉÍÓÚÑáéíóúñ ]{2,45}$/;
  return regex.test(name);
}

function validateApellidos(apellidos) {
  let regex = /^[a-zA-ZÁÉÍÓÚÑáéíóúñ ]{2,45}$/;
  return regex.test(apellidos);
}

function validateEmail(email) {
  let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return regex.test(email);
}

function validateUsuario(usuario) {
  let regex = /^[a-zA-Z0-9]{4,20}$/; 
  return regex.test(usuario);
}

function validateTelefono(telefono) {
  let regex = /^\+?\d{7,15}$/;
  return regex.test(telefono);
}

function validateFecha(fecha) {
  let regex = /^\d{4}-\d{2}-\d{2}$/;
  return regex.test(fecha);
}

function validateDireccion(direccion) {
  return direccion.length >= 5 && direccion.length <= 100;
}

function validatePassword(password) {
  let regex =
    /^(?=.*[A-Z])(?=.*\d)(?=.*[.,_\-!@#$%^&*])[a-zA-Z\d.,_\-!@#$%^&*]{4,100}$/;
  return regex.test(password);
}

function validateSexo(sexo) {
  return sexo !== "";
}

// Definimos las funciones de validación que se ejecutarán al salir del input
function validateOnBlur(inputElement, validator) {
  inputElement.addEventListener("blur", function () {
    let value = inputElement.value;
    let valid = validator(value);
    let smallElement = inputElement.nextElementSibling; // Encuentra el siguiente span para el error

    if (!valid) {
      smallElement.textContent = "Error: El contenido introducido no es válido";
      smallElement.style.color = "red";
      smallElement.style.visibility = "visible";
    } else {
      smallElement.style.visibility = "hidden"; // Escondemos el campo
      smallElement.textContent = ""; // Limpiamos el campo
    }
  });
}

// Capturamos el evento del envío del formulario para controlar si hay errores.
register_form.addEventListener("submit", function (e) {
  let isNameValid = validateName(userName.value);
  let isApellidosValid = validateApellidos(userApellidos.value);
  let isEmailValid = validateEmail(userEmail.value);
  let isUsuarioValid = validateUsuario(userUsuario.value);
  let isTelefonoValid = validateTelefono(userTelefono.value);
  let isFechaValid = validateFecha(userFechaNacimiento.value);
  let isDireccionValid = validateDireccion(userDireccion.value);
  let isSexoValid = validateSexo(userSexo.value);
  let isPasswordValid = validatePassword(userPassword.value);

  if (
    !isNameValid ||
    !isApellidosValid ||
    !isEmailValid ||
    !isUsuarioValid ||
    !isTelefonoValid ||
    !isFechaValid ||
    !isDireccionValid ||
    !isSexoValid ||
    !isPasswordValid
  ) {
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
