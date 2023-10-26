import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import fs from 'fs';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/filament.css',
                'resources/js/app.js',
                'resources/js/pages/extended-plyr.js',
                'resources/js/pages/highlight.js',
                'node_modules/plyr/dist/plyr.css'
            ],
            // refresh: true,
            refresh: [
                ...refreshPaths,
                'tailwind.config.js',
                'app/Http/Livewire/**',
                'resources/js/pages/extended-plyr.js',
                'resources/js/pages/highlight.js',
                'node_modules/plyr/dist/plyr.css',
                'app/Filament/**',
                'resources/views/**/*.blade.php',
                'resources/views/filament/pages/*.blade.php',
                './resources/forms/components*.blade.php',
            ],
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            host: 'localhost'
        },
        // https: {
        //     key: fs.readFileSync(`/code/infrastructure/ssl/plex.key`),
        //     cert: fs.readFileSync(`/code/infrastructure/ssl/plex.crt`),
        // },
    }
});
