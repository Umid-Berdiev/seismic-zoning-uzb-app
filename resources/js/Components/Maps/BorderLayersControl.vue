<script setup lang="ts">
import BaseBlock from "../BaseBlock.vue";
import TerritoryNavigation from "../Navigations/TerritoryNavigation.vue";
</script>

<template>
    <BaseBlock :title="$t('Areas')" class="mb-3 pb-3" btn-option-content>
        <TerritoryNavigation />
    </BaseBlock>
</template>
