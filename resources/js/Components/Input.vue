<script setup>
import { onMounted, ref } from "vue";

defineProps({
    modelValue: "",
    small: {
        type: Boolean,
        default: false,
    },
});

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});
</script>

<template>
    <input
        :class="['form-control', small && 'form-control-sm']"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    />
</template>
