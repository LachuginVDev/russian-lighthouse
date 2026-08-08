import { defineConfig } from 'vite';
import { resolve } from 'node:path';
import injectHTML from 'vite-plugin-html-inject';

const root = import.meta.dirname;

export default defineConfig({
  root: '.',
  publicDir: 'public',
  plugins: [injectHTML()],
  resolve: {
    alias: {
      '@': resolve(root, 'src'),
      '@partials': resolve(root, 'src/partials'),
    },
  },
  css: {
    preprocessorOptions: {
      scss: {
        api: 'modern-compiler',
      },
    },
  },
  build: {
    target: 'es2020',
    cssCodeSplit: true,
    rollupOptions: {
      input: {
        main: resolve(root, 'index.html'),
        albums: resolve(root, 'albums.html'),
        album: resolve(root, 'album.html'),
        video: resolve(root, 'video.html'),
        photos: resolve(root, 'photos.html'),
        photoReport: resolve(root, 'photo-report.html'),
        news: resolve(root, 'news.html'),
        newsSingle: resolve(root, 'news-single.html'),
        concerts: resolve(root, 'concerts.html'),
        concertSingle: resolve(root, 'concert-single.html'),
      },
    },
  },
  server: {
    port: 5173,
    open: true,
  },
});
