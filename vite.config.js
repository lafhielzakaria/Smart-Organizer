import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/tenant-dashboard.css',
                'resources/js/tenant-dashboard.js',
                'resources/css/lessor-dashboard.css',
                'resources/js/lessor-dashboard.js',
                'resources/css/admin-dashboard.css',
                'resources/js/admin-dashboard.js',
                'resources/css/points-charge.css',
                'resources/js/points-charge.js',
                'resources/css/membership-benefits.css',
                'resources/css/back-button.css',
                'resources/css/welcome.css',
                'resources/js/welcome.js',
                'resources/css/layout-auth.css',
                'resources/js/layout-auth.js',
                'resources/css/layout-app.css',
                'resources/css/offer-details.css'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
