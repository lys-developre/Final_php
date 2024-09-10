document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modal-editar-cita');
    const closeModalBtn = document.getElementById('cerrar-modal');
    const formEditar = document.getElementById('form-editar');

    // Ocultar el modal por defecto
    modal.style.display = 'none';

    // Función para abrir el modal al hacer clic en el botón "Editar"
    document.querySelectorAll('.btn-editar').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const idCita = this.dataset.id;
            const fecha = this.dataset.fecha;
            const descripcion = this.dataset.descripcion;

            // Rellenar los campos del modal con los valores correspondientes
            document.getElementById('id_cita_editar').value = idCita;
            document.getElementById('fecha-editar').value = fecha;
            document.getElementById('descripcion-editar').value = descripcion;

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
