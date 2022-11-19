<script setup lang="ts">
import { ref, watch } from "vue";
import BaseBlock from "../BaseBlock.vue";
import Input from "../Input.vue";

// Component properties
// const props = defineProps({
//     //
// });

const emits = defineEmits(["updateLayerGroup"]);

const selectedLayerGroup = ref(null);

watch(
    () => selectedLayerGroup.value,
    (newVal) => {
        emits("updateLayerGroup", newVal);
    }
    // { immediate: true }
);
</script>

<template>
    <BaseBlock :title="$t('Layers')" class="mb-3 pb-3" btn-option-content>
        <ul class="nav-main">
            <!-- <li class="nav-main-item mb-3 d-flex">
                <label class="form-check-label ms-3 ps-1" for="border_checkbox">
                    <span class="small fw-semibold">{{ $t("Borders") }}</span>
                </label>
                <div class="form-check ms-auto">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        value=""
                        id="border_checkbox"
                        name="border_checkbox"
                    />
                </div>
            </li> -->
            <li class="nav-main-item mb-3 px-3">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="ball_radio"
                        id="ball_radio"
                        value="balls"
                        v-model="selectedLayerGroup"
                    />
                    <label class="form-check-label" for="ball_radio">
                        {{ $t("Balls") }}
                    </label>
                </div>
            </li>
            <li class="nav-main-item mb-3 px-3">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="zone_radio"
                        id="zone_radio"
                        value="zones"
                        v-model="selectedLayerGroup"
                    />
                    <label class="form-check-label" for="zone_radio">
                        {{ $t("Zones") }}
                    </label>
                </div>
            </li>
        </ul>
    </BaseBlock>
</template>
