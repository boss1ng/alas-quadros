import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import os from 'node:os'; // Correct import for ESM

function getLocalIp() {
    const interfaces = os.networkInterfaces();
    for (const iface of Object.values(interfaces)) {
        for (const details of iface || []) {
            if (details.family === 'IPv4' && !details.internal) {
                console.log('Found IP Address:', details.address); // Log for debugging
                return details.address;
            }
        }
    }
    return 'localhost'; // Fallback if no IP is found
}

export default defineConfig({
    server: {
        host: true, // Enables external access
        hmr: {
            host: getLocalIp(), // Dynamically sets the local IP
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
