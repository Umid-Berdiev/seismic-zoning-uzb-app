<script setup>
import { onMounted, ref, inject, watch, computed } from "vue";
import { Chart, registerables } from "chart.js";
import zoomPlugin from "chartjs-plugin-zoom";

Chart.register(zoomPlugin);
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
    data: {
        type: Object,
        required: true,
        default: () => ({}),
    },
    refKey: {
        type: String,
        default: null,
    },
});

const chartRef = ref();
const init = () => {
    const delayBetweenPoints = 5;
    const previousY = (ctx) =>
        ctx.index === 0
            ? ctx.chart.scales.y.getPixelForValue(100)
            : ctx.chart
                  .getDatasetMeta(ctx.datasetIndex)
                  .data[ctx.index - 1].getProps(["y"], true).y;
    const animation = {
        x: {
            type: "number",
            easing: "linear",
            duration: delayBetweenPoints,
            from: NaN, // the point is initially skipped
            delay(ctx) {
                if (ctx.type !== "data" || ctx.xStarted) {
                    return 0;
                }
                ctx.xStarted = true;
                return ctx.index * delayBetweenPoints;
            },
        },
        y: {
            type: "number",
            easing: "linear",
            duration: delayBetweenPoints,
            from: previousY,
            delay(ctx) {
                if (ctx.type !== "data" || ctx.yStarted) {
                    return 0;
                }
                ctx.yStarted = true;
                return ctx.index * delayBetweenPoints;
            },
        },
    };
    const canvas = chartRef.value?.getContext("2d");
    const chart = new Chart(canvas, {
        type: "line",
        data: props.data,
        options: {
            animation,
            responsive: true,
            interaction: {
                intersect: false,
            },
            // plugins: {
            //     legend: false,
            // },
            // scales: {
            //     x: {
            //         type: "linear",
            //     },
            // },
            plugins: {
                zoom: {
                    zoom: {
                        wheel: {
                            enabled: true,
                        },
                        pinch: {
                            enabled: true,
                        },
                        mode: "x",
                    },
                },
            },
        },
    });

    watch(props, () => {
        chart.data = props.data;
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

onMounted(() => {
    init();
});
</script>

<template>
    <div class="chart-container" :width="width" :height="height">
        <canvas ref="chartRef"></canvas>
    </div>
</template>
