<script>
import LandingLayout from "@/Layouts/LandingLayout.vue";

export default {
    layout: LandingLayout,
};
</script>

<script setup>
import { computed, onMounted, reactive, ref, watch, watchEffect } from "vue";
import nprogress from "nprogress";
import { useMainStore } from "@/stores/main";
import { Inertia } from "@inertiajs/inertia";
import { Head, Link } from "@inertiajs/inertia-vue3";
import BaseBlock from "@/Components/BaseBlock.vue";
import L from "leaflet";
import "leaflet/dist/leaflet.css";
import RasterLayersControl from "@/Components/Maps/RasterLayersControl.vue";
import SoilDataTableControl from "../Components/Maps/SoilDataTableControl.vue";
import SoilDataChartControl from "@/Components/Maps/SoilDataChartControl.vue";
import VectorLayersControl from "@/Components/Maps/VectorLayersControl.vue";

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    // laravelVersion: String,
    // phpVersion: String,
    soilGumusData: {
        type: Array,
        default: () => [],
    },
    groundwaterMineralizationData: {
        type: Array,
        default: () => [],
    },
    groundwaterLevelData: {
        type: Array,
        default: () => [],
    },
    soilAppraisalData: {
        type: Array,
        default: () => [],
    },
    soilActivePotassiumData: {
        type: Array,
        default: () => [],
    },
    soilMechanicStructureData: {
        type: Array,
        default: () => [],
    },
    soilActivePhosphorusData: {
        type: Array,
        default: () => [],
    },
    soilSalinityData: {
        type: Array,
        default: () => [],
    },
});

// Main store
const store = useMainStore();
const wmsUrl = ref(
    "http://188.127.224.130/cgi-bin/mapserv?map=/home/mapserver_data/agropointers.map&raster_name="
);
const wmsOptions = reactive({
    layers: `three_level_interpolation`,
    format: "image/png",
    transparent: true,
    crs: L.CRS.EPSG4326,
    zIndex: 4,
});
const zoom = ref(12.5);
const center = ref([40.677694, 68.049889]);
const map = ref(null);
const tileProviders = reactive({
    ["Openstreet harita"]: L.tileLayer(
        "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
    ),
    ["Google harita"]: L.tileLayer(
        "http://www.google.com/maps/vt?ROADMAP=s@189&gl=uz&x={x}&y={y}&z={z}"
    ),
    ["Google harita (sun'iy yo'ldosh)"]: L.tileLayer(
        "http://www.google.com/maps/vt?lyrs=s,h@189&gl=uz&x={x}&y={y}&z={z}"
    ),
});
const selectedRasterLayer = ref("");
const selectedRasterData = ref([]);
const selectedLayers = ref([
    "kuzatuvQuduqlari",
    "kollektorlar",
    "sugorishTarmoqlari",
    "boshqaYerlar",
    "aholi",
    "chegaralar",
    "yollar",
]);
const aholi = ref(null);
const boshqaYerlar = ref(null);
const chegaralar = ref(null);
const kollektorlar = ref(null);
const kuzatuvQuduqlari = ref(null);
const sugorishTarmoqlari = ref(null);
const yollar = ref(null);

// layers
const chegaralarLayer = computed(() =>
    L.geoJSON(chegaralar.value, {
        style: function (geoJsonFeature) {
            return {
                stroke: true,
                fill: false,
                color: "purple",
                fillColor: "purple",
                fillOpacity: 1,
            };
        },
    }).bindPopup("Paxtazor district")
);
const aholiLayer = computed(() =>
    L.geoJSON(aholi.value, {
        style: function (geoJsonFeature) {
            return {
                stroke: true,
                fill: true,
                color: "#beb297",
                fillColor: "#beb297",
                fillOpacity: 1,
            };
        },
    })
);
const boshqaYerlarLayer = computed(() =>
    L.geoJSON(boshqaYerlar.value, {
        style: (geoJsonFeature) => ({
            stroke: true,
            fill: true,
            color: "#c43c39",
            fillColor: "#c43c39",
            fillOpacity: 1,
        }),
    })
);
const yollarLayer = computed(() =>
    L.geoJSON(yollar.value, {
        style: function (geoJsonFeature) {
            return {
                stroke: true,
                fill: false,
                color: "white",
                fillColor: "white",
            };
        },
    })
);
const kollektorlarLayer = computed(() =>
    L.geoJSON(kollektorlar.value, {
        style: (geoJsonFeature) => ({
            stroke: true,
            fill: false,
            color: "#65a30d",
            fillColor: "#65a30d",
            fillOpacity: 1,
        }),
    })
);
const kuzatuvQuduqlariLayer = computed(() =>
    L.geoJSON(kuzatuvQuduqlari.value, {
        onEachFeature: function (feature, layer) {
            layer.setIcon(
                L.divIcon({
                    html: `<i class="fa fa-circle"></i>`,
                    className: "text-secondary",
                })
            );
        },
    })
);
const sugorishTarmoqlariLayer = computed(() =>
    L.geoJSON(sugorishTarmoqlari.value)
);

