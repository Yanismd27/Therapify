import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    assetsInclude: ['**/*.mp3'],
    resolve: {
        alias: [
            {
                find: '@',
                replacement: path.resolve(__dirname, 'resources/js')
            },
            {
                find: '~',
                replacement: path.resolve(__dirname, 'resources/js')
            },
            {
                find: 'ziggy',
                replacement: path.resolve(__dirname, 'vendor/tightenco/ziggy/src/js')
            }
        ]
    },
    optimizeDeps: {
        include: ['vue', '@inertiajs/vue3', 'vue-toastification'],
    },
    build: {
        chunkSizeWarningLimit: 1600,
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['vue', '@inertiajs/vue3', 'vue-toastification'],
                },
            },
        },
    },
});