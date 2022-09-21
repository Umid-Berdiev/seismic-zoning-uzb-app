<script setup>
defineProps(["message"]);
</script>

<template>
    <div v-show="message">
        <small class="text-danger animated fadeIn">
            {{ message }}
        </small>
    </div>
</template>
