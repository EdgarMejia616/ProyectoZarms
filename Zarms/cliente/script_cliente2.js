// Función para alternar la visibilidad de la contraseña
function togglePassword() {
    // Obtener el campo de contraseña y el botón de alternar
    var passwordField = document.getElementById('contraseña');
    var toggleButton = document.getElementById('togglePassword');

    // Comprobar el contenido del campo de contraseña y alternar su visibilidad
    if (passwordField.textContent === '********') {
        passwordField.textContent = passwordField.getAttribute('data-password'); // Muestra la contraseña real
        toggleButton.textContent = 'Ocultar';
    } else {
        passwordField.textContent = '********'; // Oculta la contraseña
        toggleButton.textContent = 'Mostrar';
    }
}

// Asegurarse de que la función se ejecute solo después de que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    var toggleButton = document.getElementById('togglePassword');
    
    if (toggleButton) {
        toggleButton.addEventListener('click', togglePassword);
    }
});
