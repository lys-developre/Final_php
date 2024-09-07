<?php

// Incluir los controladores necesarios
require_once __DIR__ . '/../controladores/UsuarioControlador.php';
require_once __DIR__ . '/../controladores/LoginControlador.php';
require_once __DIR__ . '/../config/errores.php';

// Verificar si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    // Instanciar los controladores necesarios
    $usuarioControlador = new UsuarioControlador();
    $loginControlador = new LoginControlador();

    // Verificar si la acción es registrar un usuario   
    if (isset($_POST['registrarse'])) {
        // Llamar al método que maneja el registro de usuarios
        $usuarioControlador->registrarUsuario();
        exit;
    }

    // Verificar si la acción es iniciar sesión
    if (isset($_POST['iniciar_sesion'])) {
        // Llamar al método que maneja el inicio de sesión
        $loginControlador->iniciarSesion();
        exit;
    }

}

// Si la solicitud no es POST o no se reconoce la acción, redirigir a una página de error
header('Location: http://localhost/Final_php/app/vistas/errores/error_500.php');
exit;


