<?php

class ModeloCrud {

    public function crearNoticia($titulo, $texto, $imagen, $id_user) {

        // Conexión a la base de datos
        $mysqli_conn = connectToDatabase();

        // Verificamos la conexión
        if ($mysqli_conn === null) {
            return false;
        }

        // Consulta SQL para insertar la noticia
        $sql = "INSERT INTO noticias (titulo, texto, imagen, id_user, fecha) 
                VALUES (?, ?, ?, ?, NOW())";

        // Preparamos la consulta
        $stmt = $mysqli_conn->prepare($sql);
        $stmt->bind_param('sssi', $titulo, $texto, $imagen, $id_user);

        // Ejecutamos la consulta
        $resultado = $stmt->execute();

        // Cerramos la conexión
        $stmt->close();
        $mysqli_conn->close();

        return $resultado;
    }

    public function eliminarNoticia($id_noticia)
{
    // Conexión a la base de datos
    $mysqli_conn = connectToDatabase();

    // Verificación de conexión
    if ($mysqli_conn === null) {
        return false;
    }

    // Consulta para eliminar la noticia
    $sql = "DELETE FROM noticias WHERE id_noticia = ?";
    $stmt = $mysqli_conn->prepare($sql);
    $stmt->bind_param('i', $id_noticia);

    // Ejecutar la consulta y devolver el resultado
    return $stmt->execute();
}

public function editarNoticia($id_noticia, $titulo, $texto, $imagen = null) {
    $mysqli_conn = connectToDatabase();
    
    $sql = "UPDATE noticias SET titulo = ?, texto = ? WHERE id_noticia = ?";
    $stmt = $mysqli_conn->prepare($sql);
    $stmt->bind_param('ssi', $titulo, $texto, $id_noticia);
    
    if ($imagen && $imagen['size'] > 0) {

        $nombreImagen = $imagen['name'];
        $rutaImagen = __DIR__ . '/../../uploads/noticias_img/' . basename($nombreImagen);


        move_uploaded_file($imagen['tmp_name'], $rutaImagen);
        $sql = "UPDATE noticias SET imagen = ? WHERE id_noticia = ?";
        $stmt = $mysqli_conn->prepare($sql);
        $stmt->bind_param('si', $nombreImagen, $id_noticia);
    }

    return $stmt->execute();
}


}
