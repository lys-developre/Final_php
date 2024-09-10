<?php
require_once __DIR__ . '/../../modelos/citasModelo.php';



class CitasAdminControlador
{
    public function mostrarPanelAdministracion()
    {
        $citasModelo = new CitasModelo();
        $usuarios = $citasModelo->obtenerUsuarios();

        $citas = [];

        // Depuración: Verificar si se recibe el id_user en la solicitud POST
        if (isset($_POST['id_user'])) {
            var_dump($_POST['id_user']); // Mostrar el valor de id_user para depurar

            $id_user = $_POST['id_user'];
            $citas = $citasModelo->obtenerCitasPorUsuario($id_user);
        }

        // Cargar la vista de administración
        require_once __DIR__ . '/../../vistas/admin/citas-administracion.php';
    }


    public function mostrarCitasDeUsuario()
    {
        $citasModelo = new CitasModelo();
        $usuarios = $citasModelo->obtenerUsuarios();  // Para mostrar el listado de usuarios en la vista

        // Verificar si se ha enviado un ID de usuario
        if (isset($_POST['id_user'])) {
            $id_user = $_POST['id_user'];
            // Obtener las citas del usuario seleccionado
            $citas = $citasModelo->obtenerCitasPorUsuario($id_user);
        } else {
            $citas = []; // Si no hay usuario seleccionado, no hay citas que mostrar
        }

        // Cargar la vista de administración con las citas del usuario seleccionado
        require_once __DIR__ . '/../../vistas/admin/citas-administracion.php';
    }
}
