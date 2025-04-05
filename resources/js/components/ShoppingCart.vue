<template>
    <div class="shopping-cart">
        <div class="list-group">
            <div v-for="item in items" :key="item.id" class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">{{ item.name }}</h6>
                        <small class="text-muted">₱{{ formatPrice(item.price) }} x {{ item.quantity }}</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <button @click="updateQuantity(item, -1)" 
                                class="btn btn-sm btn-outline-secondary me-2">-</button>
                        <span>{{ item.quantity }}</span>
                        <button @click="updateQuantity(item, 1)" 
                                class="btn btn-sm btn-outline-secondary ms-2">+</button>
                        <button @click="removeItem(item)" 
                                class="btn btn-sm btn-danger ms-3">&times;</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <strong>Total:</strong>
                <span>₱{{ formatPrice(total) }}</span>
            </div>
            <button @click="checkout" 
                    class="btn btn-success w-100 mt-3"
                    :disabled="!items.length">
                Checkout
            </button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            items: []
        }
    },
    computed: {
        total() {
            return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        }
    },
    methods: {
        formatPrice(price) {
            return Number(price).toLocaleString('en-PH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        },
        updateQuantity(item, change) {
            const newQuantity = item.quantity + change;
            if (newQuantity > 0) {
                item.quantity = newQuantity;
            }
        },
        removeItem(item) {
            const index = this.items.indexOf(item);
            if (index > -1) {
                this.items.splice(index, 1);
            }
        },
        checkout() {
            // Implement checkout logic
            this.$emit('checkout', this.items);
        }
    }
}
</script>