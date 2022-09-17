<script setup>
import { onMounted, ref, inject, watch } from "vue";
import { Chart, registerables } from "chart.js";

Chart.register(...registerables);
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
    type: {
        type: String,
        required: true,
        default: "line",
        validator: (value) => {
            return ["line", "pie", "doughnut", "bar"].indexOf(value) !== -1;
        },
    },
    data: {
        type: Object,
        required: true,
        default: () => ({}),
    },
    options: {
        type: Object,
        default: () => ({}),
    },
    width: {
        type: Number,
        default: 300,
    },
    height: {
        type: Number,
        default: 300,
    },
    refKey: {
        type: String,
        default: null,
    },
});

const chartRef = ref();
const init = () => {
    const canvas = chartRef.value?.getContext("2d");
    const chart = new Chart(canvas, {
        type: props.type,
        data: props.data,
        options: props.options,
    });

    watch(props, () => {
        chart.data = props.data;
        chart.options = props.options;
        chart.update();
    });

    // Attach ChartJs instance
    chartRef.value.instance = chart;
};

const setSize = () => {
    if (props.width) {
        cash(chartRef.value).attr({
            width: props.width,
        });
    }

    if (props.height) {
        cash(chartRef.value).attr({
            height: props.height,
        });
    }
};

const bindInstance = () => {
    if (props.refKey) {
        const bind = inject(`bind[${props.refKey}]`);
        if (bind) {
            bind(chartRef.value);
        }
    }
};

onMounted(() => {
    bindInstance();
    // setSize();
    init();
});
</script>

<template>
    <div class="chart-container" :width="width" :height="height">
        <canvas ref="chartRef"></canvas>
    </div>
</template>
