<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificamos cual es el rol de el usuario y mostramos sus opciones de acceso dependiendo de el rol que tenga.
$rol = isset($_SESSION['usuario_rol']) ? $_SESSION['usuario_rol'] : 'visitante';
?>

<header class="encabezado-principal">
    <nav class="barra-navegacion">
        <ul class="menu-principal">
            <?php if (!isset($_SESSION['usuario_rol'])): // Visitante ?>

                <li><a href="/index.php">Inicio</a></li>
                <li><a href="/vistas/registro.php">Registro</a></li>
                <li><a href="/vistas/login.php">Login</a></li>
                <li><a href="/rutas/rutas.php?accion=mostrarNoticias">Noticias</a></li>


                <!-- //rutas provicionales hasta arreglar el login -->
                <li><a href="/rutas/rutas.php?accion=adminNoticias">noticias-administracion</a></li>
                <li><a href="/rutas/rutas.php?accion=adminCitas">citas-administracion</a></li>





            <?php elseif ($_SESSION['usuario_rol'] === 'user'): // Usuario registrado ?>

                <li><a href="/index.php">Inicio</a></li>
                <li><a href="/vistas/registro.php">Registro</a></li>
                <li><a href="/vistas/login.php">Login</a></li>
                <!-- quedan por hacer  -->
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>






            <?php elseif ($_SESSION['usuario_rol'] === 'admin'): // Administrador ?>
                <li><a href="/index.php">Inicio</a></li>
                <li><a href="/vistas/registro.php">Registro</a></li>
                <li><a href="/vistas/login.php">Login</a></li>
                <li><a href="/Final_php/app/rutas/rutas.php?accion=mostrarNoticias">Noticias</a></li>
                <!-- opciones admin. -->
                <li><a href="/rutas/rutas.php?accion=adminNoticias">noticias-administracion</a></li>
                <li><a href="/rutas/rutas.php?accion=adminCitas">citas-administracion</a></li>

                <!-- quedan por hacer -->
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>

            <?php endif; ?>
        </ul>
    </nav>
</header>

