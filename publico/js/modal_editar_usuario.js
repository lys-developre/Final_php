document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modal-editar-usuario');
    const closeModalBtn = document.getElementById('cerrar-modal-usuario');
    const formEditar = document.getElementById('form-editar-usuario');

    // Ocultar el modal por defecto
    modal.style.display = 'none';

    // Función para abrir el modal al hacer clic en el botón "Editar"
    document.querySelectorAll('.btn-editar-usuario').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            // Obtener los valores de los atributos data-* del botón
            const idUsuario = this.dataset.id;
            const nombre = this.dataset.nombre;
            const apellidos = this.dataset.apellidos;
            const email = this.dataset.email;
            const usuario = this.dataset.usuario;
            const telefono = this.dataset.telefono;
            const fechaNacimiento = this.dataset['fecha-nacimiento'];
            const direccion = this.dataset.direccion;
            const sexo = this.dataset.sexo; // Valor actual del sexo del usuario
            const rol = this.dataset.rol;

            // Rellenar los campos del modal con los valores correspondientes
            document.getElementById('id_usuario_editar').value = idUsuario;
            document.getElementById('nombre-editar').value = nombre;
            document.getElementById('apellidos-editar').value = apellidos;
            document.getElementById('email-editar').value = email;
            document.getElementById('usuario-editar').value = usuario;
            document.getElementById('telefono-editar').value = telefono;

            // Formatear la fecha de nacimiento correctamente si es necesario
            document.getElementById('fecha_nacimiento-editar').value = fechaNacimiento;
            document.getElementById('direccion-editar').value = direccion;

            // Establecer el valor del campo "sexo"
            const sexoSelect = document.getElementById('sexo-editar');
            
            // Buscar la opción que coincide con el valor del sexo del usuario
            Array.from(sexoSelect.options).forEach(function(option) {
                if (option.value === sexo) {
                    option.selected = true; 
                }
            });

            // Establecer el valor del campo "rol"
            const rolSelect = document.getElementById('rol-editar');
            rolSelect.value = rol;

            // Mostrar el modal
            modal.style.display = 'block';
        });
    });

    // Cerrar el modal al hacer clic en el botón de cerrar
    closeModalBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Cerrar el modal al hacer clic fuera de él
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
});
