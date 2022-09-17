<script setup>
import { computed, onMounted, reactive, ref, watch } from "vue";
import { PieChart } from "vue-chart-3";
import { Chart, registerables } from "chart.js";
import BaseBlock from "../BaseBlock.vue";

Chart.register(...registerables);

// Set Global Chart.js configuration
Chart.defaults.color = "#818d96";
Chart.defaults.font.weight = "600";
Chart.defaults.scale.grid.color = "rgba(0, 0, 0, .05)";
Chart.defaults.scale.grid.zeroLineColor = "rgba(0, 0, 0, .1)";
Chart.defaults.scale.beginAtZero = true;
Chart.defaults.elements.line.borderWidth = 2;
Chart.defaults.elements.point.radius = 4;
Chart.defaults.elements.point.hoverRadius = 6;
Chart.defaults.plugins.tooltip.radius = 3;
Chart.defaults.plugins.legend.labels.boxWidth = 15;

const props = defineProps({
    data: {
        type: Array,
        default: () => [],
    },
    labelType: "",
});
const pieChartRef = ref(null);
const chartPolarPieDonutData = computed(() => ({
    labels: props.data.map((item) => item[props.labelType]),
    datasets: [
        {
            data: props.data
                .sort((a, b) => a.value - b.value)
                .map((item) => item.area),
            backgroundColor: [
                "rgba(171, 227, 125, 1)",
                "rgba(250, 219, 125, 1)",
                "rgba(117, 176, 235, 1)",
            ],
            hoverBackgroundColor: [
                "rgba(171, 227, 125, .75)",
                "rgba(250, 219, 125, .75)",
                "rgba(117, 176, 235, .75)",
            ],
        },
    ],
}));

// watch(
//     () => props.data,
//     (newVal) => {
//         pieChartRef.value?.update();
//     }
//     // { deep: true, immediate: true }
// );

// onMounted(() => {
//     pieChartRef.value.update();
// });
</script>

<template>
    <BaseBlock id="chart_control_block" class="pb-3" title="Chart">
        <PieChart
            ref="pieChartRef"
            :chart-data="chartPolarPieDonutData"
            :width="325"
            :height="325"
        />
    </BaseBlock>
</template>

<style lang="scss" scoped>
#chart_control_block {
    border: 2px solid lightgray;
    position: absolute;
    top: 18.25rem;
    right: 0.6rem;
    z-index: 800;
}
</style>
