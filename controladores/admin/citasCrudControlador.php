<?php

// Incluir el modelo para las citas y la configuración base
require_once __DIR__ . '/../../config/base_config.php'; // Incluyendo base_config.php
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
                header('Location: ' . BASE_URL . 'rutas/rutas.php?accion=adminCitas&mensaje=cita_creada');
                exit();
            } else {
                header('Location: ' . BASE_URL . 'rutas/rutas.php?accion=adminCitas&error=fallo_creacion');
                exit();
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
                header('Location: ' . BASE_URL . 'rutas/rutas.php?accion=adminCitas&mensaje=cita_eliminada');
                exit();
            } else {
                header('Location: ' . BASE_URL . 'rutas/rutas.php?accion=adminCitas&error=fallo_eliminacion');
                exit();
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
                header('Location: ' . BASE_URL . 'rutas/rutas.php?accion=adminCitas&mensaje=cita_actualizada');
                exit();
            } else {
                header('Location: ' . BASE_URL . 'rutas/rutas.php?accion=adminCitas&error=fallo_actualizacion');
                exit();
            }
        }
    }
}
