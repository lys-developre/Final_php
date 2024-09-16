<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_data'])) {
    header('Location: /MisProyectos/app/vistas/login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <!-- Estilos globales encabezado y pie de página-->
    <link rel="stylesheet" href="/publico/css/globales_encabezado.css">
    <link rel="stylesheet" href="/publico/css/globales_pie_de_pagina.css">
    <!-- earilos de el perfil -->
    <link rel="stylesheet" href="/publico/css/perfil.css">
</head>

<body>
    <!-- Incluir el encabezado -->
    <?php include __DIR__ . '/../parciales/encabezado.php'; ?>

    <main id="perfil-usuario">
        <h1>Perfil de Usuario</h1>

        <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'perfil_actualizado'): ?>

            <div class="mensaje-exito">
                ¡Perfil actualizado exitosamente!
            </div>

        <?php elseif (isset($_GET['error'])): ?>


            <div class="mensaje-error">
                <?php
                switch ($_GET['error']) {

                    case 'usuario_vacio':
                        echo "El nombre de usuario no puede estar vacío.";
                        break;

                    case 'actualizacion_fallida':
                        echo "Ocurrió un error al actualizar el perfil. Por favor, intenta nuevamente.";
                        break;

                    default:
                        echo "Ocurrió un error desconocido.";
                }
                ?>
            </div>


        <?php endif; ?>


        <!-- Mostrar los datos del usuario -->
        <section class="datos-usuario">
            <h2>Datos Personales</h2>
            <p><strong>ID de Usuario:</strong> <?php echo htmlspecialchars($usuario['id_user']); ?></p>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?></p>
            <p><strong>Apellidos:</strong> <?php echo htmlspecialchars($usuario['apellidos']); ?></p>
            <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p> 
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($usuario['telefono']); ?></p> 
            <p><strong>Fecha de Nacimiento:</strong> <?php echo htmlspecialchars($usuario['fecha_nacimiento']); ?></p> 
            <p><strong>Dirección:</strong> <?php echo htmlspecialchars($usuario['direccion']); ?></p> 
        </section>



        <!-- Formulario para editar el nombre de usuario -->
        <section class="editar-usuario">
            <h2>Editar Nombre de Usuario</h2>
            <form action="/rutas/rutas.php" method="POST">
                <label for="usuario">Nombre de Usuario:</label>
                <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($usuario['usuario']); ?>" required>

                <!-- Campo oculto para la acción -->
                <input type="hidden" name="accion" value="actualizarPerfil">

                <button type="submit">Actualizar</button>
            </form>
        </section>





    </main>

    <!-- Incluir el pie de página -->
    <?php include __DIR__ . '/../parciales/pieDePagina.php'; ?>

    <!-- script para ocultar mensajes de éxito/error -->
    <script src="/publico/js/ocultar_mensaje.js"></script>
</body>

</html>