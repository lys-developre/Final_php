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

                <li><a href="http://localhost/Final_php/app/index.php">Inicio</a></li>
                <li><a href="http://localhost/Final_php/app/vistas/registro.php">Registro</a></li>
                <li><a href="http://localhost/Final_php/app/vistas/login.php">Iniciar Sesión</a></li>
                <li><a href="http://localhost:3000/app/rutas/rutas.php?accion=mostrarNoticias">Noticias</a></li>

            <?php elseif ($_SESSION['usuario_rol'] === 'user'): // Usuario registrado ?>

                <li><a href="http://localhost/Final_php/app/index.php">Inicio</a></li>
                <li><a href="http://localhost/Final_php/app/vistas/registro.php">Registro</a></li>
                <li><a href="http://localhost/Final_php/app/vistas/login.php">Iniciar Sesión</a></li>
                <li><a href="http://localhost:3000/app/rutas/rutas.php?accion=mostrarNoticias">Noticias</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>

            <?php elseif ($_SESSION['usuario_rol'] === 'admin'): // Administrador ?>

                <li><a href="http://localhost/Final_php/app/index.php">Inicio</a></li>
                <li><a href="http://localhost/Final_php/app/vistas/registro.php">Registro</a></li>
                <li><a href="http://localhost/Final_php/app/vistas/login.php">Iniciar Sesión</a></li>
                <li><a href="http://localhost:3000/app/rutas/rutas.php?accion=mostrarNoticias">Noticias</a></li>>
                <li><a href="admin_dashboard.php">Admin Dashboard</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>

            <?php endif; ?>
        </ul>
    </nav>
</header>