// define raster layers
const rasterLayer = ref({});

onMounted(async () => {
    // fetch geojson data
    await fetchStaticLayers();

    // init map
    initMap();
});

watchEffect(() => {
    map.value?.removeLayer(aholiLayer.value);
    map.value?.removeLayer(chegaralarLayer.value);
    map.value?.removeLayer(boshqaYerlarLayer.value);
    map.value?.removeLayer(yollarLayer.value);
    map.value?.removeLayer(sugorishTarmoqlariLayer.value);
    map.value?.removeLayer(kollektorlarLayer.value);
    map.value?.removeLayer(kuzatuvQuduqlariLayer.value);

    if (selectedLayers.value.includes("yollar"))
        map.value?.addLayer(yollarLayer.value);

    if (selectedLayers.value.includes("aholi"))
        map.value?.addLayer(aholiLayer.value);

    if (selectedLayers.value.includes("chegaralar"))
        map.value?.addLayer(chegaralarLayer.value);

    if (selectedLayers.value.includes("boshqaYerlar"))
        map.value?.addLayer(boshqaYerlarLayer.value);

    if (selectedLayers.value.includes("sugorishTarmoqlari"))
        map.value?.addLayer(sugorishTarmoqlariLayer.value);

    if (selectedLayers.value.includes("kollektorlar"))
        map.value?.addLayer(kollektorlarLayer.value);

    if (selectedLayers.value.includes("kuzatuvQuduqlari"))
        map.value?.addLayer(kuzatuvQuduqlariLayer.value);
});

watch(
    () => selectedRasterLayer.value,
    () => {
        nprogress.start();
        map.value.removeLayer(rasterLayer.value);
        if (selectedRasterLayer.value == "humus_amount")
            getGumusInterpolation();
        if (selectedRasterLayer.value == "mineralization")
            getGroundwaterMineralizationInterpolation();
        if (selectedRasterLayer.value == "level")
            getGroundwaterLevelInterpolation();
        if (selectedRasterLayer.value == "ball_range")
            getSoilAppraisalInterpolation();
        if (selectedRasterLayer.value == "potassium")
            getSoilActivePotassiumInterpolation();
        if (selectedRasterLayer.value == "mechanical_structure")
            getSoilMechanicStructureInterpolation();
        if (selectedRasterLayer.value == "mobile_phosphorus")
            getSoilActivePhosphorusInterpolation();
        if (selectedRasterLayer.value == "degree")
            getSoilSalinityInterpolation();
        nprogress.done();
    },
    { deep: true }
);

async function fetchStaticLayers() {
    const res_aholi = await fetch("/geojson_data/aholi.geojson");
    const res_boshqa_yerlar = await fetch(
        "/geojson_data/boshqa_yerlar.geojson"
    );
    const res_chegaralar = await fetch("/geojson_data/chegaralar.geojson");
    const res_kollektorlar = await fetch("/geojson_data/kollektorlar.geojson");
    const res_kuzatuv_quduqlari = await fetch(
        "/geojson_data/kuzatuv_quduqlari.geojson"
    );
    const res_yollar = await fetch("/geojson_data/yo'llar.geojson");
    const res_sugorish_tarmoqlari = await fetch(
        "/geojson_data/sug'orish_tarmoqlari.geojson"
    );

    aholi.value = await res_aholi.json();
    boshqaYerlar.value = await res_boshqa_yerlar.json();
    chegaralar.value = await res_chegaralar.json();
    kollektorlar.value = await res_kollektorlar.json();
    kuzatuvQuduqlari.value = await res_kuzatuv_quduqlari.json();
    sugorishTarmoqlari.value = await res_sugorish_tarmoqlari.json();
    yollar.value = await res_yollar.json();
}

function initMap() {
    map.value = L.map("map", {
        zoom: zoom.value,
        center: center.value,
        // zoomDelta: 0.5,
    })
        .on("zoomend", function (e) {
            zoom.value = map.value.getZoom();
        })
        .on("moveend", function (e) {
            center.value = Object.values(map.value.getBounds().getCenter());
        });
    tileProviders["Openstreet harita"].addTo(map.value);

    // add layers to map
    L.control
        .layers(
            tileProviders,
            {
                //
            },
            {
                position: "topright",
            }
        )
        .addTo(map.value);
    L.control
        .scale({
            imperial: false,
        })
        .setPosition("bottomleft")
        .addTo(map.value);

    map.value.attributionControl.setPrefix(""); // Don't show the 'Powered by Leaflet' text.
}

