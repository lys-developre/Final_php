<?php


// Configuración y conexión a la base de datos
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/errores.php';

// Controladores de Usuarios y Login
require_once __DIR__ . '/../controladores/UsuarioControlador.php';
require_once __DIR__ . '/../controladores/LoginControlador.php';

// Controladores de Noticias
require_once __DIR__ . '/../controladores/NoticiasControlador.php';
require_once __DIR__ . '/../controladores/admin/noticiasAdminControlador.php';
require_once __DIR__ . '/../controladores/admin/noticiasCrudControlador.php';

// Controladores de Citas
require_once __DIR__ . '/../controladores/admin/citasAdminControlador.php';
require_once __DIR__ . '/../controladores/admin/citasCrudControlador.php';
require_once __DIR__ . '/../controladores/users/citasUsersControlador.php';

//controlador de el perfil de el usuario
require_once __DIR__ . '/../controladores/PerfilControlador.php';


// Obtener la conexión a la base de datos
$mysqli_connection = connectToDatabase();

if ($mysqli_connection === null) {
    // Redirigir a una página de error si no hay conexión
    header('Location: ../vistas/errores/error_404.php');
    exit();
}

// Instanciar el controlador de login
$loginControlador = new LoginControlador($mysqli_connection);

// Verificar si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Manejar acciones POST relacionadas con Usuarios
    if (isset($_POST['registrarse'])) {
        $usuarioControlador = new UsuarioControlador();
        $usuarioControlador->registrarUsuario();
        exit;
    }
    if (isset($_POST['iniciar_sesion'])) {
        $usuario = $_POST['usuario'];
        $password = $_POST['contrasena'];
        $loginControlador->iniciarSesion($usuario, $password);
        exit;
    }

    // Manejar acciones POST relacionadas con Noticias
    $noticiasCrudControlador = new NoticiasCrud();
    if (isset($_POST['crear_noticia'])) {
        $noticiasCrudControlador->crearNoticia();
        exit;
    }
    if (isset($_POST['eliminar_noticia'])) {
        $noticiasCrudControlador->eliminarNoticia();
        exit;
    }
    if (isset($_POST['editar_noticia'])) {
        $noticiasCrudControlador->editarNoticia();
        exit;
    }

    // Manejar acciones POST relacionadas con Citas admin.
    $citasCrudControlador = new CitasCrudControlador();
    if (isset($_POST['crear_cita'])) {
        $citasCrudControlador->crearCita();
        exit;
    }
    if (isset($_POST['eliminar_cita'])) {
        $citasCrudControlador->eliminarCita();
        exit;
    }
    if (isset($_POST['editar_cita'])) {
        $citasCrudControlador->editarCita();
        exit;
    }
    if (isset($_POST['id_user'])) {
        $citasAdminControlador = new CitasAdminControlador();
        $citasAdminControlador->mostrarCitasDeUsuario();
        exit;
    }


    // Manejar acciones POST relacionadas con Citas user.
    $citasUsersControlador = new CitasUsersControlador();
    if (isset($_POST['crear_cita_usuario'])) {
        $citasUsersControlador->crearCita();
        exit;
    }
    if (isset($_POST['eliminar_cita_usuario'])) {
        $citasUsersControlador->eliminarCita();
        exit;
    }
    if (isset($_POST['editar_cita_usuario'])) {
        $citasUsersControlador->editarCita();
        exit;
    }





    // Manejar acciones POST relacionadas con el Perfil
    $perfilControlador = new PerfilControlador();
    if (isset($_POST['accion']) && $_POST['accion'] == 'actualizarDatosPersonales') {
        $perfilControlador->actualizarPerfil();
        exit();
    }
}



// Verificar si la solicitud es de tipo GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Manejar acciones GET relacionadas con Noticias
    if (isset($_GET['accion']) && $_GET['accion'] == 'mostrarNoticias') {
        $noticiasControlador = new NoticiasControlador();
        $noticiasControlador->mostrarNoticias();
        exit;
    }
    if (isset($_GET['accion']) && $_GET['accion'] == 'adminNoticias') {
        $noticiasAdminControlador = new NoticiasAdminControlador();
        $noticiasAdminControlador->mostrarPanelAdministracion();
        exit;
    }
    // Manejar acciones GET relacionadas con Citas admin
    if (isset($_GET['accion']) && $_GET['accion'] == 'adminCitas') {
        $citasAdminControlador = new CitasAdminControlador();
        $citasAdminControlador->mostrarPanelAdministracion();
        exit;
    }
    // Manejar acciones GET relacionadas con Citas usuario
    if (isset($_GET['accion']) && $_GET['accion'] == 'mostrarCitasUsuario') {
        require_once __DIR__ . '/../controladores/users/citasUsersControlador.php';
        $citasUsersControlador = new CitasUsersControlador();
        $citasUsersControlador->mostrarCitasDeUsuario();
        exit();
    }
    // Manejar acción de logout
    if (isset($_GET['accion']) && $_GET['accion'] == 'logout') {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Destruir todas las variables de sesión
        $_SESSION = array();

        // Si se desea destruir la sesión completamente, borrar también la cookie de sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Finalmente, destruir la sesión
        session_destroy();

        // Redirigir al usuario a la página de login
        header("Location: /index.php");
        exit();
    }






    // Manejar acciones GET relacionadas con el Perfil
    if (isset($_GET['accion']) && $_GET['accion'] == 'mostrarPerfil') {
        $perfilControlador = new PerfilControlador();
        $perfilControlador->mostrarPerfil();
        exit();
    }
}

// Si no se reconoce la solicitud, redirigir a error
header('Location:/vistas/errores/error_500.php');
exit;
