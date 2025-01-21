import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        hmr: {
            host:'mollusk-neutral-partially.ngrok-free.app', // Change to your host if needed
            protocol: 'wss', // Can be 'wss' for secure WebSocket connections
        },
    },
});
