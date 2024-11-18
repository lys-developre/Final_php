<?php
require_once __DIR__ . '../../../config/base_config.php'; // Incluyendo base_config.php
?>
<!-- pie de pagina general -->
<footer class="pie-de-pagina">
    <div class="contenido-pie">
        <p>&copy; <?php echo date("Y"); ?> Proyecto final Modulo PHP.</p>
        <ul class="enlaces-pie">
            <li><a href="<?= BASE_URL ?>index.php">Inicio</a></li>
            <li><a href="<?= BASE_URL ?>rutas/rutas.php?accion=mostrarNoticias">Noticias</a></li>
            <li><a href="<?= BASE_URL ?>vistas/registro.php">Registro</a></li>
            <li><a href="<?= BASE_URL ?>vistas/login.php">Login</a></li>
            
        </ul>
    </div>
</footer>
