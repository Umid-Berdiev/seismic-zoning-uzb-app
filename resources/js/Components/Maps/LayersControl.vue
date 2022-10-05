<script setup lang="ts">
import { useMapStore } from "@/stores/map";
import BaseBlock from "../BaseBlock.vue";
import InputLabel from "../InputLabel.vue";
import Input from "../Input.vue";

interface LayerTypeData {
    id: string;
}
const mapStore = useMapStore();
// Component properties
const props = defineProps({
    nodes: {
        type: Array,
        default: () => [],
        description: "The nodes of the navigation",
    },
    subMenu: {
        type: Boolean,
        default: false,
        description: "If true, a submenu will be rendered",
    },
    dark: {
        type: Boolean,
        default: false,
        description: "Dark mode for menu",
    },
    horizontal: {
        type: Boolean,
        default: false,
        description: "Horizontal menu in large screen width",
    },
    horizontalHover: {
        type: Boolean,
        default: false,
        description: "Hover mode for horizontal menu",
    },
    horizontalCenter: {
        type: Boolean,
        default: false,
        description: "Center mode for horizontal menu",
    },
    horizontalJustify: {
        type: Boolean,
        default: false,
        description: "Justify mode for horizontal menu",
    },
    disableClick: {
        type: Boolean,
        default: false,
        description:
            "Disables submenu click on 2+ level when we are in horizontal and hover mode",
    },
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

function onClickAction(type: LayerTypeData) {
    // console.log({ area });

    // Object.assign(selectedArea, area);
    mapStore.$patch({ selectedLayerType: type });
}
</script>

<template>
    <BaseBlock :title="$t('Hududlar')" class="mb-3 pb-3" btn-option-content>
        <ul class="nav-main">
            <li class="nav-main-item mb-3 d-flex">
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
            </li>
            <li class="nav-main-item">
                <!-- Submenu Link -->
                <a
                    href="javascript:;"
                    class="nav-main-link nav-main-link-submenu"
                    @click.prevent="linkClicked($event, true)"
                >
                    <span class="nav-main-link-name">
                        {{ $t("Balls") }}
                    </span>
                </a>
                <!-- END Submenu Link -->
                <ul class="nav-main-submenu">
                    <li
                        v-for="index in 14"
                        :key="`region-${index}`"
                        class="nav-main-item"
                    >
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                value=""
                                :id="`ball_${index}`"
                                :name="`ball_${index}`"
                            />
                            <label
                                class="form-check-label small"
                                :for="`ball_${index}`"
                                >{{ index }}</label
                            >
                        </div>
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
                        {{ $t("Zones") }}
                    </span>
                </a>
                <!-- END Submenu Link -->
                <ul class="nav-main-submenu">
                    <li
                        v-for="index in 4"
                        :key="`region-${index}`"
                        class="nav-main-item"
                    >
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                value=""
                                :id="`zone_${index}`"
                                :name="`zone_${index}`"
                            />
                            <label
                                class="form-check-label small"
                                :for="`zone_${index}`"
                                >{{ index * 5 + 30 }}</label
                            >
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </BaseBlock>
</template>
