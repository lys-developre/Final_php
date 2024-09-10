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
        <h1>Últimas Noticias</h1>

        <div class="contenedor-noticia">

            <?php if (isset($noticias) && !empty($noticias)): ?>
                <?php foreach ($noticias as $index => $noticia): ?>

                    <article class="noticia <?php echo $claseNoticia; ?>">
                        <h2><?php echo htmlspecialchars($noticia['titulo']); ?></h2>
                        <p><small>Publicado el <?php echo htmlspecialchars($noticia['fecha']); ?> por <?php echo htmlspecialchars($noticia['nombre']); ?></small></p>

                        <!-- Mostrar la imagen -->
                        <img src="/uploads/noticias_img/<?php echo htmlspecialchars($noticia['imagen']); ?>" alt="Imagen de la noticia">

                        <p><?php echo htmlspecialchars($noticia['texto']); ?></p>
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

</body>

</html>