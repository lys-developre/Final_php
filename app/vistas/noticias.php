<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- estilos noticias -->
    <link rel="stylesheet" href="../publico/css/noticias.css">

    <!-- estilos globales encabezado y pie de pagina-->
    <link rel="stylesheet" href="../publico/css/globales_encabezado.css">
    <link rel="stylesheet" href="../publico/css/globales_pie_de_pagina.css">


    <title>Noticias</title>

</head>

<body>
    <!-- encabezado dinamico  -->
    <?php include '../vistas/parciales/encabezado.php'; ?>

    <main>
        <h1>Noticias destacadas</h1>


        <div class="contenedor-noticias">

            <?php if (isset($noticias) && !empty($noticias)): ?>
                <?php foreach ($noticias as $noticia): ?>
                    <article class="noticia <?php echo ($noticia['id_noticia'] % 2 == 0) ? 'noticia-grande' : 'noticia-pequena'; ?>">
                        <h2><?php echo htmlspecialchars($noticia['titulo']); ?></h2>
                        <p><small>Por <?php echo htmlspecialchars($noticia['nombre']); ?> | Publicado el <?php echo htmlspecialchars($noticia['fecha']); ?></small></p>
                        <img src="<?php echo htmlspecialchars($noticia['imagen']); ?>" alt="Imagen de la noticia">
                        <p class="texto-noticia">
                            <?php
                            if (strlen($noticia['texto']) > 100) {
                                echo substr(htmlspecialchars($noticia['texto']), 0, 100) . '...';
                            } else {
                                echo htmlspecialchars($noticia['texto']);
                            }
                            ?>
                        </p>
                        <a href="#" class="ver-mas">Ver más</a>
                    </article>
                <?php endforeach; ?>

            <?php else: ?>
                
                <p>No hay noticias disponibles en este momento.</p>
                
            <?php endif; ?>

        </div>


    </main>

    <div class="contenido">
        <!-- pie de pagina global.  -->
        <?php include '../vistas/parciales/pieDePagina.php'; ?>
    </div>

    <script src="../publico/js/ver_mas.js"></script> <!-- Cargamos el archivo JS externo -->
</body>

</html>