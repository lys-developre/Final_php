<?php
require_once __DIR__ . '/../../modelos/noticiasModelo.php';
class NoticiasAdminControlador
{

    public function mostrarPanelAdministracion()
    {

        // Creamos una instancia del modelo
        $noticiasModelo = new NoticiasModelo();

        // Obtenemos todas las noticias
        $noticias = $noticiasModelo->obtenerTodasLasNoticias();


        // Pasamos las noticias a la vista
        require_once __DIR__ . '/../../vistas/admin/noticias-administracion.php';
    }
}
