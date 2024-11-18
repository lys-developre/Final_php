<?php
require_once __DIR__ . '/../base_config.php'; // Incluyendo base_config.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 500 - Error Interno del Servidor</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>publico/css/error500.css"> <!-- Ruta a los estilos -->
</head>
<body>
    <main class="contenedor-error">
        <h1 class="titulo-error">500</h1>
        <p class="mensaje-error">¡Ups! Algo salió mal en el servidor.</p>
        <p class="mensaje-error">Por favor, intenta nuevamente más tarde.</p>
        <a href="<?= BASE_URL ?>index.php" class="boton-inicio">Volver a la página de inicio</a>
    </main>
</body>
</html>
