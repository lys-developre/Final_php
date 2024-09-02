<?php
// Incluir los archivos requeridos: el modelo de usuario y la configuración de manejo de errores.
require_once __DIR__ . '/../modelos/UsuarioModelo.php';
require_once __DIR__ . '/../config/errores.php';

// Iniciar la sesión para manejar errores y otros datos que puedan ser necesarios.
session_start();

echo '------------------------------los datos llegan hasta aquí!---------------';

// Clase controladora para manejar el registro de usuarios
class UsuarioControlador
{
    // Método para registrar un nuevo usuario
    public function registrarUsuario()
    {
        // Verificamos que la solicitud sea POST y que el formulario enviado sea el de registro
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registrarse'])) {

            // Ver los datos enviados por POST (para depuración)
            var_dump($_POST);
            
            // Crear una instancia del modelo UsuarioModelo
            $modelo = new UsuarioModelo();
            
            // Validar los datos del formulario
            $errores = $modelo->validarRegistro($_POST);

            // Si no hay errores, proceder con la inserción del usuario
            if (empty($errores)) {
                $resultado = $modelo->insertarUsuario($_POST);

                // Si la inserción fue exitosa, redirigir al formulario de login
                if ($resultado === true) {
                    header('Location: ../../../vistas/login.php');
                    exit();
                } else {
                    // Si hubo un error en la inserción, almacenar el error en la sesión y redirigir a una página de error
                    $_SESSION['errores'] = ['insert' => $resultado['error']];
                    header('Location: ../../../vistas/errores/error_500.php');
                    exit();
                }
            } else {
                // Si hubo errores de validación, almacenar los errores en la sesión y redirigir a una página de error
                $_SESSION['errores'] = $errores;
                header('Location: ../../../vistas/errores/error_500.php');
                exit();
            }
        } else {
            // Manejar el caso en que la solicitud no sea POST o el formulario no sea el esperado
            $_SESSION['errores'] = ['request' => 'Solicitud inválida'];
            header('Location: ../../../vistas/errores/error_500.php');
            exit();
        }
    }
}

// Instanciar el controlador y llamar al método registrarUsuario
$controlador = new UsuarioControlador();
$controlador->registrarUsuario();
