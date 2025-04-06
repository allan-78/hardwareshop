import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        vue(),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `
                    @import "bootstrap/scss/functions";
                    @import "bootstrap/scss/variables";
                    @import "bootstrap/scss/mixins";
                `
            }
        }
    }
});
