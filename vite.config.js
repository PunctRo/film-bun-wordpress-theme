import { defineConfig } from 'vite';
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';

export default defineConfig({
    base: '/',
    publicDir: false,
    build: {
        outDir: 'dist',
        rollupOptions: {
            input: './assets/js/main.js',
        },
        emptyOutDir: true,
    },
    server: {
        host: '0.0.0.0',
        port: 3000,
        watch: {
            usePolling: true,
        },
        hmr: {
            host: 'localhost',
        },
    },
    css: {
        postcss: {
            plugins: [
                tailwindcss({
                    config: './tailwind.config.js'
                }),
                autoprefixer(),
            ],
        },
    },
});
