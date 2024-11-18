<?php
require_once __DIR__ . '../../../config/base_config.php'; // Incluyendo base_config.php

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificamos cuál es el rol del usuario y mostramos sus opciones de acceso dependiendo de su rol.
// Nota: El rol se almacena en $_SESSION['user_data']['rol'] según lo que vimos antes.
$rol = isset($_SESSION['user_data']['rol']) ? $_SESSION['user_data']['rol'] : 'visitante';

// Obtener la URL actual
$url_actual = $_SERVER['REQUEST_URI'];
?>

<header class="encabezado-principal">
    <nav class="barra-navegacion">
        <ul class="menu-principal">
            <?php if ($rol === 'visitante'): // Visitante ?>
                <li><a href="<?= BASE_URL ?>index.php" class="<?= ($url_actual == BASE_URL . 'index.php') ? 'activo' : ''; ?>">Inicio</a></li>
                <li><a href="<?= BASE_URL ?>rutas/rutas.php?accion=mostrarNoticias" class="<?= (strpos($url_actual, 'mostrarNoticias') !== false) ? 'activo' : ''; ?>">Noticias</a></li>
                <li><a href="<?= BASE_URL ?>vistas/registro.php" class="<?= ($url_actual == BASE_URL . 'vistas/registro.php') ? 'activo' : ''; ?>">Registro</a></li>
                <li><a href="<?= BASE_URL ?>vistas/login.php" class="<?= ($url_actual == BASE_URL . 'vistas/login.php') ? 'activo' : ''; ?>">Login</a></li>

            <?php elseif ($rol === 'user'): // Usuario registrado ?>
                <li><a href="<?= BASE_URL ?>index.php" class="<?= ($url_actual == BASE_URL . 'index.php') ? 'activo' : ''; ?>">Inicio</a></li>
                <li><a href="<?= BASE_URL ?>rutas/rutas.php?accion=mostrarNoticias" class="<?= (strpos($url_actual, 'mostrarNoticias') !== false) ? 'activo' : ''; ?>">Noticias</a></li>
                <li><a href="<?= BASE_URL ?>rutas/rutas.php?accion=mostrarCitasUsuario" class="<?= (strpos($url_actual, 'mostrarCitasUsuario') !== false) ? 'activo' : ''; ?>">Citaciones</a></li>
                <li><a href="<?= BASE_URL ?>rutas/rutas.php?accion=mostrarPerfil" class="<?= (strpos($url_actual, 'mostrarPerfil') !== false) ? 'activo' : ''; ?>">Perfil</a></li>
                <li><a href="<?= BASE_URL ?>rutas/rutas.php?accion=logout">Cerrar Sesión</a></li>

            <?php elseif ($rol === 'admin'): // Administrador ?>
                <li><a href="<?= BASE_URL ?>index.php" class="<?= ($url_actual == BASE_URL . 'index.php') ? 'activo' : ''; ?>">Inicio</a></li>
                <li><a href="<?= BASE_URL ?>rutas/rutas.php?accion=mostrarNoticias" class="<?= (strpos($url_actual, 'mostrarNoticias') !== false) ? 'activo' : ''; ?>">Noticias</a></li>
                <li><a href="<?= BASE_URL ?>rutas/rutas.php?accion=adminUsuarios" class="<?= (strpos($url_actual, 'adminUsuarios') !== false) ? 'activo' : ''; ?>">Usuarios-Administración</a></li>
                <li><a href="<?= BASE_URL ?>rutas/rutas.php?accion=adminCitas" class="<?= (strpos($url_actual, 'adminCitas') !== false) ? 'activo' : ''; ?>">Citaciones-Administración</a></li>
                <li><a href="<?= BASE_URL ?>rutas/rutas.php?accion=adminNoticias" class="<?= (strpos($url_actual, 'adminNoticias') !== false) ? 'activo' : ''; ?>">Noticias-Administración</a></li>
                <li><a href="<?= BASE_URL ?>rutas/rutas.php?accion=mostrarPerfil" class="<?= (strpos($url_actual, 'mostrarPerfil') !== false) ? 'activo' : ''; ?>">Perfil</a></li>
                <li><a href="<?= BASE_URL ?>rutas/rutas.php?accion=logout">Cerrar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
