<script setup>
import { useMainStore } from "@/stores/main";

import BaseLayout from "@/Layouts/BaseLayout.vue";

// Main store
const store = useMainStore();

// Set default elements for this layout
store.setLayout({
    header: true,
    sidebar: true,
    sideOverlay: true,
    footer: true,
});

// Set various template options for this layout variation
store.headerStyle({ mode: "light" });
store.mainContent({ mode: "narrow" });
</script>

<template>
    <BaseLayout />
</template>
