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
                header('Location: /vistas/error500.php');
                exit();
            }

            // Incluir la vista del perfil y pasar los datos del usuario
            include __DIR__ . '/../vistas/users/perfil.php';
        } else {
            // Redirigir al login si no hay sesión activa
            header('Location: /vistas/login.php');
            exit();
        }
    }

    // Método para actualizar el nombre de usuario
    public function actualizarPerfil()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtener los datos del formulario
            $id_user = $_SESSION['user_data']['id_user'];
            $nombre = trim($_POST['nombre']);
            $apellidos = trim($_POST['apellidos']);
            $email = trim($_POST['email']);
            $telefono = trim($_POST['telefono']);
            $direccion = trim($_POST['direccion']);
            $fecha_nacimiento = trim($_POST['fecha_nacimiento']); // Nuevo campo
            $sexo = trim($_POST['sexo']); // Nuevo campo

            // Validar que no estén vacíos
            if (empty($nombre) || empty($apellidos) || empty($email) || empty($telefono) || empty($direccion) || empty($fecha_nacimiento) || empty($sexo)) {
                header('/rutas/rutas.php?accion=mostrarPerfil&error=campos_vacios');
                exit();
            }

            // Actualizar los datos en la base de datos
            $resultado = $this->usuarioModelo->actualizarDatosPersonales($id_user, $nombre, $apellidos, $email, $telefono, $direccion, $fecha_nacimiento, $sexo);

            if ($resultado) {
                header('Location: /rutas/rutas.php?accion=mostrarPerfil&mensaje=datos_actualizados');
            } else {
                header('Location: /rutas/rutas.php?accion=mostrarPerfil&error=actualizacion_fallida');
            }
        }
    }
}
