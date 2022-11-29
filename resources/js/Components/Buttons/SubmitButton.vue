<script setup lang="ts">
// defineProps({
//     type: {
//         type: String,
//         default: "submit",
//     },
// });

interface ButtonProps {
    type?: "submit" | "button" | "reset";
    loading?: boolean;
}

withDefaults(defineProps<ButtonProps>(), {
    type: "submit",
    loading: false,
});
</script>

<template>
    <button
        :type="type"
        class="btn btn-alt-primary border border-light rounded"
        :disabled="loading"
    >
        <span
            v-if="loading"
            class="spinner-border spinner-border-sm me-1"
            role="status"
            aria-hidden="true"
        ></span>
        <slot>
            {{ $t("Save") }}
        </slot>
    </button>
</template>
