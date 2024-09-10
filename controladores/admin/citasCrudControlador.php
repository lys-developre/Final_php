<?php
require_once __DIR__ . '/../../modelos/citasModelo.php';

class CitasCrudControlador
{
    // Método para crear una cita
    public function crearCita()
    {
        if (isset($_POST['id_user'], $_POST['fecha'], $_POST['descripcion'])) {
            $id_user = $_POST['id_user'];
            $fecha = $_POST['fecha'];
            $descripcion = $_POST['descripcion'];

            $citasModelo = new CitasModelo();
            $resultado = $citasModelo->crearCita($id_user, $fecha, $descripcion);

            if ($resultado) {
                header('Location: rutas.php?accion=adminCitas&mensaje=cita_creada');
            } else {
                header('Location: rutas.php?accion=adminCitas&error=fallo_creacion');
            }
        }
    }

    // Método para eliminar una cita
    public function eliminarCita()
    {
        if (isset($_POST['id_cita'])) {
            $id_cita = $_POST['id_cita'];

            $citasModelo = new CitasModelo();
            $resultado = $citasModelo->eliminarCita($id_cita);

            if ($resultado) {
                header('Location: rutas.php?accion=adminCitas&mensaje=cita_eliminada');
            } else {
                header('Location: rutas.php?accion=adminCitas&error=fallo_eliminacion');
            }
        }
    }

    // Método para editar una cita
    public function editarCita()
    {
        if (isset($_POST['id_cita'], $_POST['fecha'], $_POST['descripcion'])) {
            $id_cita = $_POST['id_cita'];
            $fecha = $_POST['fecha'];
            $descripcion = $_POST['descripcion'];

            $citasModelo = new CitasModelo();
            $resultado = $citasModelo->editarCita($id_cita, $fecha, $descripcion);

            if ($resultado) {
                header('Location: rutas.php?accion=adminCitas&mensaje=cita_actualizada');
            } else {
                header('Location: rutas.php?accion=adminCitas&error=fallo_actualizacion');
            }
        }
    }
}

