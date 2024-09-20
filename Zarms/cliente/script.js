//parte de categorias en el header
// Seleccionamos el botón de comprar y el menú desplegable
const comprarBtn = document.getElementById('comprar-btn');
const dropdownMenu = document.getElementById('categorias');

// Función para mostrar/ocultar el menú desplegable
comprarBtn.addEventListener('click', function (e) {
  e.preventDefault();
  dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
});

// Función para ocultar el menú al hacer clic fuera del mismo
document.addEventListener('click', function (event) {
  const isClickInside = comprarBtn.contains(event.target) || dropdownMenu.contains(event.target);

  // Si el clic está fuera del botón de comprar y del menú desplegable, ocultar el menú
  if (!isClickInside) {
    dropdownMenu.style.display = 'none';
  }
});


//parte del cronometro de las ofertas

// Fecha de finalización: 3 días a partir del momento actual
document.addEventListener('DOMContentLoaded', () => {
  // Fecha de finalización: 3 días a partir del momento actual
  const endDate = new Date();
  endDate.setDate(endDate.getDate() + 3);

  // Función para actualizar el cronómetro
  function updateCountdown() {
      const now = new Date();
      const timeLeft = endDate - now;

      if (timeLeft <= 0) {
          document.getElementById('days').innerText = '00';
          document.getElementById('hours').innerText = '00';
          document.getElementById('minutes').innerText = '00';
          document.getElementById('seconds').innerText = '00';
          return;
      }

      const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
      const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

      // Actualizar el HTML con los valores
      document.getElementById('days').innerText = String(days).padStart(2, '0');
      document.getElementById('hours').innerText = String(hours).padStart(2, '0');
      document.getElementById('minutes').innerText = String(minutes).padStart(2, '0');
      document.getElementById('seconds').innerText = String(seconds).padStart(2, '0');
  }

  // Llama a la función para actualizar el cronómetro cada segundo
  setInterval(updateCountdown, 1000);

  // Llamada inicial para que el cronómetro se muestre inmediatamente
  updateCountdown();
});