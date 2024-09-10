<?php
// Incluimos el modelo de login
require_once __DIR__ . '/../modelos/LoginModelo.php';

// Incluimos la conexión a la base de datos y la muestra de errores
require_once __DIR__ . '/../config/errores.php';
require_once __DIR__ . '/../config/config.php';

// Asegurarnos de que la sesión esté iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class LoginControlador
{
    private $modelo;

    // Constructor que recibe la conexión de la base de datos
    public function __construct($mysqli_connection)
    {
        $this->modelo = new LoginModelo($mysqli_connection);
    }

    // Método para iniciar sesión
    public function iniciarSesion($usuario, $password)
    {



        // Validar los datos del formulario
        $errores = $this->validarDatosLogin($usuario, $password);

        if (!empty($errores)) {

            // Si hay errores, los mostramos al usuario
            $_SESSION['mensaje_error'] = implode("<br>", $errores);
            header("Location: ../vistas/login.php");
            exit();
        }



        // Obtener los datos del usuario desde el modelo
        $usuarioData = $this->modelo->obtenerUsuarioPorNombre($usuario);



        if ($usuarioData) {



            // Verificar si la contraseña ingresada coincide con el hash almacenado
            if (password_verify($password, $usuarioData['contrasena'])) {






                // Iniciar sesión y almacenar los datos del usuario en la sesión
                $_SESSION['user_data'] = $usuarioData;
                header("Location: ../vistas/users/profile.php(paginade`perfilEXITO)");
                exit();
            } else {
                // Si la contraseña es incorrecta
                $_SESSION['mensaje_error'] = "Contraseña incorrecta.";
                header("Location: ../vistas/login.php(contraseña incorrecta)");
                exit();
            }
        } else {
            // Si no se encuentra el usuario
            $_SESSION['mensaje_error'] = "No se encontró un usuario con ese nombre.";
            header("Location: ../vistas/login.php(noseencontroelsuaurioo)");
            exit();
        }
    }

    // Validar el nombre de usuario y la contraseña
    private function validarDatosLogin($usuario, $password)
    {
        $errores = [];

        // Validar que el nombre de usuario no esté vacío y tenga un formato válido
        if (empty($usuario) || !preg_match("/^[a-zA-ZÁÉÍÓÚÑáéíóúñ ]{2,45}$/", $usuario)) {
            $errores[] = "El nombre de usuario no es válido.";
        }

        // Validar que la contraseña tenga al menos 4 caracteres y cumpla con los requisitos de seguridad
        if (strlen($password) < 4 || !preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[.,_\-!@#$%^&*])[a-zA-Z\d.,_\-!@#$%^&*]{4,}$/', $password)) {
            $errores[] = "La contraseña debe tener al menos una mayúscula, un número y un símbolo.";
        }

        return $errores;
    }
}
