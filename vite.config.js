import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        // CSS
        'resources/css/style.css',
        'resources/css/styleJuego.css',
        'resources/css/styleR.css',
        // JS
        'resources/js/scriptM.js',
        'resources/js/scriptR.js',
        'resources/js/script.js',
      ],
      refresh: true,
    }),
  ],
})
