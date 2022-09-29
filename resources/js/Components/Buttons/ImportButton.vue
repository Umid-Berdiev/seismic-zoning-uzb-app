<script setup lang="ts">
const props = defineProps({
    modalId: String,
});
</script>

<template>
    <button
        type="button"
        class="btn btn-alt-primary push"
        data-bs-toggle="modal"
        :data-bs-target="`#${modalId}`"
    >
        <i class="fa fa-fw fa-download me-1"></i>
        <span>{{ $t("Import_shapefile") }}</span>
    </button>
</template>

<style scoped></style>
