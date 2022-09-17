<script setup>
import { indexOf } from "lodash";
import { computed, ref, watch } from "vue";
import BaseBlock from "../BaseBlock.vue";

const props = defineProps({
    modelValue: "",
});
const emits = defineEmits(["update:modelValue"]);

const selectedLayer = ref("");

watch(
    () => selectedLayer.value,
    (newVal) => {
        console.log({ newVal });
        emits("update:modelValue", newVal);
    }
);

function onSelect(event) {
    const value = event.target.value;
    emits("update:modelValue", value);
}
</script>

<template>
    <BaseBlock
        id="raster_layers_control"
        class="pb-3"
        title="Raster layers"
        btn-option-content
    >
        <div class="form-check">
            <input
                class="form-check-input"
                type="radio"
                id="clearSwitch"
                v-model="selectedLayer"
                value=""
            />
            <label class="form-check-label w-100" for="clearSwitch">
                <div class="d-flex">
                    <span>Clear</span>
                </div>
            </label>
        </div>
        <div class="form-check">
            <input
                class="form-check-input"
                type="radio"
                id="soilAppraisalSwitch"
                v-model="selectedLayer"
                value="ball_range"
            />
            <label class="form-check-label w-100" for="soilAppraisalSwitch">
                <div class="d-flex">
                    <span>Soil bonitation</span>
                </div>
            </label>
        </div>
        <div class="form-check">
            <input
                class="form-check-input"
                type="radio"
                id="soilSalinitySwitch"
                v-model="selectedLayer"
                value="degree"
            />
            <label class="form-check-label w-100" for="soilSalinitySwitch">
                <div class="d-flex">
                    <span>Soil salinity</span>
                </div>
            </label>
        </div>
        <div class="form-check">
            <input
                class="form-check-input"
                type="radio"
                id="smsSwitch"
                v-model="selectedLayer"
                value="mechanical_structure"
            />
            <label class="form-check-label w-100" for="smsSwitch">
                <div class="d-flex">
                    <span>Soil mechanical structure</span>
                </div>
            </label>
        </div>
        <div class="form-check">
            <input
                class="form-check-input"
                type="radio"
                id="gumusSwitch"
                v-model="selectedLayer"
                value="humus_amount"
            />
            <label class="form-check-label w-100" for="gumusSwitch">
                <div class="d-flex">
                    <span>Humus</span>
                </div>
            </label>
        </div>
        <div class="form-check">
            <input
                class="form-check-input"
                type="radio"
                id="ssmSwitch"
                v-model="selectedLayer"
                value="mineralization"
            />
            <label class="form-check-label w-100" for="ssmSwitch">
                <div class="d-flex">
                    <span>Groundwater mineralization</span>
                </div>
            </label>
        </div>
        <div class="form-check">
            <input
                class="form-check-input"
                type="radio"
                id="sssSwitch"
                v-model="selectedLayer"
                value="level"
            />
            <label class="form-check-label w-100" for="sssSwitch">
                <div class="d-flex">
                    <span>Groundwater level</span>
                </div>
            </label>
        </div>

        <div class="form-check">
            <input
                class="form-check-input"
                type="radio"
                id="activePotassiumSwitch"
                v-model="selectedLayer"
                value="potassium"
            />
            <label class="form-check-label w-100" for="activePotassiumSwitch">
                <div class="d-flex">
                    <span>Active potassium</span>
                </div>
            </label>
        </div>
        <div class="form-check">
            <input
                class="form-check-input"
                type="radio"
                id="mobilePhosphorusSwitch"
                v-model="selectedLayer"
                value="mobile_phosphorus"
            />
            <label class="form-check-label w-100" for="mobilePhosphorusSwitch">
                <div class="d-flex">
                    <span>Mobile phosphorus</span>
                </div>
            </label>
        </div>
    </BaseBlock>
</template>

<style lang="scss" scoped>
#raster_layers_control {
    border: 2px solid lightgray;
    position: absolute;
    top: 23rem;
    left: 0.6rem;
    z-index: 800;
}
</style>
