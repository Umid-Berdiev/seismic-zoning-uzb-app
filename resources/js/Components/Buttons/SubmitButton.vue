<script setup lang="ts">
// defineProps({
//     type: {
//         type: String,
//         default: "submit",
//     },
// });

interface ButtonProps {
    type?: string;
}

withDefaults(defineProps<ButtonProps>(), {
    type: "submit",
});
</script>

<template>
    <button
        :type="type"
        class="btn btn-alt-primary border border-light rounded"
    >
        <slot>
            {{ $t("Save") }}
        </slot>
    </button>
</template>
