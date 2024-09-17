<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si la sesión contiene el nombre de usuario
$nombre_usuario = isset($_SESSION['user_data']['usuario']) ? $_SESSION['user_data']['usuario'] : 'Usuario Desconocido';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- estilos para encabezado y pie de pagina  -->
    <link rel="stylesheet" href="/publico/css/globales_encabezado.css">
    <link rel="stylesheet" href="/publico/css/globales_pie_de_pagina.css">

    <!-- Estilos específicos de usuarios administracion-->
    <link rel="stylesheet" href="/publico/css/usuarios_administracion.css">

    <!-- estilos para el modal editar usuarios -->
    <link rel="stylesheet" href="/publico/css/modal_editar_usuarios.css">
    <title>Administración de Usuarios</title>
</head>

<body>
    <!-- Encabezado dinámico -->
    <?php include __DIR__ . '/../../vistas/parciales/encabezado.php'; ?>

    <main id="panel-usuarios-admin" class="panel-admin">
        <h1>Administración de Usuarios</h1>

        <!-- Bienvenida al usuario autenticado -->
        <h2>Bienvenido, <span class="nombre-usuario"><?php echo htmlspecialchars($nombre_usuario); ?></span></h2>

        <!-- Sección de mensajes de éxito o error -->
        <?php if (isset($_GET['mensaje'])): ?>
            <?php if ($_GET['mensaje'] == 'usuario_eliminado'): ?>
                <div class="mensaje-exito">¡Usuario eliminado exitosamente!</div>

            <?php elseif ($_GET['mensaje'] == 'error_eliminacion'): ?>
                <div class="mensaje-error">Error al intentar eliminar el usuario.</div>

            <?php elseif ($_GET['mensaje'] == 'exito-actualizar-usuario'): ?>
                <div class="mensaje-exito">Usuario actualizado correctamente.</div>

            <?php elseif ($_GET['mensaje'] == 'error-actualizar-usuario'): ?>
                <div class="mensaje-error">Error al actualizar el usuario.</div>

            <?php elseif ($_GET['mensaje'] == 'exito-crear-usuario'): ?>
                <div class="mensaje-exito">Usuario creado correctamente.</div>

            <?php elseif ($_GET['mensaje'] == 'error-crear-usuario'): ?>
                <div class="mensaje-error">Error al crear el usuario.</div>

            <?php endif; ?>
        <?php endif; ?>




        <!-- Formulario para crear nuevo usuario -->
        <section id="formulario-usuario-admin">
            <h2>Crear Usuario</h2>
            <form action="/rutas/rutas.php" method="POST" class="formulario-registro" novalidate>

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
                    <input type="password" id="contrasena-registro" name="contrasena" class="entrada-campo" required aria-describedby="error-contrasena" placeholder="Al menos 1 mayúscula, 1 dígito, 1 carácter especial, 4-100 caracteres" autocomplete="new-password">
                    <span class="mensaje-error" id="error-contrasena"></span>
                </div>

                <div class="campo-formulario">
                    <input type="checkbox" id="mostrar-contrasena-registro" class="mostrar-contrasena">
                    <label for="mostrar-contrasena-registro" class="etiqueta-campo">Mostrar Contraseña</label>
                </div>

                <!-- Nuevo campo para seleccionar el rol -->
                <div class="campo-formulario">
                    <label for="rol" class="etiqueta-campo">Rol:</label>
                    <select id="rol" name="rol" class="seleccion-campo" required aria-describedby="error-rol">
                        <option value="">Seleccione un rol</option>
                        <option value="user">Usuario</option>
                        <option value="admin">Administrador</option>
                    </select>
                    <span class="mensaje-error" id="error-rol"></span>
                </div>

                <div class="grupo-boton">
                    <button type="submit" name="registrar_desde_admin" class="boton-formulario">Crear Usuario</button>
                </div>
            </form>
        </section>
        </section>

        <!-- Tabla de usuarios -->
        <section id="tabla-usuarios-admin" class="tabla-usuarios">
            <h2>Usuarios Registrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de Usuario</th>
                        <th>Correo Electrónico</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($usuarios) && !empty($usuarios)): ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($usuario['id_user']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['usuario']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                                <td>
                                    <!-- Botón para Editar Usuario -->
                                    <button class="btn-editar-usuario"
                                        data-id="<?php echo $usuario['id_user']; ?>"
                                        data-nombre="<?php echo htmlspecialchars($usuario['nombre']); ?>"
                                        data-apellidos="<?php echo htmlspecialchars($usuario['apellidos']); ?>"
                                        data-email="<?php echo htmlspecialchars($usuario['email']); ?>"
                                        data-usuario="<?php echo htmlspecialchars($usuario['usuario']); ?>"
                                        data-telefono="<?php echo htmlspecialchars($usuario['telefono']); ?>"
                                        data-fecha-nacimiento="<?php echo htmlspecialchars($usuario['fecha_nacimiento']); ?>"
                                        data-direccion="<?php echo htmlspecialchars($usuario['direccion']); ?>"
                                        data-sexo="<?php echo htmlspecialchars($usuario['sexo']); ?>"
                                        data-rol="<?php echo htmlspecialchars($usuario['rol']); ?>">
                                        Editar
                                    </button>

                                    <!-- Formulario para Eliminar Usuario -->
                                    <form action="/rutas/rutas.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id_user" value="<?php echo $usuario['id_user']; ?>">
                                        <button type="submit" class="btn-eliminar-usuario" name="eliminar_usuario" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No hay usuarios registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <!-- Modal para editar usuario -->
        <div id="modal-editar-usuario" class="modal">
            <div class="modal-contenido">
                <span id="cerrar-modal-usuario" class="cerrar-modal">&times;</span>
                <h2>Editar Usuario</h2>
                <form id="form-editar-usuario" action="/rutas/rutas.php" method="POST">
                    <input type="hidden" name="id_user" id="id_usuario_editar">

                    <label for="nombre-editar">Nombre:</label>
                    <input type="text" name="nombre" id="nombre-editar" required>

                    <label for="apellidos-editar">Apellidos:</label>
                    <input type="text" name="apellidos" id="apellidos-editar" required>

                    <label for="email-editar">Correo Electrónico:</label>
                    <input type="email" name="email" id="email-editar" required>

                    <label for="usuario-editar">Nombre de Usuario:</label>
                    <input type="text" name="usuario" id="usuario-editar" required>

                    <label for="telefono-editar">Teléfono:</label>
                    <input type="tel" name="telefono" id="telefono-editar" required>

                    <label for="fecha_nacimiento-editar">Fecha de Nacimiento:</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento-editar" required>

                    <label for="direccion-editar">Dirección:</label>
                    <input type="text" name="direccion" id="direccion-editar" required>

                    <label for="sexo-editar">Sexo:</label>
                    <select name="sexo" id="sexo-editar" required>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Otro">Otro</option>
                    </select>

                    <label for="rol-editar">Rol:</label>
                    <select name="rol" id="rol-editar" required>
                        <option value="user">Usuario</option>
                        <option value="admin">Administrador</option>
                    </select>

                    <button type="submit" name="editar_usuario">Guardar Cambios</button>
                </form>
            </div>
        </div>



    </main>

    <!-- Pie de página -->
    <?php include __DIR__ . '/../../vistas/parciales/pieDePagina.php'; ?>

    <!-- script modal editar usuarioMODAL PENDIENTE PARA EDITAR USUARIOS -->
    <script src="/publico/js/modal_editar_usuario.js"></script>

    <!-- script validacion de formulario -->
    <script src="/publico/js/validacion_registro.js"></script>

    <!-- Vinculación con el script de mostrar/ocultar contraseña -->
    <script src="/publico/js/mostrar_contrasena.js"></script>

    <!-- Vinculación con el script de ocultar mensajes de exito y error -->
    <script src="/publico/js/ocultar_mensaje.js"></script>
</body>

</html>