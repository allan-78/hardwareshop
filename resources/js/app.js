import './bootstrap';
import Alpine from 'alpinejs';
import { createApp } from 'vue';

window.Alpine = Alpine;
Alpine.start();

// Vue Components
import ProductList from './components/ProductList.vue';
import ShoppingCart from './components/ShoppingCart.vue';

const app = createApp({});
app.component('product-list', ProductList);
app.component('shopping-cart', ShoppingCart);
app.mount('#app');

// Custom Scripts
document.addEventListener('DOMContentLoaded', () => {
    // Auto-hide alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 3000);
    });
});
