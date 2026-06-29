import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';

// Initialize AOS when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    AOS.init({
        duration: 800,
        once: false,
        mirror: true,
        easing: 'ease-out-cubic',
        offset: 80,
    });
});