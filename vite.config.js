import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'public/js/tinymce/skins/ui/oxide-dark/skin.css',
                'resources/js/app.js',
                'resources/js/jquery.js'
            ],
            refresh: true,
        }),
    ],
});
