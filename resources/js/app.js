// resources/js/app.js
// import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '../css/app.css';

document.addEventListener('livewire:navigated', () => {
    console.log("Navigated");
})