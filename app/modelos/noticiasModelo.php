<?php

class NoticiasModelo {

// Función para obtener todas las noticias junto con el nombre del usuario
public function obtenerTodasLasNoticias() {
    // Reutilizamos la conexión de la base de datos.
    $conn = connectToDatabase();

    // Devolvemos un array vacío si no hay conexión
    if ($conn === null) {
        return [];
    }

    // Consulta SQL para obtener todas las noticias junto con el nombre del usuario que las creó
    $sql = "SELECT noticias.id_noticia, noticias.titulo, noticias.imagen, noticias.texto, noticias.fecha, users_data.nombre 
            FROM noticias
            JOIN users_data ON noticias.id_user = users_data.id_user
            ORDER BY noticias.fecha DESC";

    // Ejecutamos la consulta
    $resultado = $conn->query($sql);

    // Si hay resultados, los devolvemos como un array asociativo
    if ($resultado && $resultado->num_rows > 0) {
        return $resultado->fetch_all(MYSQLI_ASSOC);
    } else {
        // Devolvemos un array vacío si no hay noticias
        return [];
    }
}
}
