<script setup>
import { indexOf } from "lodash";
import BaseBlock from "../BaseBlock.vue";

const props = defineProps({
    selectedLayers: {
        type: Array,
        default: () => [],
    },
});
const emits = defineEmits(["update:selectedLayers"]);

function onChange(event) {
    const value = event.target.value;
    let tempArr = props.selectedLayers;
    const idx = indexOf(tempArr, value);

    if (idx !== -1) {
        tempArr.splice(idx, 1);
    } else tempArr.push(value);
    // if (tempArr.includes(value)) {
    //     tempArr = tempArr.filter((item) => item !== value);
    // } else tempArr.push(value);

    emits("update:selectedLayers", tempArr);
}
</script>

<template>
    <BaseBlock title="Vector layers" class="mb-3 pb-3" btn-option-content>
        <div class="form-check">
            <input
                class="form-check-input"
                type="checkbox"
                id="regionsSwitch"
                :checked="selectedLayers.includes('regions')"
                value="regions"
                @change="onChange"
            />
            <label class="form-check-label w-100" for="regionsSwitch">
                <div class="d-flex">
                    <span>Regions</span>
                    <div class="ms-auto my-auto rectangle-regions"></div>
                </div>
            </label>
        </div>
        <div class="form-check">
            <input
                class="form-check-input"
                type="checkbox"
                id="bordersSwitch"
                :checked="selectedLayers.includes('borders')"
                value="borders"
                @change="onChange"
            />
            <label class="form-check-label w-100" for="bordersSwitch">
                <div class="d-flex">
                    <span>Borders</span>
                    <div class="ms-auto my-auto rectangle-borders"></div>
                </div>
            </label>
        </div>
        <div class="form-check">
            <input
                class="form-check-input"
                type="checkbox"
                id="ballsSwitch"
                :checked="selectedLayers.includes('balls')"
                value="balls"
                @change="onChange"
            />
            <label class="form-check-label w-100" for="ballsSwitch">
                <div class="d-flex">
                    <span>Balls</span>
                    <div class="ms-auto my-auto rectangle-balls"></div>
                </div>
            </label>
        </div>
    </BaseBlock>
</template>

<style lang="scss" scoped>
.rectangle-chegaralar {
    width: 1.5rem;
    height: 1rem;
    background-color: purple;
}

.rectangle-regions {
    width: 1.5rem;
    height: 1rem;
    background-color: #beb297;
}

.rectangle-boshqayerlar {
    width: 1.5rem;
    height: 1rem;
    background-color: #c43c39;
}

.horizontal-line {
    width: 2rem;
    height: 0.1rem;
}

.horizontal-yollar {
    width: 2rem;
    height: 0.25rem;
}
</style>
