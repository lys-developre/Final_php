<?php
// Iniciar la sesión para manejar errores y otros datos que puedan ser necesarios.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Incluir los archivos requeridos: el modelo de usuario y la configuración de manejo de errores.
require_once __DIR__ . '/../modelos/UsuarioModelo.php';
require_once __DIR__ . '/../config/errores.php';




// Clase controladora para manejar la validacion y el registro de usuarios.
class UsuarioControlador
{
    public function registrarUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registrarse'])) {
            $modelo = new UsuarioModelo();
            $errores = $modelo->validarRegistro($_POST);

            if (empty($errores)) {
                // PRIMERA CONSULTA A USER_DATA
                $resultadoUsuario = $modelo->insertarUsuario($_POST);

                if (isset($resultadoUsuario['error'])) {
                    if ($resultadoUsuario['error'] == 'usuario_duplicado') {

                        header('Location: /vistas/registro.php?mensaje=usuario_duplicado');
                    } else {
                        $_SESSION['errores'] = ['insert' => 'Error al crear usuario.'];
                        header('Location: /vistas/errores/error_500.php');
                    }
                    exit();
                }

                // SEGUNDA CONSULTA A USER_LOGIN
                $idUsuario = $resultadoUsuario['success'];
                $resultadoLogin = $modelo->insertarLogin($idUsuario, $_POST['usuario'], $_POST['contrasenaHasheada'], 'user');

                if (isset($resultadoLogin['error'])) {
                    if ($resultadoLogin['error'] == 'usuario_duplicado') {
                        header('Location: /vistas/registro.php?mensaje=usuario_duplicado');
                    } else {
                        $_SESSION['errores'] = ['insert' => 'Error al crear credenciales de inicio de sesión'];
                        header('Location: /vistas/errores/credenciales_incorrectas.php');
                    }
                    exit();
                }

                // Si todo fue exitoso
                header('Location: /vistas/login.php');
                header('Location: /vistas/login.php?mensaje=registro-exitoso');
                exit();
            } else {
                $_SESSION['errores'] = $errores;
                header('Location: /vistas/errores/error_500.php');
                exit();
            }
        }
    }
    public function registrarUsuarioDesdeAdmin()
    {
        // Obtener los datos del formulario
        $datos = [
            'nombre' => $_POST['nombre'],
            'apellidos' => $_POST['apellidos'],
            'email' => $_POST['email'],
            'usuario' => $_POST['usuario'],
            'contrasena' => $_POST['contrasena'],
            'telefono' => $_POST['telefono'],
            'fecha_nacimiento' => $_POST['fecha_nacimiento'],
            'direccion' => $_POST['direccion'],
            'sexo' => $_POST['sexo'],
            'rol' => $_POST['rol']
        ];

        // Crear instancia del modelo
        $usuarioModelo = new UsuarioModelo();

        // Validar los datos usando el método existente
        $errores = $usuarioModelo->validarRegistro($datos);

        if (!empty($errores)) {
            // Si hay errores, redirigir al formulario con los errores
            header("Location: /vistas/admin/usuarios.php?error=errores_validacion");
            exit();
        }

        // Insertar usuario en la tabla users_data
        $idUsuario = $usuarioModelo->insertarUsuarioDesdeAdmin($datos);

        if ($idUsuario) {
            // Encriptar la contraseña
            $contrasenaHasheada = password_hash($datos['contrasena'], PASSWORD_BCRYPT);

            // Insertar datos de login en la tabla users_login
            $resultadoLogin = $usuarioModelo->insertarLoginDesdeAdmin($idUsuario, $datos['usuario'], $contrasenaHasheada, $datos['rol']);

            if ($resultadoLogin) {
                // Usuario creado exitosamente
                header('Location: /rutas/rutas.php?accion=adminUsuarios&mensaje=exito-crear-usuario');
                exit();
            } else {
                // Error al insertar en users_login
                header('Location: /rutas/rutas.php?accion=adminUsuarios&mensaje=error-crear-usuario');
                exit();
            }
        } else {
            // Error al insertar en users_data
            header('Location: /rutas/rutas.php?accion=adminUsuarios&mensaje=error-crear-usuario');
            exit();
        }
    }
    public function mostrarUsuarios()
    {
        // Crear instancia del modelo
        $usuarioModelo = new UsuarioModelo();

        // Obtener todos los usuarios
        $usuarios = $usuarioModelo->obtenerTodosLosUsuarios();

        // Incluir la vista y pasarle los datos
        require_once __DIR__ . '/../vistas/admin/usuarios-administracion.php';
    }
    public function editarUsuario()
    {
        // Obtener los datos del formulario
        $contrasena = !empty($_POST['contrasena']) ? password_hash(trim($_POST['contrasena']), PASSWORD_BCRYPT) : null;

        $datos = [
            'id_user' => $_POST['id_user'],
            'nombre' => $_POST['nombre'],
            'apellidos' => $_POST['apellidos'],
            'email' => $_POST['email'],
            'telefono' => $_POST['telefono'],
            'fecha_nacimiento' => $_POST['fecha_nacimiento'],
            'direccion' => $_POST['direccion'],
            'sexo' => $_POST['sexo'],
            'usuario' => $_POST['usuario'],
            'rol' => $_POST['rol'],
            'contrasena' => $contrasena  // Contraseña encriptada o null si no se proporciona
        ];

        // Crear instancia del modelo
        $usuarioModelo = new UsuarioModelo();

        // Validar los datos
        $errores = $usuarioModelo->validarEdicionUsuario($datos);

        if (!empty($errores)) {
            // Guardar los errores en la sesión
            $_SESSION['errores'] = $errores;
            $_SESSION['datos_formulario'] = $datos;
            header('Location: /../../vistas/errores/error_500ccc.php');
            exit();
        }

        // Actualizar el usuario
        $resultado = $usuarioModelo->actualizarUsuario($datos);

        if ($resultado) {
            // Guardar mensaje de éxito en la sesión
            $_SESSION['mensaje_exito'] = 'Usuario actualizado correctamente.';
            header('Location: /rutas/rutas.php?accion=adminUsuarios&mensaje=exito-actualizar-usuario');
            exit();
        } else {
            // Guardar mensaje de error en la sesión
            $_SESSION['mensaje_error'] = 'Error al actualizar el usuario.';
            header('Location: /rutas/rutas.php?accion=adminUsuarios&mensaje=error-actualizar-usuario');
            exit();
        }
    }
    public function eliminarUsuario()
    {


        $id_user = $_POST['id_user'];

        // Crear instancia del modelo
        $usuarioModelo = new UsuarioModelo();

        // Eliminar el usuario
        $resultado = $usuarioModelo->eliminarUsuario($id_user);

        if ($resultado) {
            // Guardar mensaje de éxito en la sesión
            $_SESSION['mensaje_exito'] = 'Usuario eliminado correctamente.';
            header('Location: /rutas/rutas.php?accion=adminUsuarios&mensaje=usuario_eliminado');

            exit();
        } else {
            // Guardar mensaje de error en la sesión
            $_SESSION['mensaje_error'] = 'Error al eliminar el usuario.';
            header('Location: /rutas/rutas.php?accion=adminUsuarios&error=error_eliminacion');
            exit();
        }
    }
}
