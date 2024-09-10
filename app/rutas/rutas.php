<?php

// controladores de registro y login.
require_once __DIR__ . '/../controladores/UsuarioControlador.php';
require_once __DIR__ . '/../controladores/LoginControlador.php';
//controladores de noticias.
require_once __DIR__ . '/../controladores/NoticiasControlador.php';
require_once __DIR__ . '/../controladores/admin/noticiasAdminControlador.php';
require_once __DIR__ . '/../controladores/admin/noticiasCrudControlador.php';

//db conn y errores 
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


    // CREAR NOTICIA
    if (isset($_POST['crear_noticia'])) {
        $noticiasCrudControlador = new NoticiasCrud();
        $noticiasCrudControlador->crearNoticia();
        exit;
    }



    // ELIMINAR NOTICIA
    if (isset($_POST['eliminar_noticia'])) {
        $noticiasCrudControlador = new NoticiasCrud();
        $noticiasCrudControlador->eliminarNoticia();
        exit;
    }

    // EDITAR NOTICIA
    if (isset($_POST['editar_noticia'])) {
        $noticiasCrudControlador = new NoticiasCrud();
        $noticiasCrudControlador->editarNoticia();
        exit;
    }
}


// Verificar si la solicitud es de tipo GET para mostrar noticias
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Noticias
    if (isset($_GET['accion']) && $_GET['accion'] == 'mostrarNoticias') {
        $noticiasControlador = new NoticiasControlador();
        $noticiasControlador->mostrarNoticias();
        exit;
    }


    // Panel de administración de noticias
    if (isset($_GET['accion']) && $_GET['accion'] == 'adminNoticias') {
        $noticiasAdminControlador = new NoticiasAdminControlador();
        $noticiasAdminControlador->mostrarPanelAdministracion();
        exit;
    }
}

// Si la solicitud no es POST o no se reconoce la acción, redirigir a una página de error
header('Location: http://localhost/Final_php/app/vistas/errores/error_500.php');
exit;
