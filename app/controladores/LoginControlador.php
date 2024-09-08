<?php

require_once __DIR__ . '/../modelos/LoginModelo.php';  // Incluir el modelo de login
require_once __DIR__ . '/../config/errores.php';  // Manejo de errores

// Asegurarnos de que la sesión esté iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class LoginControlador
{
    private $modelo;

    // Constructor que recibe la conexión de la base de datos
    public function __construct($db_connection)
    {
        $this->modelo = new LoginModelo($db_connection);
    }

    // Método para iniciar sesión
    public function iniciarSesion($email, $password)
    {
        // Validar los datos del formulario
        $errores = $this->validarDatosLogin($email, $password);

        if (!empty($errores)) {
            // Si hay errores, los mostramos al usuario
            $_SESSION['mensaje_error'] = implode("<br>", $errores);
            header("Location: ../vistas/login.php");
            exit();
        }

        // Obtener los datos del usuario desde el modelo
        $usuario = $this->modelo->obtenerUsuarioPorCorreo($email);



        if ($usuario) {

                // Mostrar los datos que llegan a la variable $usuario
    echo "<pre>";
    var_dump($usuario['contrasena']);  // O puedes usar print_r($usuario)
    echo "</pre>";
    exit();  // Detenemos la ejecución aquí para ver los datos

            // Verificar si la contraseña ingresada coincide con el hash almacenado
            if (password_verify($password, $usuario['contrasena'])) {
                // Iniciar sesión y almacenar los datos del usuario en la sesión
                $_SESSION['user_data'] = $usuario;
                header("Location: ../vistas/users/profile.php");
                exit();
            } else {
                // Si la contraseña es incorrecta
                $_SESSION['mensaje_error'] = "Contraseña incorrecta.";
                header("Location: ../vistas/contraseñaincorrecta");
                exit();
            }
        } else {
            // Si no se encuentra el usuario
            $_SESSION['mensaje_error'] = "No se encontró un usuario con ese correo electrónico.";
            header("Location: ../vistas/noseencontroelusuario");
            exit();
        }
    }

    // Validar el correo electrónico y la contraseña
    private function validarDatosLogin($email, $password)
    {
        $errores = [];

        // Validar que el correo sea correcto
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo electrónico no tiene un formato válido.";
        }

        // Validar que la contraseña tenga al menos 4 caracteres y cumpla con los requisitos de seguridad
        if (strlen($password) < 4 || !preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[.,_\-!@#$%^&*])[a-zA-Z\d.,_\-!@#$%^&*]{4,}$/', $password)) {
            $errores[] = "La contraseña debe tener al menos una mayúscula, un número y un símbolo.";
        }

        return $errores;
    }
}
