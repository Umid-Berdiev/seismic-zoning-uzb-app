<script setup>
import { computed, onMounted, reactive, ref, watch, watchEffect, h } from "vue";
import { useI18n } from "vue-i18n";
import { useMainStore } from "@/stores/main";
import L, { CRS } from "leaflet";
import "leaflet/dist/leaflet.css";
import { useMapStore } from "@/stores/map";
import { useNotyf } from "@/composable/useNotyf";
import Loader from "@/Components/Loader.vue";
import BorderLayersControl from "@/Components/Maps/BorderLayersControl.vue";
import LayersControl from "@/Components/Maps/LayersControl.vue";
import { InertiaProgress } from "@inertiajs/progress";

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    borders: Array,
    balls: Object,
    zones: Array,
});
const { t } = useI18n();
const notyf = useNotyf();
const store = useMainStore();
const mapStore = useMapStore();
const zoom = ref(6);
const mapLoader = ref(false);
const initialCenter = ref([40.4111, 66.9]);
const center = ref(initialCenter.value);
const map = ref(null);
const tileProviders = reactive({
    [t("Openstreet_map")]: L.tileLayer(
        "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
    ),
    [t("Google_map")]: L.tileLayer(
        "http://www.google.com/maps/vt?ROADMAP=s@189&gl=uz&x={x}&y={y}&z={z}"
    ),
    [t("Google_map_satellite")]: L.tileLayer(
        "http://www.google.com/maps/vt?lyrs=s,h@189&gl=uz&x={x}&y={y}&z={z}"
    ),
});
const selectedLayers = reactive({
    balls: {},
    borders: {},
    zones: {},
});
const geojsonRegions = ref(null);
const regionsGeojson = reactive({
    type: "FeatureCollection",
    name: "regions",
    crs: {
        type: "name",
        properties: { name: "urn:ogc:def:crs:OGC:1.3:CRS84" },
    },
    features: [],
});
const districtsGeojson = reactive({
    type: "FeatureCollection",
    name: "districts",
    crs: {
        type: "name",
        properties: { name: "urn:ogc:def:crs:OGC:1.3:CRS84" },
    },
    features: [],
});
const citiesGeojson = reactive({
    type: "FeatureCollection",
    name: "cities",
    crs: {
        type: "name",
        properties: { name: "urn:ogc:def:crs:OGC:1.3:CRS84" },
    },
    features: [],
});

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
const selectedSoatos = ref([]);

onMounted(async () => {
    // fetch geojson data
    mapLoader.value = true;
    await fetchStaticLayers();

    // init map
    initMap();
    mapLoader.value = false;
});

watch(
    () => mapStore.selectedArea,
    async (newValue, oldValue) => {
        mapLoader.value = true;

        if (newValue) {
            selectedSoatos.value = [];
            map.value?.eachLayer((layer) => {
                if (layer._path != undefined) layer.removeFrom(map.value);
            });

            if (newValue.soato === "main") {
                initializeDefaultLayersToMap();
                await map.value.flyTo(L.latLng(initialCenter.value), 6);
            } else if (Number(newValue.soato)) {
                const foundArea =
                    String(newValue.soato).length > 4
                        ? districtsGeojson.features?.find(
                              (feature) =>
                                  feature.properties.soato ===
                                  Number(newValue.soato)
                          )
                        : citiesGeojson.features?.find(
                              (feature) =>
                                  feature.properties.soato ===
                                  Number(newValue.soato)
                          );

                if (foundArea) {
                    selectedSoatos.value = [Number(newValue.soato)];
                    const districtPolygon = L.geoJSON(foundArea, {
                        onEachFeature: function (feature, layer) {
                            layer
                                .on("click", async function () {
                                    //
                                })
                                .on("mouseover", function () {
                                    this.setStyle({
                                        weight: 2,
                                    });
                                })
                                .on("mouseout", function () {
                                    this.setStyle({
                                        weight: 1,
                                    });
                                })
                                .bindPopup(
                                    `
                                    <ul class="list-group mt-4">
                                        <li class="list-group-item d-flex align-items-start">
                                            <span class="fw-bold">
                                                Nomi
                                            </span>
                                            <span class="ms-auto">
                                                ${feature.properties?.name_uz}
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-start">
                                            <span class="fw-bold">
                                                SOATO kodi
                                            </span>
                                            <span class="ms-auto">
                                                ${feature.properties?.soato}
                                            </span>
                                        </li>
                                    </ul>
                                    `,
                                    {
                                        minWidth: 300,
                                    }
                                );
                        },
                        style: function (feature) {
                            return {
                                color: "#0eb297",
                                weight: 1,
                                // fillOpacity: 0.0,
                            };
                        },
                    }).addTo(map.value);
                    const areaBounds = L.latLngBounds(
                        districtPolygon.getBounds()
                    );
                    map.value.flyTo(areaBounds.getCenter(), 10);
                } else {
                    notyf.error("Area not found!");
                }
            } else if (newValue.regions?.length) {
                const soatoArr = newValue.regions.map((region) =>
                    Number(region.soato)
                );
                const foundAreas = regionsGeojson.features?.filter((feature) =>
                    soatoArr.includes(feature.properties.soato)
                );

                if (foundAreas.length) {
                    selectedSoatos.value = soatoArr;
                    const dsrSectionPolygon = L.geoJSON(foundAreas, {
                        onEachFeature: function (feature, layer) {
                            layer
                                .on("click", async function () {
                                    //
                                })
                                .on("mouseover", function () {
                                    this.setStyle({
                                        weight: 2,
                                    });
                                })
                                .on("mouseout", function () {
                                    this.setStyle({
                                        weight: 1,
                                    });
                                })
                                .bindPopup(
                                    `
                                    <ul class="list-group mt-4">
                                        <li class="list-group-item d-flex align-items-start">
                                            <span class="fw-bold">
                                                Nomi
                                            </span>
                                            <span class="ms-auto">
                                                ${feature.properties?.name_uz}
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-start">
                                            <span class="fw-bold">
                                                SOATO kodi
                                            </span>
                                            <span class="ms-auto">
                                                ${feature.properties?.soato}
                                            </span>
                                        </li>
                                    </ul>
                                    `,
                                    {
                                        minWidth: 300,
                                    }
                                );
                        },
                        style: function (feature) {
                            return {
                                color: "#0eb297",
                                weight: 1,
                                // fillOpacity: 0.0,
                            };
                        },
                    }).addTo(map.value);
                    const areaBounds = L.latLngBounds(
                        dsrSectionPolygon.getBounds()
                    );
                    map.value.flyTo(areaBounds.getCenter(), 7);
                } else {
                    notyf.error("Area not found!");
                }
            }
        }
        await fetchLayerDataBySelectedArea();
        mapLoader.value = false;
    },
    {
        deep: true,
    }
);

