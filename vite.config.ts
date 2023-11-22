import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import vuetify, { transformAssetUrls } from "vite-plugin-vuetify";

// https://vitejs.dev/config/

export default defineConfig({
  build: {
    rollupOptions: {
      input: "./resources/js/main.ts", // Substitua pelo caminho real do seu arquivo de entrada
    },
  },
  plugins: [
    laravel({
      input: ["resources/sass/app.scss", "resources/js/app.js"],
      refresh: true,
    }),
    vue({
      template: { transformAssetUrls },
    }),
    // https://github.com/vuetifyjs/vuetify-loader/tree/next/packages/vite-plugin
    vuetify({
      autoImport: true,
    }),
  ],
  define: { "process.env": {} },
  resolve: {
    extensions: [".js", ".json", ".jsx", ".mjs", ".ts", ".tsx", ".vue"],
  },
});
