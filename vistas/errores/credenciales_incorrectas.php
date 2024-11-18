<?php
require_once __DIR__ . '/../base_config.php'; // Incluyendo base_config.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error de Credenciales</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>publico/css/credenciales_incorrectas.css"> <!-- Ruta a los estilos -->
</head>
<body>
    <main class="contenedor-error">
        <h1 class="titulo-error">Ups!</h1>
        <p class="mensaje-error">Por favor, verifica tu correo electrónico y contraseña e inténtalo de nuevo.</p>
        <a href="<?= BASE_URL ?>vistas/login.php" class="boton-inicio">Intentarlo de nuevo</a>
    </main>
</body>
</html>
