import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/select2.min.css',
                'resources/scss/app.scss',
                'resources/scss/admin.scss',
                'resources/js/app.js',
                'resources/js/jquery-3.7.1.js',
                'resources/js/select2.min.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 9695,
    },
});
