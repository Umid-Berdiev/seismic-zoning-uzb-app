<script setup>
import { indexOf } from "lodash";
import { computed } from "vue";
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

function linkClicked(e, submenu) {
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
    } else {
        // If we are in mobile, close the sidebar
        if (window.innerWidth < 992) {
            store.sidebar({ mode: "close" });
        }
    }
}
</script>

<template>
    <BaseBlock
        :title="$t('Vector_layers')"
        class="mb-3 pb-3"
        btn-option-content
    >
        <ul class="nav-main">
            <li class="nav-main-item">
                <a
                    href="#"
                    class="nav-main-link nav-main-link-submenu"
                    @click.prevent="linkClicked($event, true)"
                >
                    <span>{{ $t("Regions") }}</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="regionsSwitch"
                                :checked="selectedLayers.includes('regions')"
                                value="regions"
                                @change="onChange"
                            />
                            <label
                                class="form-check-label w-100 small"
                                for="regionsSwitch"
                            >
                                <div class="d-flex">
                                    <span>{{ $t("Borders") }}</span>
                                </div>
                            </label>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item">
                <a
                    href="#"
                    class="nav-main-link nav-main-link-submenu"
                    @click.prevent="linkClicked($event, true)"
                >
                    <span>{{ $t("Districts") }}</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a
                            href="#"
                            class="nav-main-link nav-main-link-submenu"
                            @click.prevent="linkClicked($event, true)"
                        >
                            <span>{{ $t("Zones") }}</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="zone50Switch"
                                        :checked="
                                            selectedLayers.includes('zones_50')
                                        "
                                        value="zones_50"
                                        @change="onChange"
                                    />
                                    <label
                                        class="form-check-label w-100 small"
                                        for="zone50Switch"
                                    >
                                        <div class="d-flex">
                                            <span>50</span>
                                        </div>
                                    </label>
                                </div>
                            </li>
                            <li class="nav-main-item">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="zone45Switch"
                                        :checked="
                                            selectedLayers.includes('zones_45')
                                        "
                                        value="zones_45"
                                        @change="onChange"
                                    />
                                    <label
                                        class="form-check-label w-100 small"
                                        for="zone45Switch"
                                    >
                                        <div class="d-flex">
                                            <span>45</span>
                                        </div>
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-main-item">
                        <a
                            href="#"
                            class="nav-main-link nav-main-link-submenu"
                            @click.prevent="linkClicked($event, true)"
                        >
                            <span>{{ $t("Balls") }}</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="balls8Switch"
                                        :checked="
                                            selectedLayers.includes('balls_8')
                                        "
                                        value="balls_8"
                                        @change="onChange"
                                    />
                                    <label
                                        class="form-check-label w-100 small"
                                        for="balls8Switch"
                                    >
                                        <div class="d-flex">
                                            <span>8</span>
                                            <!-- <div
                                                class="ms-auto my-auto rectangle-balls"
                                            ></div> -->
                                        </div>
                                    </label>
                                </div>
                            </li>
                            <li class="nav-main-item">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="balls9Switch"
                                        :checked="
                                            selectedLayers.includes('balls_9')
                                        "
                                        value="balls_9"
                                        @change="onChange"
                                    />
                                    <label
                                        class="form-check-label w-100 small"
                                        for="balls9Switch"
                                    >
                                        <div class="d-flex">
                                            <span>9</span>
                                            <!-- <div
                                                class="ms-auto my-auto rectangle-balls"
                                            ></div> -->
                                        </div>
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-main-item">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="bordersSwitch"
                                :checked="selectedLayers.includes('borders')"
                                value="borders"
                                @change="onChange"
                            />
                            <label
                                class="form-check-label w-100 small"
                                for="bordersSwitch"
                            >
                                <div class="d-flex">
                                    <span>{{ $t("Borders") }}</span>
                                    <!-- <div
                                        class="ms-auto my-auto rectangle-borders"
                                    ></div> -->
                                </div>
                            </label>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
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

// .nav-main-link:hover,
// .nav-main-link:focus,
// .open {
//     background-color: rgba(0, 0, 0, 0.2);
// }
</style>
