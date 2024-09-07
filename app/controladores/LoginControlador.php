<?php

// Iniciar la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Incluir los archivos requeridos de el modelo login y la configuracion de erroes.
require_once __DIR__ . '/../modelos/LoginModelo.php';
require_once __DIR__ . '/../config/errores.php';



// Clase controladora para manejar el login de usuarios
class LoginControlador
{
    // Método para iniciar sesión
    public function iniciarSesion()

    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['iniciar_sesion'])) {

            // Crear una instancia del modelo LoginModelo
            $modelo = new LoginModelo();

            // Validar las credenciales del usuario, utilizando el campo 'email' que está en el formulario
            $usuario = $modelo->verificarCredenciales($_POST['email'], $_POST['contrasena']);



            // Si las credenciales son correctas
            if ($usuario) {
                // Guardar los datos del usuario en la sesión
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_rol'] = $usuario['rol'];

                // Redirigir al dashboard o página principal
                header('Location: ../../../vistas/perfil.php');
                exit();
            } else {

                //DEPURACION , LOS ERRORES ME TRAEN HASTA ESTE ELSE!!----------------------////////////////////

                // Si las credenciales son incorrectas, almacenar un error en la sesión y redirigir al formulario de login
                $_SESSION['errores'] = ['login' => 'Credenciales incorrectas. Por favor, inténtelo de nuevo.'];
                header('Location: http://localhost:3000/app/vistas/errores/credenciales_incorrectas.php');
                exit();
            }






        } else {
            // Manejar el caso en que la solicitud no sea POST o el formulario no sea el esperado
            $_SESSION['errores'] = ['request' => 'Solicitud inválida'];
            header('Location: http://localhost/Final_php/app/vistas/login.php');
            exit();
        }
    }
}
