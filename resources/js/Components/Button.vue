<script setup>
defineProps({
    type: {
        type: String,
        default: "submit",
    },
});
</script>

<template>
    <button
        :type="type"
        class="form-control bg-secondary border border-light rounded text-white"
    >
        <slot />
    </button>
</template>
