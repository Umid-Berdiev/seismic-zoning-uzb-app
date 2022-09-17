<script setup>
import { computed } from "vue";
import { useMainStore } from "@/stores/main";
import MainChart from "../MainChart.vue";

const props = defineProps({
    width: {
        type: Number,
        default: 0,
    },
    height: {
        type: Number,
        default: 0,
    },
});

const store = useMainStore();
const darkMode = computed(() => store.settings.darkMode);
const data = computed(() => {
    return {
        labels: ["Yellow", "Dark"],
        datasets: [
            {
                data: [15, 10, 65],
                backgroundColor: ["#FF8B26", "#FFC533", "#285FD3"],
                hoverBackgroundColor: ["#FF8B26", "#FFC533", "#285FD3"],
                borderWidth: 5,
                borderColor: darkMode.value ? "#303953" : "#fff",
            },
        ],
    };
});
const options = computed(() => {
    return {
        legend: {
            display: false,
        },
    };
});
</script>

<template>
    <MainChart
        type="pie"
        :width="width"
        :height="height"
        :data="data"
        :options="options"
    />
</template>
