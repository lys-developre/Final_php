<?php

require_once __DIR__ . '/../modelos/UsuarioModelo.php';

class PerfilControlador
{
    private $usuarioModelo;

    // Constructor para inicializar el modelo
    public function __construct()
    {
        $this->usuarioModelo = new UsuarioModelo();
    }  
    
    // Método para mostrar el perfil del usuario
    public function mostrarPerfil()
    {
        // Verificar que hay un usuario logueado
        if (isset($_SESSION['user_data']['id_user'])) {
            $id_user = $_SESSION['user_data']['id_user'];
            $usuario = $this->usuarioModelo->obtenerUsuarioPorId($id_user);

            // Si no se encontraron datos del usuario
            if (!$usuario) {
                header('Location: /MisProyectos/app/vistas/error.php');
                exit();
            }

            // Incluir la vista del perfil y pasar los datos del usuario
            include __DIR__ . '/../vistas/users/perfil.php';
        } else {
            // Redirigir al login si no hay sesión activa
            header('Location: /MisProyectos/app/vistas/login.php');
            exit();
        }
    }

    // Método para actualizar el nombre de usuario
    public function actualizarPerfil()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nuevo_usuario = trim($_POST['usuario']);
            $id_user = $_SESSION['user_data']['id_user'];

            // Validar que el nombre de usuario no esté vacío
            if (empty($nuevo_usuario)) {
                header('Location: /rutas/rutas.php?accion=mostrarPerfil&error=usuario_vacio');
                exit();
            }

            // Actualizar el nombre de usuario en la base de datos
            $resultado = $this->usuarioModelo->actualizarNombreUsuario($id_user, $nuevo_usuario);

            if ($resultado) {
                // Actualizar el nombre de usuario en la sesión
                $_SESSION['user_data']['usuario'] = $nuevo_usuario;

                header('Location: /rutas/rutas.php?accion=mostrarPerfil&mensaje=perfil_actualizado');
            } else {
                header('Location: /rutas/rutas.php?accion=mostrarPerfil&error=actualizacion_fallida');
            }
        }
    }
}
