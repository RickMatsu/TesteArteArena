import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        laravel({
            input: "resources/js/app.js",
            refresh: true,
        }),
        react(),
    ],
    server: {
        port: 8000, 
      },
      proxy: {
        '/': 'http://127.0.0.1:8000', // Proxy para o servidor Laravel
      },
});