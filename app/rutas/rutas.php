<?php

// Incluir los controladores necesarios
require_once __DIR__ . '/../controladores/UsuarioControlador.php';
require_once __DIR__ . '/../controladores/LoginControlador.php';

require_once __DIR__ . '/../controladores/NoticiasControlador.php'; // Añadimos el controlador de noticias


require_once __DIR__ . '/../config/errores.php';
require_once __DIR__ . '/../config/config.php';


// Verificar si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Instanciar los controladores necesarios
    $usuarioControlador = new UsuarioControlador();


    $loginControlador = new LoginControlador($mysqli_connection);  //------//----revisar----//--------//??????



    //REGISTRARSE
    // Verificar si la acción es registrar un usuario   
    if (isset($_POST['registrarse'])) {
        // Llamar al método que maneja el registro de usuarios
        $usuarioControlador->registrarUsuario();
        exit;
    }



    // INICIAR SESION
    // Verificar si la acción es iniciar sesión
    if (isset($_POST['iniciar_sesion'])) {

        // Obtener los datos del formulario de login y los saneamos antes de continuar el proseso.
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = htmlspecialchars($_POST['contrasena']);

        // Llamar al método que maneja el inicio de sesión
        $loginControlador->iniciarSesion($email, $password);
        exit;
    }
}

//VERIFICAR NOTICIAS
// Verificar si la solicitud es de tipo GET para mostrar noticias
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Noticias
    if (isset($_GET['accion']) && $_GET['accion'] == 'mostrarNoticias') {
        $noticiasControlador = new NoticiasControlador(); // Instanciar el controlador de noticias
        $noticiasControlador->mostrarNoticias(); // Llamar al método para mostrar las noticias
        exit;
    }
}

// Si la solicitud no es POST o no se reconoce la acción, redirigir a una página de error
header('Location: http://localhost/Final_php/app/vistas/errores/error_500.php');
exit;
