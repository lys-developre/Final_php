<?php

// Incluir los archivos necesarios
require_once __DIR__ . '/../config/base_config.php'; // Incluyendo base_config.php
require_once __DIR__ . '/../modelos/noticiasModelo.php';

class NoticiasControlador {

    // Función para mostrar las noticias en la vista
    public function mostrarNoticias() {

        // Crear una instancia del modeloNoticias que nos traerá el array con las noticias de la base de datos.
        $noticiasModelo = new NoticiasModelo(); 

        // Usar la función obtener noticias del modelo para almacenar las noticias en la variable.
        $noticias = $noticiasModelo->obtenerTodasLasNoticias(); 

        require_once __DIR__ . '/../vistas/noticias.php'; // Cargar la vista para compartir las variables.
    }
}
