<script setup>
import { ref, watch, onMounted } from "vue";
import { useMainStore } from "@/stores/main";
import { Link } from "@inertiajs/inertia-vue3";

import BaseNavigation from "@/Components/BaseNavigation.vue";

// SimpleBar, for more info and examples you can check out https://github.com/Grsmto/simplebar/tree/master/packages/simplebar-vue
import SimpleBar from "simplebar";

// Grab menu navigation arrays
import menu from "@/data/menu";
import DarkmodeDropdown from "@/Components/Dropdowns/DarkmodeDropdown.vue";

// Component properties
defineProps({
    withMiniNav: {
        type: Boolean,
        default: false,
        description: "If the sidebar is in Mini Nav Mode",
    },
});

const navigation = menu.main;

// Main store
const store = useMainStore();

// Init SimpleBar (custom scrolling)
onMounted(() => {
    new SimpleBar(document.getElementById("simplebar-sidebar"));
});
</script>

<template>
    <!-- Sidebar -->
    <!--
    Sidebar Mini Mode - Display Helper classes

    Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
    Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
    If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

    Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
    Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
    Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
  -->
    <nav
        id="sidebar"
        :class="{ 'with-mini-nav': withMiniNav }"
        aria-label="Main Navigation"
    >
        <slot>
            <!-- Side Header -->
            <div class="content-header">
                <slot name="header">
                    <!-- Logo -->
                    <Link href="/" class="d-flex gap-2 fw-semibold text-dual">
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
                    <!-- END Logo -->
                </slot>

                <!-- Extra -->
                <div>
                    <slot name="header-extra">
                        <!-- Dark Mode -->
                        <!-- <DarkmodeDropdown /> -->
                        <!-- END Dark Mode -->
                    </slot>

                    <!-- Close Sidebar, Visible only on mobile screens -->
                    <button
                        type="button"
                        class="d-lg-none btn btn-sm btn-alt-secondary ms-1"
                        @click="store.sidebar({ mode: 'close' })"
                    >
                        <i class="fa fa-fw fa-times"></i>
                    </button>
                    <!-- END Close Sidebar -->
                </div>
                <!-- END Extra -->
            </div>
            <!-- END Side Header -->

            <!-- Sidebar Scrolling -->
            <div id="simplebar-sidebar" class="js-sidebar-scroll">
                <slot name="content">
                    <!-- Side Navigation -->
                    <div class="content-side">
                        <BaseNavigation :nodes="navigation" />
                    </div>
                    <!-- END Side Navigation -->
                </slot>
            </div>
            <!-- END Sidebar Scrolling -->
        </slot>
    </nav>
    <!-- END Sidebar -->
</template>
