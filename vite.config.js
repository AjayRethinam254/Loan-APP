import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
  plugins: [
    vue(),
    laravel({
      input: ['resources/css/app.css', 'resources/js/main.js'],
      refresh: true,
    }),
    tailwindcss(),
  ],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/js'),
      '@core': path.resolve(__dirname, 'resources/js/core'),
      '@styles': path.resolve(__dirname, 'resources/styles'),
      '@core-scss': path.resolve(__dirname, 'resources/scss/core'),
    },
  },
});
