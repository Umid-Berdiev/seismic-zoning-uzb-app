<script setup>
import { ref, onMounted, onUnmounted, computed } from "vue";
import { useMainStore } from "@/stores/main";
import { useForm, usePage } from "@inertiajs/inertia-vue3";

// Grab example data
import notifications from "@/data/notifications";

// Main store and Router
const store = useMainStore();

// Reactive variables
const baseSearchTerm = ref("");
const authUser = computed(() => usePage().props.value.auth.user);

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
            <div class="content-header">
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
                            Press this button,
                            <button class="btn" @click="toggleFullScreen">
                                Change full screen mode!
                            </button>
                            or press F11 to toggle between normal and full
                            screen mode.
                            <!-- User Dropdown -->
                            <div class="dropdown d-inline-block ms-2">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-alt-secondary"
                                    id="page-header-user-dropdown"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >
                                    <!-- <img
                                        class="rounded-circle"
                                        src="/assets/media/avatars/avatar10.jpg"
                                        alt="Header Avatar"
                                        style="width: 21px"
                                    /> -->
                                    <span class="d-none d-sm-inline-block ms-2">
                                        {{ authUser.username }}
                                    </span>
                                    <i
                                        class="fa fa-fw fa-angle-down d-none d-sm-inline-block opacity-50 ms-1 mt-1"
                                    ></i>
                                </button>
                                <div
                                    class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
                                    aria-labelledby="page-header-user-dropdown"
                                >
                                    <div
                                        class="p-3 text-center bg-body-light border-bottom rounded-top"
                                    >
                                        <!-- <img
                                            class="img-avatar img-avatar48 img-avatar-thumb"
                                            src="/assets/media/avatars/avatar10.jpg"
                                            alt="Header Avatar"
                                        /> -->
                                        <p class="mt-2 mb-0 fw-medium">
                                            {{ authUser.first_name }}
                                            {{ authUser.last_name }}
                                        </p>
                                        <p
                                            class="mb-0 text-muted fs-sm fw-medium"
                                        >
                                            Web Developer
                                        </p>
                                    </div>
                                    <div class="p-2">
                                        <form
                                            @submit.prevent="
                                                useForm().post(route('logout'))
                                            "
                                            method="POST"
                                        >
                                            <button
                                                type="submit"
                                                class="btn dropdown-item text-center"
                                            >
                                                <span class="fs-sm fw-medium"
                                                    >Log Out</span
                                                >
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- END User Dropdown -->
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
