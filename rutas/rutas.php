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

    // Manejar acciones POST relacionadas con Citas
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

    // Manejar acciones GET relacionadas con Citas
    if (isset($_GET['accion']) && $_GET['accion'] == 'adminCitas') {
        $citasAdminControlador = new CitasAdminControlador();
        $citasAdminControlador->mostrarPanelAdministracion();
        exit;
    }
}

// Si no se reconoce la solicitud, redirigir a error
header('Location: /Final_php/app/vistas/errores/error_500.php');
exit;
