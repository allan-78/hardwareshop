class Cart {
    constructor() {
        this.items = [];
        this.total = 0;
        this.init();
    }

    init() {
        // Load cart from localStorage
        const savedCart = localStorage.getItem('cart');
        if (savedCart) {
            this.items = JSON.parse(savedCart);
            this.updateTotal();
        }

        // Add to cart buttons
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', (e) => {
                const productId = e.target.dataset.productId;
                const price = parseFloat(e.target.dataset.price);
                const name = e.target.dataset.name;
                this.addItem({ id: productId, name, price });
            });
        });
    }

    addItem(product) {
        const existing = this.items.find(item => item.id === product.id);
        if (existing) {
            existing.quantity += 1;
        } else {
            this.items.push({ ...product, quantity: 1 });
        }
        this.updateCart();
    }

    updateCart() {
        this.updateTotal();
        localStorage.setItem('cart', JSON.stringify(this.items));
        this.updateUI();
    }

    updateTotal() {
        this.total = this.items.reduce((sum, item) => 
            sum + (item.price * item.quantity), 0);
    }

    updateUI() {
        const cartCount = document.querySelector('.cart-count');
        const cartTotal = document.querySelector('.cart-total');
        if (cartCount) cartCount.textContent = this.items.length;
        if (cartTotal) cartTotal.textContent = `$${this.total.toFixed(2)}`;
    }
}

// Initialize cart
new Cart();