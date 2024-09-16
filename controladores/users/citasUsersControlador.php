<?php
// Iniciar la sesión al principio del archivo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../modelos/citasModelo.php';

class CitasUsersControlador
{
    public function mostrarCitasDeUsuario() {
        // Comprobar si la sesión está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Iniciamos la sesión si aún no está iniciada
        }
    
        // Comprobar si la sesión contiene los datos de usuario
        if (isset($_SESSION['user_data']['id_user'])) {
            $id_user = $_SESSION['user_data']['id_user'];
            $nombre_usuario = $_SESSION['user_data']['usuario'];
        } else {
            // Redirigir al login si no hay sesión activa
            header('Location: ../vistas/login.php');
            exit();
        }
    
        // Obtener las citas del usuario
        $citasModelo = new CitasModelo();
        $citas = $citasModelo->obtenerCitasPorUsuario($id_user);
    
        // Pasar las variables a la vista
        include __DIR__ . '/../../vistas/users/citaciones.php';
    }

    // Método para crear una cita
    public function crearCita()
    {
        if (isset($_POST['fecha'], $_POST['descripcion'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $id_user = $_SESSION['user_data']['id_user'];
            $fecha_cita = $_POST['fecha'];
            $motivo_cita = $_POST['descripcion'];

            $citasModelo = new CitasModelo();
            $resultado = $citasModelo->crearCita($id_user, $fecha_cita, $motivo_cita);

            if ($resultado) {
                // Redirigir a través del controlador
                header('Location: /rutas/rutas.php?accion=mostrarCitasUsuario&mensaje=cita_creada');
                exit();
            } else {
                // Redirigir con mensaje de error
                header('Location: /rutas/rutas.php?accion=mostrarCitasUsuario&error=fallo_creacion');
                exit();
            }
        }
    }

    // Método para eliminar una cita
    public function eliminarCita()
    {
        if (isset($_POST['id_cita'])) {
            $id_cita = $_POST['id_cita'];

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $id_user = $_SESSION['user_data']['id_user'];

            $citasModelo = new CitasModelo();
            $citas = $citasModelo->obtenerCitasPorUsuario($id_user);

            $encontrada = false;
            foreach ($citas as $citaUsuario) {
                if ($citaUsuario['id_cita'] == $id_cita) {
                    $encontrada = true;
                    break;
                }
            }

            if ($encontrada) {
                $resultado = $citasModelo->eliminarCita($id_cita);
                if ($resultado) {
                    // Redirigir a través del controlador
                    header('Location: /rutas/rutas.php?accion=mostrarCitasUsuario&mensaje=cita_eliminada');
                    exit();
                } else {
                    // Redirigir con mensaje de error
                    header('Location: /rutas/rutas.php?accion=mostrarCitasUsuario&error=fallo_eliminacion');
                    exit();
                }
            } else {
                // Redirigir con mensaje de no autorizado
                header('Location: /rutas/rutas.php?accion=mostrarCitasUsuario&error=no_autorizado');
                exit();
            }
        }
    }

    // Método para editar una cita
    public function editarCita()
    {
        if (isset($_POST['id_cita'], $_POST['fecha'], $_POST['descripcion'])) {
            $id_cita = $_POST['id_cita'];
            $fecha_cita = $_POST['fecha'];
            $motivo_cita = $_POST['descripcion'];

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $id_user = $_SESSION['user_data']['id_user'];

            $citasModelo = new CitasModelo();
            $citas = $citasModelo->obtenerCitasPorUsuario($id_user);

            $encontrada = false;
            foreach ($citas as $citaUsuario) {
                if ($citaUsuario['id_cita'] == $id_cita) {
                    $encontrada = true;
                    break;
                }
            }

            if ($encontrada) {
                $resultado = $citasModelo->editarCita($id_cita, $fecha_cita, $motivo_cita);
                if ($resultado) {
                    // Redirigir a través del controlador
                    header('Location: /rutas/rutas.php?accion=mostrarCitasUsuario&mensaje=cita_actualizada');
                    exit();
                } else {
                    // Redirigir con mensaje de error
                    header('Location: /rutas/rutas.php?accion=mostrarCitasUsuario&error=fallo_actualizacion');
                    exit();
                }
            } else {
                // Redirigir con mensaje de no autorizado
                header('Location: /rutas/rutas.php?accion=mostrarCitasUsuario&error=no_autorizado');
                exit();
            }
        }
    }
}