function getGumusInterpolation() {
    const rasterName = `/home/mapserver_data/data/gumus.tif`;

    rasterLayer.value = L.tileLayer.wms(
        `${wmsUrl.value}${rasterName}`,
        wmsOptions
    );

    rasterLayer.value.addTo(map.value);
    selectedRasterData.value = props.soilGumusData;
}

function getSoilAppraisalInterpolation() {
    const rasterName = `/home/mapserver_data/data/soil_appraisal.tif`;

    // console.log(`${wmsUrl.value}${rasterName}`);
    rasterLayer.value = L.tileLayer.wms(
        `${wmsUrl.value}${rasterName}`,
        wmsOptions
    );

    rasterLayer.value.addTo(map.value);
    selectedRasterData.value = props.soilAppraisalData;
}

function getGroundwaterLevelInterpolation() {
    const rasterName = `/home/mapserver_data/data/SSS.tif`;
    const wmsOptions = {
        layers: `two_level_interpolation`,
        format: "image/png",
        transparent: true,
        crs: L.CRS.EPSG4326,
        zIndex: 4,
    };

    rasterLayer.value = L.tileLayer.wms(
        `${wmsUrl.value}${rasterName}`,
        wmsOptions
    );

    rasterLayer.value.addTo(map.value);
    selectedRasterData.value = props.groundwaterLevelData;
}

function getGroundwaterMineralizationInterpolation() {
    const rasterName = `/home/mapserver_data/data/SSM.tif`;

    // console.log(`${wmsUrl.value}${rasterName}`);
    rasterLayer.value = L.tileLayer.wms(
        `${wmsUrl.value}${rasterName}`,
        wmsOptions
    );

    rasterLayer.value.addTo(map.value);
    selectedRasterData.value = props.groundwaterMineralizationData;
}

function getSoilMechanicStructureInterpolation() {
    const rasterName = `/home/mapserver_data/data/Tuproq_mexanik_tarkibi.tif`;

    // console.log(`${wmsUrl.value}${rasterName}`);
    rasterLayer.value = L.tileLayer.wms(
        `${wmsUrl.value}${rasterName}`,
        wmsOptions
    );

    rasterLayer.value.addTo(map.value);
    selectedRasterData.value = props.soilMechanicStructureData;
}

function getSoilSalinityInterpolation() {
    const rasterName = `/home/mapserver_data/data/tuproq_shurlanishi.tif`;

    // console.log(`${wmsUrl.value}${rasterName}`);
    rasterLayer.value = L.tileLayer.wms(
        `${wmsUrl.value}${rasterName}`,
        wmsOptions
    );

    rasterLayer.value.addTo(map.value);
    selectedRasterData.value = props.soilSalinityData;
}

function getSoilActivePhosphorusInterpolation() {
    const rasterName = `/home/mapserver_data/data/xarakatchan_fosfor.tif`;

    // console.log(`${wmsUrl.value}${rasterName}`);
    rasterLayer.value = L.tileLayer.wms(
        `${wmsUrl.value}${rasterName}`,
        wmsOptions
    );

    rasterLayer.value.addTo(map.value);
    selectedRasterData.value = props.soilActivePhosphorusData;
}

function getSoilActivePotassiumInterpolation() {
    const rasterName = `/home/mapserver_data/data/xarakatchan_kaliy.tif`;

    // console.log(`${wmsUrl.value}${rasterName}`);
    rasterLayer.value = L.tileLayer.wms(
        `${wmsUrl.value}${rasterName}`,
        wmsOptions
    );

    rasterLayer.value.addTo(map.value);
    selectedRasterData.value = props.soilActivePotassiumData;
}
</script>

<template>
    <div class="position-relative">
        <div id="map" style="height: 85vh"></div>
        <VectorLayersControl v-model:selected-layers="selectedLayers" />
        <RasterLayersControl v-model="selectedRasterLayer" />
        <template v-if="selectedRasterData.length && selectedRasterLayer">
            <SoilDataTableControl
                :data="selectedRasterData"
                :label-type="selectedRasterLayer"
            />
            <SoilDataChartControl
                :data="selectedRasterData"
                :label-type="selectedRasterLayer"
            />
        </template>
        <p>Center is at {{ center }} and the zoom is: {{ zoom }}</p>
    </div>
</template>
