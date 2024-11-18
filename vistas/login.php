<?php
// Iniciar la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/base_config.php'; // Incluyendo base_config.php

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>publico/css/login.css"> <!-- Estilos reutilizados -->

    <!-- estilos globales encabezado y pie de pagina-->
    <link rel="stylesheet" href="<?= BASE_URL ?>publico/css/globales_encabezado.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>publico/css/globales_pie_de_pagina.css">

    <title>login</title>
</head>

<body>
    <!-- encabezado dinámico  -->
    <?php include __DIR__ . '/../vistas/parciales/encabezado.php'; ?>

    <main class="contenedor-formulario">
        <h1 class="titulo-formulario">Iniciar Sesión</h1>

        <?php
        // Mostrar el mensaje de confirmación si el registro fue exitoso
        if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'registro_exitoso') {
            echo '<div class="mensaje-exito">Registro exitoso. Ahora puedes iniciar sesión.</div>';
        }

        // Mostrar el mensaje de error si la contraseña es incorrecta o el usuario no existe
        if (isset($_GET['mensaje'])) {
            if ($_GET['mensaje'] === 'contrasena-incorrecta') {
                echo '<div class="mensaje-error">Contraseña incorrecta. Por favor, inténtalo de nuevo.</div>';
            } elseif ($_GET['mensaje'] === 'no-encontrado') {
                echo '<div class="mensaje-error">No se encontró un usuario con ese nombre. Por favor, verifica tus datos.</div>';
            }
        }
        ?>

        <form action="<?= BASE_URL ?>rutas/rutas.php" method="POST" class="formulario-login" novalidate>

            <div class="campo-formulario">
                <label for="usuario" class="etiqueta-campo">Nombre de Usuario:</label>
                <input type="text" id="usuario" name="usuario" class="entrada-campo" required placeholder="Ingrese su nombre de usuario">
                <span id="error-usuario" class="mensaje-error"></span>
            </div>

            <div class="campo-formulario">
                <label for="contrasena" class="etiqueta-campo">Contraseña:</label>
                <input type="password" id="contrasena-login" name="contrasena" class="entrada-campo" required placeholder="Ingrese su contraseña">
                <span id="error-contrasena" class="mensaje-error"></span>
            </div>

            <!-- Checkbox para mostrar/ocultar la contraseña -->
            <div class="campo-formulario checkbox-container">
                <input type="checkbox" id="mostrar-contrasena-login" class="mostrar-contrasena">
                <label for="mostrar-contrasena-login" class="etiqueta-campo">Mostrar Contraseña</label>
            </div>

            <div class="grupo-boton">
                <button type="submit" class="boton-formulario" name="iniciar_sesion">Iniciar Sesión</button>
            </div>
            <a href="<?= BASE_URL ?>vistas/registro.php">Registrarse</a>
        </form>
    </main>

    <div class="contenido">
        <!-- pie de página global -->
        <?php include __DIR__ . '/../vistas/parciales/pieDePagina.php'; ?>
    </div>

    <!-- Incluimos el archivop js para mostrar ocultar contraseña -->
    <script src="<?= BASE_URL ?>publico/js/mostrar_contrasena.js"></script>
    <!-- Incluimos el archivo js de validación de login -->
    <script src="<?= BASE_URL ?>publico/js/validacion_login.js"></script>
    <!-- script ocultar mensaje -->
    <script src="<?= BASE_URL ?>publico/js/ocultar_mensaje.js"></script>
</body>

</html>
