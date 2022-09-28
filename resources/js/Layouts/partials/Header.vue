<script setup>
import { ref, onMounted, onUnmounted, computed } from "vue";
import { useMainStore } from "@/stores/main";
import LocalesDropdown from "@/Components/LocalesDropdown.vue";

// Grab example data
import notifications from "@/data/notifications";
import UserDropdown from "../../Components/UserDropdown.vue";

// Main store and Router
const store = useMainStore();

// Reactive variables
const baseSearchTerm = ref("");

// On form search submit functionality
function onSubmitSearch() {
    // route("/admin/pages/generic/search?" + baseSearchTerm.value);
    // router.push("/backend/pages/generic/search?" + baseSearchTerm.value);
}

// When ESCAPE key is hit close the header search section
function eventHeaderSearch(event) {
    if (event.which === 27) {
        event.preventDefault();
        store.headerSearch({ mode: "off" });
    }
}

function toggleFullScreen() {
    // UniversalXPConnect privilege is required in Firefox
    try {
        if (window.netscape && netscape.security) {
            // Firefox
            netscape.security.PrivilegeManager.enablePrivilege(
                "UniversalXPConnect"
            );
        }
    } catch (e) {
        alert("UniversalXPConnect privilege is required for this operation!");
        return;
    }

    if ("fullScreen" in window) {
        window.fullScreen = !window.fullScreen;
    } else {
        alert("Your browser does not support this example!");
    }
}

// Attach ESCAPE key event listener
onMounted(() => {
    document.addEventListener("keydown", eventHeaderSearch);
});

// Remove keydown event listener
onUnmounted(() => {
    document.removeEventListener("keydown", eventHeaderSearch);
});
</script>

<template>
    <!-- Header -->
    <header id="page-header">
        <slot>
            <!-- Header Content -->
            <div class="content-header px-0">
                <slot name="content">
                    <!-- Left Section -->
                    <div class="d-flex align-items-center">
                        <slot name="content-left">
                            <!-- Toggle Sidebar -->
                            <button
                                type="button"
                                class="btn btn-sm btn-alt-secondary me-2 d-lg-none"
                                @click="store.sidebar({ mode: 'toggle' })"
                            >
                                <i class="fa fa-fw fa-bars"></i>
                            </button>
                            <!-- END Toggle Sidebar -->

                            <!-- Toggle Mini Sidebar -->
                            <button
                                type="button"
                                class="btn me-2 d-none d-lg-inline-block"
                                @click="store.sidebarMini({ mode: 'toggle' })"
                            >
                                <i
                                    v-if="store.settings.sidebarMini"
                                    class="fa fa-fw fa-chevron-right"
                                ></i>
                                <i v-else class="fa fa-fw fa-chevron-left"></i>
                            </button>
                            <!-- END Toggle Mini Sidebar -->
                        </slot>
                    </div>
                    <!-- END Left Section -->

                    <!-- Right Section -->
                    <div class="d-flex align-items-center">
                        <slot name="content-right">
                            <button
                                class="btn btn-sm btn-alt-light"
                                @click="toggleFullScreen"
                            >
                                {{ $t("full_screen_mode_text") }}
                            </button>
                            <!-- User Dropdown -->
                            <UserDropdown />
                            <!-- END User Dropdown -->

                            <!-- locale dropdown -->
                            <LocalesDropdown />
                        </slot>
                    </div>
                    <!-- END Right Section -->
                </slot>
            </div>
            <!-- END Header Content -->

            <!-- Header Search -->
            <div
                id="page-header-search"
                class="overlay-header bg-body-extra-light"
                :class="{ show: store.settings.headerSearch }"
            >
                <div class="content-header">
                    <form class="w-100" @submit.prevent="onSubmitSearch">
                        <div class="input-group">
                            <button
                                type="button"
                                class="btn btn-alt-danger"
                                @click="store.headerSearch({ mode: 'off' })"
                            >
                                <i class="fa fa-fw fa-times-circle"></i>
                            </button>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Search or hit ESC.."
                                id="page-header-search-input"
                                name="page-header-search-input"
                                v-model="baseSearchTerm"
                            />
                        </div>
                    </form>
                </div>
            </div>
            <!-- END Header Search -->

            <!-- Header Loader -->
            <div
                id="page-header-loader"
                class="overlay-header bg-body-extra-light"
                :class="{ show: store.settings.headerLoader }"
            >
                <div class="content-header">
                    <div class="w-100 text-center">
                        <i class="fa fa-fw fa-circle-notch fa-spin"></i>
                    </div>
                </div>
            </div>
            <!-- END Header Loader -->
        </slot>
    </header>
    <!-- END Header -->
</template>
