<?php

require_once __DIR__ . '../../../config/base_config.php'; // Incluyendo base_config.php


// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_data'])) {
    header('Location: ' . BASE_URL . 'vistas/login.php');
    exit();
}



?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos globales encabezado y pie de página-->
    <link rel="stylesheet" href="<?= BASE_URL ?>publico/css/globales_encabezado.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>publico/css/globales_pie_de_pagina.css">

    <!-- Estilos del perfil -->
    <link rel="stylesheet" href="<?= BASE_URL ?>publico/css/perfil.css">

    <title>Perfil de Usuario</title>
</head>

<body>
    <!-- Incluir el encabezado -->
    <?php include __DIR__ . '/../parciales/encabezado.php'; ?>

    <main id="perfil-usuario">
        <h1>Perfil de Usuario</h1>

        <?php
        // Mostrar mensajes de éxito o error basados en la URL
        if (isset($_GET['mensaje'])) {
            if ($_GET['mensaje'] == 'datos_actualizados') {
                echo '<div class="mensaje-exito">Los datos han sido actualizados correctamente.</div>';
            }
        }

        if (isset($_GET['error'])) {
            if ($_GET['error'] == 'campos_vacios') {
                echo '<div class="mensaje-error">Todos los campos son obligatorios. Por favor, completa todos los campos.</div>';
            } elseif ($_GET['error'] == 'actualizacion_fallida') {
                echo '<div class="mensaje-error">Hubo un problema al actualizar los datos. Inténtalo nuevamente.</div>';
            }
        }
        ?>

        <section class="datos-usuario">
            <h2>Datos Personales</h2>
            <p><strong>ID de Usuario:</strong> <?php echo htmlspecialchars($usuario['id_user']); ?></p>
            <p><strong>Nombre de Usuario:</strong> <?php echo htmlspecialchars($usuario['usuario']); ?></p>

            <form action="<?= BASE_URL ?>rutas/rutas.php" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>" required>

                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>

                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>

                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($usuario['direccion']); ?>" required>

                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($usuario['fecha_nacimiento']); ?>" required>

                <label for="sexo">Sexo:</label>
                <select id="sexo" name="sexo" required>
                    <option value="M" <?php echo $usuario['sexo'] == 'M' ? 'selected' : ''; ?>>Masculino</option>
                    <option value="F" <?php echo $usuario['sexo'] == 'F' ? 'selected' : ''; ?>>Femenino</option>
                    <option value="O" <?php echo $usuario['sexo'] == 'O' ? 'selected' : ''; ?>>Otro</option>
                </select>

                <!-- Nuevo campo para la contraseña -->
                <label for="contrasena">Nueva Contraseña (Opcional):</label>
                <input type="password" id="contrasena" name="contrasena">

                <!-- Campo oculto para la acción -->
                <input type="hidden" name="accion" value="actualizarDatosPersonales">

                <button type="submit" value="actualizarDatosPersonales">Actualizar Datos</button>
            </form>
        </section>
    </main>

    <!-- Incluir el pie de página -->
    <?php include __DIR__ . '/../parciales/pieDePagina.php'; ?>

    <!-- script para ocultar mensajes de éxito/error -->
    <script src="<?= BASE_URL ?>publico/js/ocultar_mensaje.js"></script>
</body>

</html>
