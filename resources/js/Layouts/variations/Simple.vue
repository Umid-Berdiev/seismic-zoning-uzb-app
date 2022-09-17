<script setup>
import { useMainStore } from "@/stores/main";

import BaseLayout from "@/layouts/BaseLayout.vue";

// Main store
const store = useMainStore();

// Set default elements for this layout
store.setLayout({
    header: false,
    sidebar: false,
    sideOverlay: false,
    footer: false,
});

// Set various template options for this layout variation
store.mainContent({ mode: "full" });
</script>

<template>
    <BaseLayout />
</template>
