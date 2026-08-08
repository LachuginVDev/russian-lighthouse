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
      },
    },
  },
  server: {
    port: 5173,
    open: true,
  },
});
