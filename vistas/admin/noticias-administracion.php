<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos del panel de administración -->
    <link rel="stylesheet" href="<?= BASE_URL ?>publico/css/noticias-administracion.css">

    <!-- estilos modal editar noticias -->
    <link rel="stylesheet" href="<?= BASE_URL ?>publico/css/modal_editar_noticias.css">

    <!-- estilos globales encabezado y pie de pagina-->
    <link rel="stylesheet" href="<?= BASE_URL ?>publico/css/globales_encabezado.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>publico/css/globales_pie_de_pagina.css">

    <title>Administración de Noticias</title>
</head>

<body>
    <!-- Encabezado dinámico -->
    <?php include __DIR__ . '/../../vistas/parciales/encabezado.php'; ?>

    <!-- Contenedor principal del panel de administración -->
    <main id="panel-noticias-admin" class="panel-admin">
        <h1>Administración de Noticias</h1>

        <!-- Sección de mensajes de éxito o error -->
        <?php if (isset($_GET['mensaje'])): ?>
            <div class="mensaje-exito">
                <?php if ($_GET['mensaje'] == 'noticia_creada'): ?>
                    ¡La noticia se ha creado exitosamente!
                <?php elseif ($_GET['mensaje'] == 'noticia_eliminada'): ?>
                    ¡La noticia ha sido eliminada exitosamente!
                <?php elseif ($_GET['mensaje'] == 'noticia_actualizada'): ?>
                    ¡La noticia ha sido actualizada exitosamente!
                <?php endif; ?>
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="mensaje-error">
                <?php if ($_GET['error'] == 'fallo_creacion'): ?>
                    Ocurrió un error al crear la noticia. Por favor, intenta nuevamente.
                <?php elseif ($_GET['error'] == 'fallo_eliminacion'): ?>
                    Ocurrió un error al eliminar la noticia. Por favor, intenta nuevamente.
                <?php elseif ($_GET['error'] == 'fallo_actualizacion'): ?>
                    Ocurrió un error al actualizar la noticia. Por favor, intenta nuevamente.
                <?php elseif ($_GET['error'] == 'errores_validacion'): ?>
                    Ocurrieron los siguientes errores en la validación:
                    <ul>
                        <?php
                        // Decodificar los detalles de los errores en la validación
                        $detalles = json_decode($_GET['detalles'], true);
                        foreach ($detalles as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php elseif ($_GET['error'] == 'faltan_datos'): ?>
                    Faltan datos para realizar la operación. Por favor, completa todos los campos.
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Formulario para añadir noticias -->
        <section id="formulario-noticia-admin" class="formulario-noticia">
            <form id="form" action="<?= BASE_URL ?>rutas/rutas.php?accion=crearNoticia" method="POST" enctype="multipart/form-data" novalidate>
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>
                <p class="mensaje-error" style="visibility: hidden;"></p>

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">
                <p class="mensaje-error" style="visibility: hidden;"></p>

                <label for="texto">Texto:</label>
                <textarea id="texto" name="texto" rows="5" required></textarea>
                <p class="mensaje-error" style="visibility: hidden;"></p>

                <button type="submit" name="crear_noticia">Crear Noticia</button>
            </form>
        </section>

        <!-- Tabla de noticias publicadas -->
        <section id="tabla-noticias-admin" class="tabla-noticias">
            <h2>Noticias Publicadas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($noticias) && !empty($noticias)): ?>
                        <?php foreach ($noticias as $noticia): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($noticia['titulo'] ?? 'Sin título'); ?></td>
                                <td><?php echo htmlspecialchars($noticia['fecha'] ?? 'Fecha no disponible'); ?></td>

                                <td>
                                    <button class="btn-editar"
                                        data-id="<?php echo $noticia['id_noticia']; ?>"
                                        data-titulo="<?php echo htmlspecialchars($noticia['titulo']); ?>"
                                        data-texto="<?php echo htmlspecialchars($noticia['texto']); ?>">
                                        Editar
                                    </button>
                                    <form action="<?= BASE_URL ?>rutas/rutas.php?accion=eliminarNoticia" method="POST" style="display:inline;">
                                        <input type="hidden" name="id_noticia" value="<?php echo $noticia['id_noticia']; ?>">
                                        <button type="submit" class="btn-eliminar" name="eliminar_noticia" onclick="return confirm('¿Estás seguro de eliminar esta noticia?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No hay noticias publicadas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <!-- Modal para editar noticia -->
    <div id="modal-editar-noticia">
        <div class="modal-contenido">
            <span id="cerrar-modal">&times;</span>
            <h2>Editar Noticia</h2>
            <form id="form-editar" action="<?= BASE_URL ?>rutas/rutas.php?accion=editarNoticia" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_noticia" id="id_noticia_editar">

                <label for="titulo-editar">Título:</label>
                <input type="text" name="titulo" id="titulo-editar" required>

                <label for="texto-editar">Texto:</label>
                <textarea name="texto" id="texto-editar" rows="5" required></textarea>

                <label for="imagen-editar">Imagen (opcional):</label>
                <input type="file" name="imagen" id="imagen-editar" accept="image/*">

                <button type="submit" name="editar_noticia">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <!-- Pie de página global -->
    <div class="contenido">
        <?php include __DIR__ . '/../../vistas/parciales/pieDePagina.php'; ?>
    </div>

    <script src="<?= BASE_URL ?>publico/js/validacion_noticias.js"></script>
    <script src="<?= BASE_URL ?>publico/js/modal_editar_noticias.js"></script>
    <!-- script para ocultar mensaje -->
    <script src="<?= BASE_URL ?>publico/js/ocultar_mensaje.js"></script>
</body>

</html>
