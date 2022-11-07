<script setup lang="ts">
import { ref, watch } from "vue";
import { useMainStore } from "@/stores/main";

// Dark Mode preference helper for radios
const store = useMainStore();
const radioDarkMode = ref();

// Set dark mode preference radios default and watch for changes to store
setDarkModeRadioDefault();

watch(
    () => store.settings.darkModeSystem,
    () => {
        setDarkModeRadioDefault();
    }
);

watch(
    () => store.settings.darkMode,
    () => {
        setDarkModeRadioDefault();
    }
);

// Sets default dark mode preferences for radios
function setDarkModeRadioDefault() {
    if (store.settings.darkModeSystem) {
        radioDarkMode.value = "light";
    } else {
        if (store.settings.darkMode) {
            radioDarkMode.value = "dark";
        } else {
            radioDarkMode.value = "light";
        }
    }
}

// When the user sets dark mode preference through the radios
function onDarkModeRadioChange() {
    if (radioDarkMode.value === "system") {
        store.darkModeSystem({ mode: "on" });
    } else {
        store.darkModeSystem({ mode: "off" });

        if (radioDarkMode.value === "dark") {
            store.darkMode({ mode: "on" });
        } else {
            store.darkMode({ mode: "off" });
        }
    }
}
</script>

<template>
    <div class="dropdown d-inline-block ms-1">
        <button
            type="button"
            class="btn btn-sm btn-alt-secondary"
            id="sidebar-dark-mode-dropdown"
            data-bs-toggle="dropdown"
            data-bs-auto-close="outside"
            aria-haspopup="true"
            aria-expanded="false"
        >
            <i v-if="!store.settings.darkMode" class="far fa-moon"></i>
            <i v-if="store.settings.darkMode" class="fa fa-moon"></i>
        </button>
        <div
            class="dropdown-menu dropdown-menu-end dropdown-menu fs-sm smini-hide border-0"
            style="min-width: 8rem"
            aria-labelledby="sidebar-dark-mode-dropdown"
        >
            <div class="px-3 py-2 space-y-2">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="radio-dark-mode-off"
                        value="light"
                        v-model="radioDarkMode"
                        @change="onDarkModeRadioChange"
                    />
                    <label
                        class="form-check-label fw-medium"
                        for="radio-dark-mode-off"
                        >Light</label
                    >
                </div>
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="radio-dark-mode-on"
                        value="dark"
                        v-model="radioDarkMode"
                        @change="onDarkModeRadioChange"
                    />
                    <label
                        class="form-check-label fw-medium"
                        for="radio-dark-mode-on"
                        >Dark</label
                    >
                </div>
                <div class="form-check mb-0">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="radio-dark-mode-system"
                        value="system"
                        v-model="radioDarkMode"
                        @change="onDarkModeRadioChange"
                    />
                    <label
                        class="form-check-label fw-medium"
                        for="radio-dark-mode-system"
                        >System</label
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/*  */
</style>
