<script setup>
//
</script>

<template>
    <div class="loader">
        <div
            class="spinner-grow"
            style="width: 3rem; height: 3rem"
            role="status"
        >
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</template>

<style scoped>
.loader {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(0, 0, 0, 0.3);
    position: absolute;
    z-index: 1001;
}
</style>
