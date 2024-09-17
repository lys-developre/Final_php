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
            // Crear una instancia del modelo UsuarioModelo
            $modelo = new UsuarioModelo();

            // Validar los datos del formulario y almacenar en errores si los hubo en la validacion.
            $errores = $modelo->validarRegistro($_POST);



            // Comprobamos si hay errores después de la validación
            if (empty($errores)) {

                // PRIMERA CONSULTA A USER_DATA
                // Insertar los datos del usuario en `users_data`
                $idUsuario = $modelo->insertarUsuario($_POST);

                // SEGUNDA CONSULTA A USER_LOGIN
                // Si la consulta en users_data fue exitosa y obtenemos el id_user
                if ($idUsuario) {


                    // Insertar los datos de login en `users_login`
                    $resultadoLogin = $modelo->insertarLogin($idUsuario, $_POST['usuario'], $_POST['contrasenaHasheada'], 'user');

                    if ($resultadoLogin) {
                        header('Location:/vistas/login.php');
                        exit();
                    } else {
                        $_SESSION['errores'] = ['insert' => 'Error al crear credenciales de inicio de sesión'];
                        header('Location:/vistas/errores/credenciales_incorrectas.php');
                        exit();
                    }
                } else {
                    // Si la primera consulta no fue exitosa
                    $_SESSION['errores'] = ['insert' => 'Error al crear usuario'];
                    header('Location:/vistas/errores/error_500.php');
                    exit();
                }
            } else {
                // Si hay errores en la validación mostramos un 500 en pantalla
                $_SESSION['errores'] = $errores;
                header('Location:/vistas/errores/error_500.php');
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
            $detallesErrores = urlencode(json_encode($errores));
            header("Location: /vistas/admin/usuarios.php?error=errores_validacion&detalles=$detallesErrores");
            exit();
        }

        // Si no hay errores, proceder a insertar el usuario
        $idUsuario = $usuarioModelo->insertarUsuario($datos);

        if ($idUsuario) {
            // Insertar datos de login
            $resultadoLogin = $usuarioModelo->insertarLogin($idUsuario, $datos['usuario'], $datos['contrasenaHasheada'], $datos['rol']);

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
        $datos = [
            'id_user' => $_POST['id_user'],
            'nombre' => $_POST['nombre'],
            'apellidos' => $_POST['apellidos'],
            'email' => $_POST['email'],
            'usuario' => $_POST['usuario'],
            'telefono' => $_POST['telefono'],
            'fecha_nacimiento' => $_POST['fecha_nacimiento'],
            'direccion' => $_POST['direccion'],
            'sexo' => $_POST['sexo'],
            'rol' => $_POST['rol']
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
            header('Location:  /rutas/rutas.php?accion=adminUsuarios&mensaje=exito-actualizar-usuario');
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
