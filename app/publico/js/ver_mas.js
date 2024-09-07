document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.ver-mas').forEach(function(boton) {
        boton.addEventListener('click', function(event) {
            event.preventDefault();
            let textoCompleto = "Texto completo de la noticia...";
            this.previousElementSibling.innerHTML = textoCompleto;
            this.remove();
        });
    });
});
