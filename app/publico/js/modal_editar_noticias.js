document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modal-editar-noticia');
    const closeModalBtn = document.getElementById('cerrar-modal');
    const formEditar = document.getElementById('form-editar');

    // Ocultar el modal por defecto
    modal.style.display = 'none';

    // Función para abrir el modal al hacer clic en el botón "Editar"
    document.querySelectorAll('.btn-editar').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const idNoticia = this.dataset.id;
            const titulo = this.dataset.titulo;
            const texto = this.dataset.texto;

            // Rellenar los campos del modal con los valores correspondientes
            document.getElementById('id_noticia_editar').value = idNoticia;
            document.getElementById('titulo-editar').value = titulo;
            document.getElementById('texto-editar').value = texto;

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
