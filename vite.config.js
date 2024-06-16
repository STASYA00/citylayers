import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { globSync } from "glob";

export default defineConfig({
    server: {
            host: 'localhost',
    },
    plugins: [
        laravel({
            input: globSync("resources/{css,js}/**/*.{css,js}"),

            refresh: true,
        }),
    ],
});
