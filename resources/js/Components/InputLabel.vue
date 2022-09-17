<script setup>
defineProps(["value"]);
</script>

<template>
    <label class="d-block fs-6 text-secondary">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
