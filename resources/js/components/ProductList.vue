<template>
    <div class="row g-4">
        <div v-for="product in products" :key="product.id" class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100">
                <div class="product-image-container">
                    <img :src="product.primary_image_url" 
                         :alt="product.name"
                         class="card-img-top">
                </div>
                <div class="card-body">
                    <h3 class="card-title h6">
                        <a :href="'/products/' + product.id" class="text-decoration-none">
                            {{ product.name }}
                        </a>
                    </h3>
                    <p class="card-text text-muted">{{ product.brand.name }}</p>
                    <p class="card-text fw-bold">₱{{ formatPrice(product.price) }}</p>
                    <button @click="addToCart(product)" 
                            class="btn btn-primary w-100">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        products: {
            type: Array,
            required: true
        }
    },
    methods: {
        formatPrice(price) {
            return Number(price).toLocaleString('en-PH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        },
        addToCart(product) {
            // Emit event to parent component
            this.$emit('add-to-cart', product);
        }
    }
}
</script>