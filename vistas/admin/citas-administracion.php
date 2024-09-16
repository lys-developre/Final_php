<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos del panel de administración -->
    <link rel="stylesheet" href="../publico/css/citas-administracion.css">

    <!-- Estilos para el modal de edición -->
    <link rel="stylesheet" href="../publico/css/modal_editar_citas.css">

    <!-- estilos globales encabezado y pie de pagina-->
    <link rel="stylesheet" href="../publico/css/globales_encabezado.css">
    <link rel="stylesheet" href="../publico/css/globales_pie_de_pagina.css">

    <title>Administración de Citas</title>
</head>

<body>
    <!-- Encabezado dinámico -->
    <?php include __DIR__ . '/../../vistas/parciales/encabezado.php'; ?>

    <!-- Contenedor principal del panel de administración -->
    <main id="panel-citas-admin" class="panel-admin">
        <h1>Administración de Citas</h1>

        <!-- Sección de mensajes de éxito o error -->
        <?php if (isset($_GET['mensaje'])): ?>
            <div class="mensaje-exito">
                ¡La cita se ha creado exitosamente!
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="mensaje-error">
                <?php if ($_GET['error'] == 'fallo_creacion'): ?>
                    Ocurrió un error al crear la cita. Por favor, intenta nuevamente.
                <?php elseif ($_GET['error'] == 'errores_validacion'): ?>
                    Ocurrieron los siguientes errores en la validación:
                    <ul>
                        <?php
                        $detalles = json_decode($_GET['detalles'], true);
                        foreach ($detalles as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php elseif ($_GET['error'] == 'faltan_datos'): ?>
                    Faltan datos para crear la cita. Por favor, completa todos los campos.
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Formulario para añadir citas -->
        <section id="formulario-cita-admin" class="formulario-cita">
        <h2>Nueva cita</h2>

            <form id="form" action="rutas.php?accion=crearCita" method="POST" novalidate>
                <label for="usuario">Usuario:</label>
                <select id="usuario" name="id_user" required>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?php echo $usuario['id_user']; ?>">
                            <?php echo htmlspecialchars($usuario['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="mensaje-error" style="visibility: hidden;"></p>

                <label for="fecha">Fecha de la cita:</label>
                <input type="date" id="fecha" name="fecha" required min="<?php echo date('Y-m-d'); ?>">                <p class="mensaje-error" style="visibility: hidden;"></p>

                <label for="descripcion">Motivo de la Cita</label>
                <textarea id="descripcion" name="descripcion" rows="5" required></textarea>
                <p class="mensaje-error" style="visibility: hidden;"></p>

                <button type="submit" name="crear_cita">Crear Cita</button>
            </form>
            
        </section>

       
<!-- Sección para seleccionar el usuario -->
<section id="seleccion-usuario">

    <h2>Seleccionar Usuario</h2>

    <form method="POST" action="">

        <label for="id_user">Elige un usuario:</label>
        <select name="id_user" id="id_user">
            <?php
            // Capturamos el usuario seleccionado en $_POST
            $usuarioSeleccionado = isset($_POST['id_user']) ? $_POST['id_user'] : '';
            
            foreach ($usuarios as $usuario): ?>
                <option value="<?php echo htmlspecialchars($usuario['id_user']); ?>" 
                    <?php echo ($usuario['id_user'] == $usuarioSeleccionado) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($usuario['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Ver citas del usuario</button>

    </form>

</section>


<!-- Tabla de citas asignadas al usuario seleccionado -->
<section id="tabla-citas-admin" class="tabla-citas">
    <h2>Citas Asignadas</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($citas) && !empty($citas)): ?>
                <?php foreach ($citas as $cita): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cita['fecha_cita']); ?></td>
                        <td><?php echo htmlspecialchars($cita['motivo_cita']); ?></td>

                        <td>
                            <!-- Botón para Editar Cita -->
                            <button class="btn-editar"
                                data-id="<?php echo $cita['id_cita']; ?>"
                                data-fecha="<?php echo htmlspecialchars($cita['fecha_cita']); ?>"
                                data-descripcion="<?php echo htmlspecialchars($cita['motivo_cita']); ?>">
                                Editar
                            </button>

                            <!-- Formulario para Eliminar Cita -->
                            <form action="rutas.php?accion=eliminarCita" method="POST" style="display:inline;">
                                <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">
                                <button type="submit" class="btn-eliminar" name="eliminar_cita" onclick="return confirm('¿Estás seguro de eliminar esta cita?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay citas asignadas para este usuario.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<!-- Modal para editar cita (opcional, si usas un modal) -->
<div id="modal-editar-cita">
    <div class="modal-contenido">
        <span id="cerrar-modal">&times;</span>
        <h2>Editar Cita</h2>
        <form id="form-editar" action="rutas.php?accion=editarCita" method="POST">
            <input type="hidden" name="id_cita" id="id_cita_editar">

            <label for="fecha-editar">Fecha de la cita:</label>
            <input type="date" name="fecha" id="fecha-editar" required>

            <label for="descripcion-editar">Descripción:</label>
            <textarea name="descripcion" id="descripcion-editar" rows="5" required></textarea>

            <button type="submit" name="editar_cita">Guardar Cambios</button>
        </form>
    </div>
</div>


    </main>

    

    <!-- Pie de página -->
    <div class="contenido">
        <?php include __DIR__ . '/../../vistas/parciales/pieDePagina.php'; ?>
    </div>

    <!-- script para el modal citas -->
    <script src="/publico/js/modal_editar_citas.js"></script>
    <!-- script para la validación de citas -->
    <script src="/publico/js/validacion_citas.js"></script>
</body>

</html>
