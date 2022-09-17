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
    <BaseBlock
        id="vector_layers_control"
        class="pb-3"
        title="Vector layers"
        btn-option-content
    >
        <div class="form-check">
            <input
                class="form-check-input"
                type="checkbox"
                id="kuzatuvQuduqlariSwitch"
                :checked="selectedLayers.includes('kuzatuvQuduqlari')"
                value="kuzatuvQuduqlari"
                @change="onChange"
            />
            <label class="form-check-label w-100" for="kuzatuvQuduqlariSwitch">
                <div class="d-flex">
                    <span>Observation wells</span>
                    <i class="fa fa-circle text-secondary ms-auto my-auto"></i>
                </div>
            </label>
        </div>
        <div class="form-check">
            <input
                class="form-check-input"
                type="checkbox"
                id="kollektorlarSwitch"
                :checked="selectedLayers.includes('kollektorlar')"
                value="kollektorlar"
                @change="onChange"
            />
            <label class="form-check-label w-100" for="kollektorlarSwitch">
                <div class="d-flex">
                    <span>Collectors</span>
                    <div
                        class="border border-success ms-auto my-auto horizontal-line"
                    ></div>
                </div>
            </label>
        </div>
        <div class="form-check">
            <input
                class="form-check-input"
                type="checkbox"
                id="sugorishTarmoqlariSwitch"
                :checked="selectedLayers.includes('sugorishTarmoqlari')"
                value="sugorishTarmoqlari"
                @change="onChange"
            />
            <label
                class="form-check-label w-100"
                for="sugorishTarmoqlariSwitch"
            >
                <div class="d-flex">
                    <span class="me-3">Irrigation networks</span>
                    <div
                        class="border border-primary ms-auto my-auto horizontal-line"
                    ></div>
                </div>
            </label>
        </div>
        <div class="form-check">
            <input
                class="form-check-input"
                type="checkbox"
                id="boshqaYerlarSwitch"
                :checked="selectedLayers.includes('boshqaYerlar')"
                value="boshqaYerlar"
                @change="onChange"
            />
            <label class="form-check-label w-100" for="boshqaYerlarSwitch">
                <div class="d-flex">
                    <span>Other fields</span>
                    <div class="ms-auto my-auto rectangle-boshqayerlar"></div>
                </div>
            </label>
        </div>
        <div class="form-check">
            <input
                class="form-check-input"
                type="checkbox"
                id="aholiSwitch"
                :checked="selectedLayers.includes('aholi')"
                value="aholi"
                @change="onChange"
            />
            <label class="form-check-label w-100" for="aholiSwitch">
                <div class="d-flex">
                    <span>Populated areas</span>
                    <div class="ms-auto my-auto rectangle-aholi"></div>
                </div>
            </label>
        </div>
        <div class="form-check">
            <input
                class="form-check-input"
                type="checkbox"
                id="chegaralarSwitch"
                :checked="selectedLayers.includes('chegaralar')"
                value="chegaralar"
                @change="onChange"
            />
            <label class="form-check-label w-100" for="chegaralarSwitch">
                <div class="d-flex">
                    <span>Borders</span>
                    <div class="ms-auto my-auto rectangle-chegaralar"></div>
                </div>
            </label>
        </div>
        <div class="form-check">
            <input
                class="form-check-input"
                type="checkbox"
                id="yollarSwitch"
                :checked="selectedLayers.includes('yollar')"
                value="yollar"
                @change="onChange"
            />
            <label class="form-check-label w-100" for="yollarSwitch">
                <div class="d-flex">
                    <span>Roads</span>
                    <div
                        class="border border-secondary bg-white ms-auto my-auto horizontal-yollar"
                    ></div>
                </div>
            </label>
        </div>
    </BaseBlock>
</template>

<style lang="scss" scoped>
#vector_layers_control {
    border: 2px solid lightgray;
    position: absolute;
    top: 5.25rem;
    left: 0.6rem;
    z-index: 800;
    // width: 370px;
}

.rectangle-chegaralar {
    width: 1.5rem;
    height: 1rem;
    background-color: purple;
}

.rectangle-aholi {
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
