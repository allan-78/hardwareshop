import './bootstrap';
import 'bootstrap';
import Alpine from 'alpinejs';
import { createApp } from 'vue';
import ProductList from './components/ProductList.vue';
import ShoppingCart from './components/ShoppingCart.vue';

window.Alpine = Alpine;
Alpine.start();

// Initialize Bootstrap components
document.addEventListener('DOMContentLoaded', function() {
    // Initialize dropdowns
    const dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle, [data-bs-toggle="dropdown"]'));
    dropdownElementList.forEach(function(dropdownToggleEl) {
        new bootstrap.Dropdown(dropdownToggleEl, {
            offset: [0, 2],
            boundary: 'viewport'
        });
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function(tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Vue Application
    const app = createApp({
        data() {
            return {
                cartItems: []
            }
        },
        methods: {
            addToCart(product) {
                const existingItem = this.cartItems.find(item => item.id === product.id);
                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    this.cartItems.push({
                        ...product,
                        quantity: 1
                    });
                }
            },
            handleCheckout(items) {
                // Implement checkout logic here
                console.log('Checking out:', items);
            }
        }
    });

    app.component('product-list', ProductList);
    app.component('shopping-cart', ShoppingCart);
    app.mount('#app');
});
