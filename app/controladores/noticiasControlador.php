<?php

// requerimos los archivos nesesarios
require_once '../modelos/noticiasModelo.php';

class NoticiasControlador {

    // Función para mostrar las noticias en la vista
    public function mostrarNoticias() {

        // creamos una instancia de el modeloNoticias que nos traera el array con las noticias de la base de datos.
        $noticiasModelo = new NoticiasModelo(); 

        // Usamos la funcion obtener noticias de el modelo para almasenar las noticias en la variable.
        $noticias = $noticiasModelo->obtenerTodasLasNoticias(); 

        require_once '../vistas/noticias.php'; // Cargamos la vista para compartir las variables.
    }
}
