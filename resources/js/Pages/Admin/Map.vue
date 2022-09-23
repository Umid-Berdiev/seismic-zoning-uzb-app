<script setup>
import { computed, onMounted, reactive, ref, watch, watchEffect } from "vue";
import { useMainStore } from "@/stores/main";
import L from "leaflet";
import "leaflet/dist/leaflet.css";
import VectorLayersControl from "@/Components/Maps/VectorLayersControl.vue";
import Loader from "@/Components/Loader.vue";

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    borders: Array,
    balls: Array,
});

// Main store
const store = useMainStore();
const zoom = ref(6);
const mapLoader = ref(false);
const center = ref([40.4111, 66.9]);
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
const selectedLayers = ref(["regions"]);
const geojsonRegions = ref(null);

// layers
const layerRegions = computed(() =>
    L.geoJSON(geojsonRegions.value, {
        style: function (geoJsonFeature) {
            return {
                stroke: true,
                fill: true,
                color: "#beb297",
                fillColor: "#beb297",
                fillOpacity: 0,
                weight: 1,
            };
        },
        onEachFeature: function (feature, layer) {
            layer
                .on("click", async function () {
                    mapLoader.value = true;
                    const bounds = await this.getBounds();
                    const activeBounds = L.latLngBounds(bounds);
                    await map.value.flyToBounds(activeBounds);
                    mapLoader.value = false;
                })
                .on("mouseover", function (e) {
                    this.setStyle({
                        color: "#0eb297",
                        weight: 2,
                    });
                })
                .on("mouseout", function (e) {
                    this.setStyle({
                        color: "#beb297",
                        weight: 1,
                    });
                });
        },
    })
);
// const layerBorders = computed(() =>
//     L.polyline([props.borders], {
//         color: "#FF0000",
//     })
// );

onMounted(async () => {
    // fetch geojson data
    mapLoader.value = true;
    await fetchStaticLayers();

    // init map
    initMap();
    mapLoader.value = false;
});

watchEffect(() => {
    // map.value?.removeLayer(layerRegions.value);
    // map.value?.removeLayer(layerBorders.value);
    // props.balls.forEach((ball) => {
    //     map.value?.removeLayer([`layerBalls${ball.level}`]);
    // });

    // console.log("map panes: ", map.value?.getPane("overlayPane"));

    map.value?.ea;

    if (selectedLayers.value.includes("regions"))
        map.value?.addLayer(layerRegions.value);
    if (selectedLayers.value.includes("borders")) {
        // map.value?.addLayer(layerBorders.value);
        // map.value?.fitBounds(layerBorders.value?.getBounds());

        props.borders.forEach((border) => {
            L.polyline(
                border.line.map((item) => item.coordinates),
                {
                    color: "#FF0000",
                }
            ).addTo(map.value);
        });
    }
    if (selectedLayers.value.includes("balls")) {
        // const obj = {};
        props.balls.forEach((ball) => {
            // console.log({ ball });
            L.polygon(ball.polygon.coordinates, {
                // color: "#00ff00",
            }).addTo(map.value);
        });

        // console.log({ obj });

        // for (const iterator in obj) {
        //     map.value?.addLayer(obj[iterator]);
        // }
    }
});

async function fetchStaticLayers() {
    const geojson_regions = await fetch(
        "/geojson_data/uzbekistan_regions.geojson"
    );
    geojsonRegions.value = await geojson_regions.json();
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
</script>

<template>
    <div id="map-container" class="position-relative">
        <Loader v-if="mapLoader" />
        <div id="map" style="height: 80vh"></div>
        <div id="left_control_block">
            <VectorLayersControl v-model:selected-layers="selectedLayers" />
            <!-- <RasterLayersControl v-model="selectedRasterLayer" /> -->
        </div>
        <!-- <div
            id="right_control_block"
            v-if="selectedRasterData.length && selectedRasterLayer"
        >
            <SoilDataTableControl
                :data="selectedRasterData"
                :label-type="selectedRasterLayer"
            />
            <SoilDataChartControl
                :data="selectedRasterData"
                :label-type="selectedRasterLayer"
            />
        </div> -->
        <p>Center is at {{ center }} and the zoom is: {{ zoom }}</p>
    </div>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    layout: AdminLayout,
};
</script>

<style lang="scss" scoped>
#left_control_block {
    // border: 2px solid lightgray;
    position: absolute;
    top: 5.25rem;
    left: 1rem;
    z-index: 800;
}
#right_control_block {
    // border: 2px solid lightgray;
    position: absolute;
    top: 4.25rem;
    right: 1rem;
    z-index: 800;
    width: 370px;
}
</style>
