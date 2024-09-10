<?php

//requerimos el modelo para el crud.
require_once __DIR__ . '/../../modelos/admin/noticiasCrudModelo.php';

class NoticiasCrud
{

    // Método para crear una noticia
    public function crearNoticia()
    {
        // Verificamos que se han recibido los datos necesarios
        if (isset($_POST['titulo']) && isset($_POST['texto']) && isset($_FILES['imagen'])) {

            $titulo = $_POST['titulo'];
            $texto = $_POST['texto'];
            $imagen = $_FILES['imagen'];

            // Validamos los datos
            $errores = $this->validarDatosNoticia($titulo, $texto, $imagen);

            if (empty($errores)) {
                // Guardamos la imagen en la carpeta correspondiente
                $nombreImagen = $imagen['name'];
                $rutaImagen = '../../uploads/noticias_img/' . basename($nombreImagen);
                move_uploaded_file($imagen['tmp_name'], $rutaImagen);

                // Obtenemos el id del usuario desde la sesión (preparado pero no activo)
                $id_user = $_SESSION['id_user'] ?? 1;  // Simulando por ahora

                // Creamos una instancia del modelo y llamamos a la función para crear la noticia
                $noticiasModelo = new ModeloCrud();
                $resultado = $noticiasModelo->crearNoticia($titulo, $texto, $nombreImagen, $id_user);

                if ($resultado) {
                    // Redirigimos al panel de administración con un mensaje de éxito
                    header('Location: rutas.php?accion=adminNoticias&mensaje=noticia_creada');
                } else {
                    // Si algo falla, mostramos un error
                    header('Location: rutas.php?accion=adminNoticias&error=fallo_creacion');
                }
            } else {
                // Redirigimos con los errores si la validación falla
                header('Location: rutas.php?accion=adminNoticias&error=errores_validacion&detalles=' . json_encode($errores));
            }
        } else {
            // Si faltan datos, redirigimos con un error
            header('Location: rutas.php?accion=adminNoticias&error=faltan_datos');
        }
    }

    public function eliminarNoticia()
    {
        if (isset($_POST['id_noticia'])) {
            $id_noticia = $_POST['id_noticia'];

            // Creamos una instancia del modelo y llamamos a la función para eliminar la noticia
            $noticiasModelo = new ModeloCrud();
            $resultado = $noticiasModelo->eliminarNoticia($id_noticia);

            if ($resultado) {
                // Redirigimos con un mensaje de éxito
                header('Location: rutas.php?accion=adminNoticias&mensaje=noticia_eliminada');
            } else {
                // Si algo falla, mostramos un error
                header('Location: rutas.php?accion=adminNoticias&error=fallo_eliminacion');
            }
        } else {
            // Si no se recibe el id, mostramos un error
            header('Location: rutas.php?accion=adminNoticias&error=faltan_datos');
        }
    }


    public function editarNoticia()
    {
        if (isset($_POST['id_noticia']) && isset($_POST['titulo']) && isset($_POST['texto'])) {
            $id_noticia = $_POST['id_noticia'];
            $titulo = $_POST['titulo'];
            $texto = $_POST['texto'];
            $imagen = $_FILES['imagen'];

            // Validar los datos como lo hicimos en crearNoticia

            // Actualizar la noticia en la base de datos
            $noticiasModelo = new ModeloCrud();
            $resultado = $noticiasModelo->editarNoticia($id_noticia, $titulo, $texto, $imagen);

            if ($resultado) {
                header('Location: rutas.php?accion=adminNoticias&mensaje=noticia_actualizada');
            } else {
                header('Location: rutas.php?accion=adminNoticias&error=fallo_actualizacion');
            }
        } else {
            header('Location: rutas.php?accion=adminNoticias&error=faltan_datos');
        }
    }


    // Método para validar los datos de una noticia
    private function validarDatosNoticia($titulo, $texto, $imagen)
    {
        // Array para almacenar los errores
        $errores = [];

        // Definimos las regex y las reglas para validar los campos
        $TITULO_REGEX = "/^.{3,100}$/"; // Entre 3 y 100 caracteres
        $TEXTO_REGEX = "/^.{10,}$/"; // Al menos 10 caracteres
        $TIPOS_IMAGEN = ["image/jpeg", "image/png", "image/jpg"];

        // Validación del título
        if (!preg_match($TITULO_REGEX, $titulo)) {
            $errores['titulo'] = "El título debe contener entre 3 y 100 caracteres.";
        }

        // Validación del texto
        if (!preg_match($TEXTO_REGEX, $texto)) {
            $errores['texto'] = "El texto debe tener al menos 10 caracteres.";
        }

        // Validación de la imagen 
        if (!isset($imagen['name']) || empty($imagen['name'])) {
            $errores['imagen'] = "Es obligatorio subir una imagen.";
        } else {
            // Verificamos el tipo de archivo
            if (!in_array($imagen['type'], $TIPOS_IMAGEN)) {
                $errores['imagen'] = "El formato de imagen no es válido. Solo se permiten jpg o png.";
            }

            // Verificamos el tamaño del archivo
            if ($imagen['size'] > 2 * 1024 * 1024) {
                $errores['imagen'] = "El tamaño de la imagen no debe exceder los 2MB.";
            }
        }

        // Retornamos los errores
        return $errores;
    }
}
