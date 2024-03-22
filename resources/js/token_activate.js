$(document).ready(function() {
    $('#activarBtn').click(function() {
        window.location.href = '/token/estado/{{token}}';
    });

    $('#cancelarBtn').click(function() {
        // Agrega aquí el código para cancelar
        console.log('Botón Cancelar clicado.');
    });
});