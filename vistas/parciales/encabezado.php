<?php

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificamos cuál es el rol del usuario y mostramos sus opciones de acceso dependiendo de su rol.
// Nota: El rol se almacena en $_SESSION['user_data']['rol'] según lo que vimos antes.
$rol = isset($_SESSION['user_data']['rol']) ? $_SESSION['user_data']['rol'] : 'visitante';
?>

<header class="encabezado-principal">
    <nav class="barra-navegacion">
        <ul class="menu-principal">
            <?php if ($rol === 'visitante'): // Visitante 
            ?>

                <li><a href="/index.php">Inicio</a></li>
                <li><a href="/vistas/registro.php">Registro</a></li>
                <li><a href="/vistas/login.php">Login</a></li>
                <li><a href="/rutas/rutas.php?accion=mostrarNoticias">Noticias</a></li>


            <?php elseif ($rol === 'user'): // Usuario registrado 
            ?>

                <li><a href="/index.php">Inicio</a></li>
                <li><a href="/rutas/rutas.php?accion=mostrarNoticias">Noticias</a></li>

                <li><a href="/rutas/rutas.php?accion=mostrarPerfil">Perfil</a></li>
                
                <li><a href="/rutas/rutas.php?accion=mostrarCitasUsuario">Citaciones</a></li>
                <li><a href="/rutas/rutas.php?accion=logout">Cerrar Sesión</a></li>


            <?php elseif ($rol === 'admin'): // Administrador 
            ?>

                <li><a href="/index.php">Inicio</a></li>
                <li><a href="/Final_php/app/rutas/rutas.php?accion=mostrarNoticias">Noticias</a></li>
                <!-- Opciones de administración -->
                <li><a href="/rutas/rutas.php?accion=adminNoticias">Administrar Noticias</a></li>
                <li><a href="/rutas/rutas.php?accion=adminCitas">Administrar Citas</a></li>
                
                <li><a href="/rutas/rutas.php?accion=mostrarPerfil">Perfil</a></li>
                <li><a href="/rutas/rutas.php?accion=logout">Cerrar Sesión</a></li>



            <?php endif; ?>
        </ul>
    </nav>
</header>