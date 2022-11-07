import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import vueI18n from "@intlify/vite-plugin-vue-i18n";
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: "resources/js/app.js",
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),

        /**
         * vite-plugin-vue-i18n plugin does i18n resources pre-compilation / optimizations
         *
         * @see https://github.com/intlify/bundle-tools/tree/main/packages/vite-plugin-vue-i18n
         */
        vueI18n({
            include: path.resolve(__dirname, "./resources/js/locales/**"),
        }),
    ],
});
