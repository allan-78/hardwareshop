import './bootstrap';
import 'bootstrap';

window.Alpine = Alpine;
Alpine.start();

// Vue Components
import ProductList from './components/ProductList.vue';
import ShoppingCart from './components/ShoppingCart.vue';

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

// Custom JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    });

    // Auto-hide alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 3000);
    });
});
