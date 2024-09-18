<?php

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <link rel="stylesheet" href="../publico/css/registro_formulario.css">


    <!-- estilos globales encabezado y pie de pagina-->
    <link rel="stylesheet" href="../publico/css/globales_encabezado.css">
    <link rel="stylesheet" href="../publico/css/globales_pie_de_pagina.css">

</head>

<body>

    <!-- encabezado dinamico  -->

    <main class="contenedor-formulario">
        <h1 class="titulo-formulario">Registro de Usuario</h1>


        
        <?php include '../vistas/parciales/encabezado.php'; ?>
        
        <!-- Sección de mensajes de éxito o error -->
        <?php if (isset($_GET['mensaje'])): ?>
            <?php if ($_GET['mensaje'] == 'usuario_duplicado'): ?>
                <div class="mensaje-error">El correo electrónico o usuario ya está registrado.</div>
            <?php elseif ($_GET['mensaje'] == 'error_general'): ?>
                <div class="mensaje-error">Ocurrió un error. Inténtalo de nuevo.</div>
            <?php endif; ?>
        <?php endif; ?>

        <form action="../rutas/rutas.php" method="POST" class="formulario-registro" novalidate>
            <div class="campo-formulario">
                <label for="nombre" class="etiqueta-campo">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="entrada-campo" required aria-describedby="error-nombre" placeholder="Ingrese su nombre" autocomplete="given-name">
                <span class="mensaje-error" id="error-nombre"></span>
            </div>
            <div class="campo-formulario">
                <label for="apellidos" class="etiqueta-campo">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" class="entrada-campo" required aria-describedby="error-apellidos" placeholder="Ingrese sus apellidos" autocomplete="family-name">
                <span class="mensaje-error" id="error-apellidos"></span>
            </div>
            <div class="campo-formulario">
                <label for="correo" class="etiqueta-campo">Correo Electrónico:</label>
                <input type="email" id="correo" name="email" class="entrada-campo" required aria-describedby="error-correo" placeholder="ejemplo@correo.com" autocomplete="email">
                <span class="mensaje-error" id="error-correo"></span>
            </div>
            <div class="campo-formulario">
                <label for="usuario" class="etiqueta-campo">Nombre de Usuario:</label>
                <input type="text" id="usuario" name="usuario" class="entrada-campo" required aria-describedby="error-usuario" placeholder="Ingrese su nombre de usuario" autocomplete="username">
                <span class="mensaje-error" id="error-usuario"></span>
            </div>
            <div class="campo-formulario">
                <label for="telefono" class="etiqueta-campo">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" class="entrada-campo" required aria-describedby="error-telefono" placeholder="+123456789" autocomplete="tel">
                <span class="mensaje-error" id="error-telefono"></span>
            </div>
            <div class="campo-formulario">
                <label for="fecha_nacimiento" class="etiqueta-campo">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="entrada-campo" required aria-describedby="error-fecha_nacimiento" autocomplete="bday">
                <span class="mensaje-error" id="error-fecha_nacimiento"></span>
            </div>
            <div class="campo-formulario">
                <label for="direccion" class="etiqueta-campo">Dirección:</label>
                <input type="text" id="direccion" name="direccion" class="entrada-campo" required aria-describedby="error-direccion" placeholder="Ingrese su dirección" autocomplete="street-address">
                <span class="mensaje-error" id="error-direccion"></span>
            </div>
            <div class="campo-formulario">
                <label for="sexo" class="etiqueta-campo">Sexo:</label>
                <select id="sexo" name="sexo" class="seleccion-campo" required aria-describedby="error-sexo">
                    <option value="">Seleccione su sexo</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Otro">Otro</option>
                </select>
                <span class="mensaje-error" id="error-sexo"></span>
            </div>
            <div class="campo-formulario">
                <label for="contrasena" class="etiqueta-campo">Contraseña:</label>
                <input type="password" id="contrasena-registro" name="contrasena" class="entrada-campo" required aria-describedby="error-contrasena" placeholder="Ingrese su contraseña" autocomplete="new-password">
                <span class="mensaje-error" id="error-contrasena"></span> <!-- ID correcto -->
            </div>
            <div class="campo-formulario">
                <input type="checkbox" id="mostrar-contrasena-registro" class="mostrar-contrasena">
                <label for="mostrar-contrasena" class="etiqueta-campo">Mostrar Contraseña</label>
            </div>
            <div class="grupo-boton">
                <button type="submit" name="registrarse" class="boton-formulario">Registrarse</button>
            </div>
            <a href="/vistas/login.php">Iniciar Sesión</a>
        </form>

        
    </main>


    <div class="contenido">
        <!-- pie de pagina global.  -->
        <?php include '../vistas/parciales/pieDePagina.php'; ?>
    </div>


    <!-- Vinculación con el script de mostrar/ocultar contraseña -->
    <script src="../publico/js/mostrar_contrasena.js"></script>
    <!-- Vinculación con la validación JavaScript -->
    <script src="../publico/js/validacion_registro.js"></script>
    <!-- script para ocultar los mensajes  -->
    <script src="../publico/js/ocultar_mensaje.js"></script>
</body>

</html>