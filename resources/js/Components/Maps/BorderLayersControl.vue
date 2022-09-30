<script setup lang="ts">
import { computed } from "vue";
import { indexOf } from "lodash";
import BaseBlock from "../BaseBlock.vue";
import TerritoryNavigation from "../Navigations/TerritoryNavigation.vue";

const props = defineProps({
    // selectedLayers: {
    //     type: Array,
    //     default: () => [],
    // },
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
        <TerritoryNavigation />
    </BaseBlock>
</template>
