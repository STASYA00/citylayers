import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
            host: 'localhost',
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                'resources/css/landing.css',
                'resources/css/legal.css',
                'resources/css/*.css',
                'resources/css/*.js',
                'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
