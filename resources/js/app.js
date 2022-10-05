import "./bootstrap";

// Main Stylesheet
import "./assets/scss/main.scss";

// All color themes are included and available by default
// Feel free to comment out any of them if you won't use them in your project
import "./assets/scss/oneui/themes/amethyst.scss";
import "./assets/scss/oneui/themes/city.scss";
import "./assets/scss/oneui/themes/flat.scss";
import "./assets/scss/oneui/themes/modern.scss";
import "./assets/scss/oneui/themes/smooth.scss";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { createPinia } from "pinia";
import i18n from "./plugins/i18n";

// Template directives
import clickRipple from "@/directives/clickRipple";

// Bootstrap framework
import * as bootstrap from "bootstrap";
import AdminLayout from "./Layouts/AdminLayout.vue";
window.bootstrap = bootstrap;

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        const page = (
            await resolvePageComponent(
                `./Pages/${name}.vue`,
                import.meta.glob("./Pages/**/*.vue")
            )
        ).default;

        if (page.layout === undefined) {
            page.layout = AdminLayout;
        }

        return page;
    },
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(i18n)
            .directive("click-ripple", clickRipple)
            .use(createPinia())
            .mount(el);
    },
});

// InertiaProgress.init({ color: "#4B5563" });
InertiaProgress.init({
    // The delay after which the progress bar will
    // appear during navigation, in milliseconds.
    delay: 250,

    // The color of the progress bar.
    // color: "#4B5563",

    // Whether to include the default NProgress styles.
    includeCSS: true,

    // Whether the NProgress spinner will be shown.
    showSpinner: false,
});
