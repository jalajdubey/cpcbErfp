import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
<<<<<<< Updated upstream
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
=======
            // 🔹 Multiple entry points:
            //    - app.js → for public pages
            //    - loggedin.js → for logged-in users
            //    - app.css → shared styles
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/loggedin.css',
                'resources/css/loggedin.css',
                'resources/js/loggedin.js', // 🆕 Added for logged-in users
            ],
            refresh: true, // ✅ Keeps hot-reload for all files
        }),
    ],

    build: {
        outDir: resolve(__dirname, 'public/build'),
        emptyOutDir: true, // ✅ Clean old builds once
        manifest: true,    // ✅ Laravel uses this for @vite()

        // 🧩 Rollup config for optimized caching & chunking
        rollupOptions: {
            output: {
                // ⚙️ Instead of disabling chunks, define vendor splitting
                // This ensures shared libs like jQuery, Bootstrap, Axios, Chart.js
                // go into a common vendor chunk (cached across all bundles)
                manualChunks: {
                    vendor: ['jquery', 'bootstrap', 'axios', 'chart.js'], // 🆕 Shared dependencies
                },
            },
            external: [
             '/assets/**', // prevent re-bundling static assets from public
            ],
        },

        // 🪶 Asset handling
        assetsInlineLimit: 0,      // ✅ Prevents large assets from embedding as base64
        cssMinify: true,           // ✅ Compress CSS for smaller build
        chunkSizeWarningLimit: 1000, // ✅ Avoids console warnings for large chunks
    },

    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources'), // ✅ Shortcut for imports
        },
    },

    // ⚡ Public assets directory
    // This ensures fonts/images from public/assets/ remain accessible
    //publicDir: 'public/assets',
>>>>>>> Stashed changes
});
