// resources/js/app.js
// import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '../css/app.css';


document.addEventListener('livewire:navigated', () => {
        initFlowbite();
});

document.addEventListener('livewire:navigated', () => {
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');
    
        // Toggle dropdown visibility
        dropdownButton.addEventListener('click', () => {
          dropdownMenu.classList.toggle('hidden');
        });
    
        // Close dropdown if clicked outside
        document.addEventListener('click', (e) => {
          if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
          }
        });
});




