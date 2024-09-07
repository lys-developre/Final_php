<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="../publico/css/login.css"> <!-- Estilos reutilizados -->

    <!-- estilos globales encabezado y pie de pagina-->
    <link rel="stylesheet" href="../publico/css/globales_encabezado.css">
    <link rel="stylesheet" href="../publico/css/globales_pie_de_pagina.css">
</head>

<body>
    <!-- encabezado dinamico  -->
    <?php include '../vistas/parciales/encabezado.php'; ?>

    <main class="contenedor-formulario">
        <h1 class="titulo-formulario">Iniciar Sesión</h1>
        <form action="../rutas/rutas.php" method="POST" class="formulario-login" novalidate>

            <div class="campo-formulario">
                <label for="correo" class="etiqueta-campo">Correo Electrónico:</label>
                <input type="email" id="correo" name="email" class="entrada-campo" required placeholder="ejemplo@correo.com">
                <span id="error-correo" class="mensaje-error"></span>
            </div>

            <div class="campo-formulario">
                <label for="contrasena" class="etiqueta-campo">Contraseña:</label>
                <input type="password" id="contrasena-login" name="contrasena" class="entrada-campo" required placeholder="Ingrese su contraseña">
                <span id="error-contrasena" class="mensaje-error"></span>
            </div>

            <!-- Checkbox para mostrar/ocultar la contraseña -->
            <div class="campo-formulario checkbox-container">
                <input type="checkbox" id="mostrar-contrasena-login" class="mostrar-contrasena">
                <label for="mostrar-contrasena" class="etiqueta-campo">Mostrar Contraseña</label>
            </div>

            <div class="grupo-boton">
                <button type="submit" class="boton-formulario" name="iniciar_sesion">Iniciar Sesión</button>
            </div>
        </form>


    </main>

    <div class="contenido">
            <!-- pie de pagina global.  -->
            <?php include '../vistas/parciales/pieDePagina.php'; ?>
    </div>



    <!-- Incluimos el archivop js para mostrar ocultar contraseña -->
    <script src="../publico/js/mostrar_contrasena.js"></script>
    <!-- Incluimos el archivo js de validacion de login. -->
    <script src="../publico/js/validacion_login.js"></script>
</body>

</html>