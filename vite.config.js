import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'node:path';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/scss/main.scss',
        'resources/js/main.js',
        'resources/js/pages/albums.js',
        'resources/js/pages/album.js',
        'resources/js/pages/video.js',
        'resources/js/pages/photos.js',
        'resources/js/pages/photo-report.js',
        'resources/js/pages/news.js',
        'resources/js/pages/news-single.js',
        'resources/js/pages/concerts.js',
        'resources/js/pages/concert-single.js',
        'resources/js/pages/static.js',
      ],
      refresh: true,
    }),
  ],
  resolve: {
    alias: {
      '@': resolve('resources/js'),
    },
  },
  css: {
    preprocessorOptions: {
      scss: {
        api: 'modern-compiler',
      },
    },
  },
  server: {
    watch: {
      ignored: ['**/storage/framework/views/**'],
    },
  },
});
