<?php

class NoticiasModelo {

    // Función para obtener todas las noticias de la base de datos
    public function obtenerTodasLasNoticias() {

        //reutilizamos la coneccion de la base de datos.
        $conn = connectToDatabase();

        // Devolvemos un array vacío si no hay conexión
        if ($conn === null) {
            return []; 
        }

        //SI LA CONEXION FUE EXITOSA.

        // Consulta SQL para obtener todas las noticias en orden de fecha descendente.
        $sql = "SELECT * FROM noticias ORDER BY fecha DESC";
        $resultado = $conn->query($sql);

        // Si hay resultados, los devolvemos como un array asociativo
        if ($resultado && $resultado->num_rows > 0) {

            // Devolvemos el array con los valores de las noticias.
            return $resultado->fetch_all(MYSQLI_ASSOC);

        } else {

             // Devolvemos un array vacío si no hay noticias
            return [];
        }
    }
}
