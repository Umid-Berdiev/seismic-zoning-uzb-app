<script setup>
import { computed, onMounted } from "vue";
import { useMainStore } from "@/stores/main";

// Import all layout partials
import BaseHeader from "@/Layouts/partials/Header.vue";
import BaseSidebar from "@/Layouts/partials/Sidebar.vue";
import BaseSideOverlay from "@/Layouts/partials/SideOverlay.vue";
import { Link, usePage } from "@inertiajs/inertia-vue3";

// Component properties
defineProps({
    sidebarWithMiniNav: {
        type: Boolean,
        default: false,
        description: "If the sidebar is in Mini Nav Mode",
    },
});

// Main store
const store = useMainStore();
const authUser = computed(() => usePage().props.value.auth.user);
// store.sidebar({ mode: "close" });

// Set default elements for this layout
store.setLayout({
    header: true,
    sidebar: authUser.value.role_slug === "admin",
    sideOverlay: false,
    footer: true,
});

// Set various template options for this layout variation
store.headerStyle({ mode: "light" });
store.mainContent({ mode: "narrow" });

// Set default color theme
store.setColorTheme({
    theme: store.settings.colorTheme,
});

// Render main classes based on store options
const classContainer = computed(() => {
    return {
        "sidebar-r": store.layout.sidebar && !store.settings.sidebarLeft,
        "sidebar-mini": store.layout.sidebar && store.settings.sidebarMini,
        "sidebar-o":
            store.layout.sidebar && store.settings.sidebarVisibleDesktop,
        "sidebar-o-xs":
            store.layout.sidebar && store.settings.sidebarVisibleMobile,
        "side-overlay-o":
            store.layout.sideOverlay && store.settings.sideOverlayVisible,
        "side-overlay-hover":
            store.layout.sideOverlay && store.settings.sideOverlayHoverable,
        "enable-page-overlay":
            store.layout.sideOverlay && store.settings.pageOverlay,
        "page-header-fixed": store.layout.header && store.settings.headerFixed,
        "page-header-dark":
            store.layout.header &&
            store.settings.headerDark &&
            !store.settings.darkMode,
        "main-content-boxed": store.settings.mainContent === "boxed",
        "main-content-narrow": store.settings.mainContent === "narrow",
        "rtl-support": store.settings.rtlSupport,
        "side-trans-enabled": store.settings.sideTransitions,
        "side-scroll": true,
        "sidebar-dark page-header-dark dark-mode": store.settings.darkMode,
    };
});

// Change dark mode based on dark mode system preference
if (store.settings.darkModeSystem) {
    if (
        window.matchMedia &&
        window.matchMedia("(prefers-color-scheme: dark)").matches
    ) {
        store.darkMode({ mode: "on" });
    } else {
        store.darkMode({ mode: "off" });
    }
}

// Remove side transitions on window resizing
onMounted(() => {
    let winResize = false;

    window.addEventListener("resize", () => {
        clearTimeout(winResize);

        store.setSideTransitions({ transitions: false });

        winResize = setTimeout(() => {
            store.setSideTransitions({ transitions: true });
        }, 500);
    });

    // Remove labels from
    document.querySelectorAll("#datasetLength label").forEach((el) => {
        el.remove();
    });

    // Replace select classes
    let selectLength = document.querySelector("#datasetLength select");

    if (selectLength) {
        selectLength.classList = "";
        selectLength.classList.add("form-select");
    }
});
</script>

<template>
    <div id="page-container" :class="classContainer">
        <!-- Page Loader -->
        <div
            id="page-loader"
            :class="{ show: store.settings.pageLoader }"
        ></div>

        <!-- Page Overlay -->
        <div
            id="page-overlay"
            v-if="store.layout.sideOverlay && store.settings.pageOverlay"
            @click="store.sideOverlay({ mode: 'close' })"
        ></div>
        <!-- END Page Overlay -->

        <!-- Side Overlay -->
        <!-- <BaseSideOverlay v-if="store.layout.sideOverlay">
            <template #header>
                <slot name="side-overlay-header"></slot>
            </template>

            <template #content>
                <slot name="side-overlay-content"></slot>
            </template>

            <slot name="side-overlay"></slot>
        </BaseSideOverlay> -->
        <!-- END Side Overlay -->

        <!-- Sidebar -->
        <BaseSidebar
            v-if="store.layout.sidebar"
            :with-mini-nav="sidebarWithMiniNav"
        >
            <template #header>
                <slot name="sidebar-header"></slot>
            </template>

            <template #header-extra>
                <slot name="sidebar-header-extra"></slot>
            </template>

            <template #content>
                <slot name="sidebar-content"></slot>
            </template>

            <slot name="sidebar"></slot>
        </BaseSidebar>
        <!-- END Sidebar -->

        <!-- Header -->
        <BaseHeader v-if="store.layout.header">
            <template #content-left>
                <slot name="header-content-left">
                    <div v-if="authUser.role_slug !== 'admin'">
                        <Link
                            href="/"
                            class="d-flex gap-2 fw-semibold text-dual"
                        >
                            <span class="">
                                <!-- <i class="fa fa-circle-notch text-primary"></i> -->
                                <img
                                    src="/images/circle-cropped.png"
                                    alt="main_logo"
                                    width="20"
                                />
                            </span>
                            <span class="smini-hide fs-5 tracking-wider">
                                {{ store.app.name }}
                            </span>
                        </Link>
                    </div>
                </slot>
            </template>

            <template #content-right>
                <slot name="header-content-right"></slot>
            </template>

            <template #content>
                <slot name="header-content"></slot>
            </template>
            <slot name="header"></slot>
        </BaseHeader>
        <!-- END Header -->

        <!-- Main Container -->
        <div id="main-container">
            <slot name="page-top-content"></slot>
            <slot />
        </div>
        <!-- END Main Container -->
    </div>
</template>
