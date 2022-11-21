<script setup lang="ts">
import { computed, onMounted, reactive, ref, watch } from "vue";
import { useMainStore } from "@/stores/main";
import { AreaData } from "@/utils/interfaces";
import { useMapStore } from "@/stores/map";
import BaseBlock from "../BaseBlock.vue";

// Main store and Route
const emits = defineEmits(["update:accuracy", "updateSmrArea", 'updateDsrArea']);
const store = useMainStore();
const mapStore = useMapStore();

// Component properties
const props = withDefaults(
    defineProps<{
        horizontal?: boolean;
        horizontalHover?: boolean;
        horizontalJustify?: boolean;
        disableClick?: boolean;
        accuracy: number | null;
    }>(),
    {
        horizontal: false,
        horizontalHo: false,
        horizontalJu: false,
        disableClick: false,
        accuracy: null,
    }
);

const dsrSections = ref([]);
const regions = ref([]);
const cities = ref([]);
const selectedAccuracy = computed({
    get() {
        return props.accuracy;
    },
    set(val) {
        emits("update:accuracy", val);
    },
});

// watch(
//     () => selectedAccuracy.value,
//     (newVal) => {
//         emits("update:accuracy", newVal);
//     }
// );

onMounted(async () => {
    const res = await fetch("/admin/regions");
    regions.value = await res.json();
    const res_dsr = await fetch("/admin/directory/dsr-sections/list");
    dsrSections.value = await res_dsr.json();
    const res_cities = await fetch(`/geojson_data/cities.geojson`);
    const citiesJson = await res_cities.json();
    cities.value = citiesJson.features
        .map((feature: any) => ({
            soato: feature.properties.soato,
            name_uz: feature.properties.name_uz,
        }))
        .sort((a, b) => a.soato > b.soato);
});

// Main menu toggling and mobile functionality
function linkClicked(e: Event, submenu: string) {
    if (submenu) {
        // Get closest li element
        let el = e.target.closest("li");

        // Check if we are in a large screen, have horizontal navigation and hover is enabled
        if (
            !(
                window.innerWidth > 991 &&
                ((props.horizontal && props.horizontalHover) ||
                    props.disableClick)
            )
        ) {
            if (el.classList.contains("open")) {
                // If submenu is open, close it..
                el.classList.remove("open");
            } else {
                // .. else if submenu is closed, close all other (same level) submenus first before open it
                Array.from(el.closest("ul").children).forEach((element) => {
                    element.classList.remove("open");
                });

                el.classList.add("open");
            }
        }
    }
}

function onDsrClickAction(area: AreaData) {
    emits("updateDsrArea", area);
}

function onSmrClickAction(area: AreaData) {
    emits("updateSmrArea", area);
}
</script>

<template>
    <BaseBlock :title="$t('Areas')" class="mb-3 pb-3" btn-option-content>
        <ul class="nav-main">
            <li class="nav-main-item open">
                <a
                    href="javascript:;"
                    class="nav-main-link nav-main-link-submenu"
                    @click.prevent="linkClicked($event, true)"
                >
                    <span class="nav-main-link-name">
                        {{ "OSR" }}
                    </span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item" v-for="accuracy in [90, 95, 98]">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                :id="'accuracy_' + accuracy"
                                :value="accuracy"
                                v-model="selectedAccuracy"
                            />
                            <label
                                class="form-check-label small"
                                :for="'accuracy_' + accuracy"
                            >
                                <span>{{ accuracy }}% aniqlik</span>
                            </label>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item">
                <a
                    href="javascript:;"
                    class="nav-main-link nav-main-link-submenu"
                    @click.prevent="linkClicked($event, true)"
                >
                    <span class="nav-main-link-name">
                        {{ "DSR" }}
                    </span>
                </a>
                <ul class="nav-main-submenu">
                    <li
                        v-for="(section, index) in dsrSections"
                        :key="`section-${index}`"
                        class="nav-main-item"
                    >
                        <!-- Submenu Link -->
                        <a
                            href="javascript:;"
                            class="nav-main-link"
                            @click.prevent="onDsrClickAction(section)"
                        >
                            <span class="nav-main-link-name">
                                {{ section.name }}
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item">
                <!-- Submenu Link -->
                <a
                    href="javascript:;"
                    class="nav-main-link nav-main-link-submenu"
                    @click.prevent="linkClicked($event, true)"
                >
                    <span class="nav-main-link-name">
                        {{ "SMR (shahar)" }}
                    </span>
                </a>
                <!-- END Submenu Link -->
                <ul class="nav-main-submenu">
                    <li
                        v-for="(city, index) in cities"
                        :key="`city-${index}`"
                        class="nav-main-item"
                    >
                        <a
                            href="javascript:;"
                            class="nav-main-link"
                            @click.prevent="onSmrClickAction(city)"
                        >
                            <span class="nav-main-link-name">
                                {{ city.name_uz }}
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item">
                <!-- Submenu Link -->
                <a
                    href="javascript:;"
                    class="nav-main-link nav-main-link-submenu"
                    @click.prevent="linkClicked($event, true)"
                >
                    <span class="nav-main-link-name">
                        {{ "SMR (tuman)" }}
                    </span>
                </a>
                <!-- END Submenu Link -->
                <ul class="nav-main-submenu">
                    <li
                        v-for="(region, index) in regions"
                        :key="`region-${index}`"
                        class="nav-main-item"
                    >
                        <!-- Submenu Link -->
                        <a
                            href="javascript:;"
                            class="nav-main-link nav-main-link-submenu"
                            @click.prevent="linkClicked($event, true)"
                        >
                            <span class="nav-main-link-name">
                                {{ region.name_uz }}
                            </span>
                        </a>
                        <!-- END Submenu Link -->

                        <ul class="nav-main-submenu">
                            <li
                                v-for="(district, index) in region.districts"
                                :key="`district-${index}`"
                                class="nav-main-item"
                            >
                                <!-- Submenu Link -->
                                <a
                                    href="javascript:;"
                                    class="nav-main-link"
                                    @click.prevent="onSmrClickAction(district)"
                                >
                                    <span class="nav-main-link-name">
                                        {{ district.name_uz }}
                                    </span>
                                </a>
                                <!-- END Submenu Link -->
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </BaseBlock>
</template>
