import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/pages/admin.css',
                'resources/js/pages/admin-dashboard.js',
                'resources/js/pages/admin-unassigned-toggle.js',
                'resources/css/pages/channel.css',
                'resources/css/pages/email-handler.css',
                'resources/css/pages/records-table.css',
                'resources/css/pages/welcome.css',
                'resources/js/pages/landing.js',
                'resources/js/pages/officer-records.js',
                'resources/js/pages/records-table.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
