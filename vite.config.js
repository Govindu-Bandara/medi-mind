import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/sass/app.scss', 'resources/js/app.js'],
      refresh: true,  // Automatically refresh on file changes
    }),
  ],
  build: {
    outDir: 'public/build', // Ensure this points to the correct build folder
  }, 
});
