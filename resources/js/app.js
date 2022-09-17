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

// Template directives
import clickRipple from "@/directives/clickRipple";

// Bootstrap framework
import * as bootstrap from "bootstrap";
window.bootstrap = bootstrap;

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .directive("click-ripple", clickRipple)
            .use(createPinia())
            .mount(el);
    },
});

InertiaProgress.init({ color: "#4B5563" });