async function fetchStaticLayers() {
    const geojson_regions = await fetch(
        "/geojson_data/uzbekistan_regions.geojson"
    );
    const res_regions = await fetch(`/geojson_data/regions.geojson`);
    const res_districts = await fetch(`/geojson_data/districts.geojson`);
    const res_cities = await fetch(`/geojson_data/cities.geojson`);

    geojsonRegions.value = await geojson_regions.json();
    Object.assign(regionsGeojson, await res_regions.json());
    Object.assign(districtsGeojson, await res_districts.json());
    Object.assign(citiesGeojson, await res_cities.json());
}

async function initMap() {
    map.value = L.map("map", {
        zoom: zoom.value,
        center: center.value,
    })
        .on("zoomend", function (e) {
            zoom.value = map.value.getZoom();
        })
        .on("moveend", function (e) {
            center.value = Object.values(map.value.getBounds().getCenter());
        });

    tileProviders[t("Openstreet_map")].addTo(map.value);

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
    await fetchLayerDataBySelectedArea();
    initializeDefaultLayersToMap();
}

async function fetchLayerDataBySelectedArea() {
    const res = await axios.get("/admin/map/layers-data", {
        params: { soatos: selectedSoatos.value },
    });

    Object.assign(selectedLayers, await res.data);
}

function initializeDefaultLayersToMap() {
    L.geoJSON(regionsGeojson, {
        onEachFeature: function (feature, layer) {
            layer
                .on("click", async function () {
                    //
                })
                .on("mouseover", function () {
                    this.setStyle({
                        weight: 2,
                    });
                })
                .on("mouseout", function () {
                    this.setStyle({
                        weight: 1,
                    });
                })
                .bindPopup(
                    `
                        <ul class="list-group mt-4">
                            <li class="list-group-item d-flex align-items-start">
                                <span class="fw-bold">
                                    Nomi
                                </span>
                                <span class="ms-auto">
                                    ${feature.properties?.name_uz}
                                </span>
                            </li>
                            <li class="list-group-item d-flex align-items-start">
                                <span class="fw-bold">
                                    SOATO kodi
                                </span>
                                <span class="ms-auto">
                                    ${feature.properties?.soato}
                                </span>
                            </li>
                        </ul>
                        `,
                    {
                        minWidth: 300,
                    }
                );
        },
        style: function (feature) {
            return {
                color: "#0eb297",
                weight: 1,
                // fillOpacity: 0.0,
            };
        },
    }).addTo(map.value);
}

function updateBallLayers(arr) {
    L.geoJSON(arr, {
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
    });
}
</script>

<template>
    <div id="map-container" class="position-relative">
        <Loader v-if="mapLoader" />
        <div id="map" style="height: 80vh"></div>
        <div id="left_control_block">
            <BorderLayersControl />
            <LayersControl
                :balls="selectedLayers.balls"
                :borders="selectedLayers.borders"
                :zones="selectedLayers.zones"
                @updateBallLayers="updateBallLayers"
            />
        </div>
        <!-- <div
            id="right_control_block"
            v-if="selectedRasterData.length && selectedRasterLayer"
        >
            //
        </div> -->
        <p>Center is at {{ center }} and the zoom is: {{ zoom }}</p>
    </div>
</template>

<!-- <script>
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    layout: AdminLayout,
};
</script> -->

<style lang="scss" scoped>
#left_control_block {
    // border: 2px solid lightgray;
    position: absolute;
    top: 5.25rem;
    left: 1rem;
    z-index: 1000;
    // min-width: 100px;
    width: 100%;
    max-width: 20vw;
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
