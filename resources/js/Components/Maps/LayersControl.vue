<script setup lang="ts">
import { LayerGroupTypes } from "@/utils/interfaces";
import { computed } from "vue";
import BaseBlock from "../BaseBlock.vue";
import Input from "../Input.vue";

// Component properties
const props = withDefaults(
    defineProps<{
        layerGroup: LayerGroupTypes;
        vs30Hidden: boolean;
    }>(),
    {
        layerGroup: "balls",
        vs30Hidden: false,
    }
);

const emits = defineEmits(["update:LayerGroup"]);

const selectedLayerGroup = computed({
    get() {
        return props.layerGroup;
    },
    set(val) {
        emits("update:LayerGroup", val);
    },
});
</script>

<template>
    <BaseBlock :title="$t('Layers')" class="mb-3" btn-option-content>
        <ul class="nav-main mb-3">
            <li class="nav-main-item mb-3 px-3">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="ball_radio"
                        value="balls"
                        v-model="selectedLayerGroup"
                    />
                    <label class="form-check-label small" for="ball_radio">
                        {{ $t("Ball (MSK-64 makroseismik shkala bo'yicha)") }}
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
                    <label class="form-check-label small" for="zone_radio">
                        {{
                            $t(
                                "PGA (Grunt tebranishining cho'qqi tezlanishi qiymati)"
                            )
                        }}
                    </label>
                </div>
            </li>
            <li
                class="nav-main-item mb-3 px-3"
                :class="[vs30Hidden && 'd-none']"
            >
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="vs30_radio"
                        id="vs30_radio"
                        value="vs30"
                        v-model="selectedLayerGroup"
                    />
                    <label class="form-check-label small" for="vs30_radio">
                        VS-30
                    </label>
                </div>
            </li>
        </ul>
    </BaseBlock>
</template>
