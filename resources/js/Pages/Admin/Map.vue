<script setup lang="ts">
import { onMounted, reactive, ref, watch } from "vue";
import { useI18n } from "vue-i18n";
import L, { LatLngExpression, Map } from "leaflet";
import "leaflet/dist/leaflet.css";
import { useNotyf } from "@/composable/useNotyf";
import Loader from "@/Components/Loader.vue";
import BorderLayersControl from "@/Components/Maps/BorderLayersControl.vue";
import LayersControl from "@/Components/Maps/LayersControl.vue";
import BaseBlock from "@/Components/BaseBlock.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Input from "@/Components/Input.vue";
import InputError from "@/Components/InputError.vue";
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";
import MarkerModal from "@/Components/Modals/MarkerModal.vue";
import { Modal } from "bootstrap";
import colors from "@/data/colors";
import iconUrl from "leaflet/dist/images/marker-icon.png";
import shadowUrl from "leaflet/dist/images/marker-shadow.png";
import iconRetinaUrl from "leaflet/dist/images/marker-icon-2x.png";
import { LayerGroupTypes } from "@/utils/interfaces";
import { isEmpty, isNull } from "lodash";
import SearchFormOverlay from "@/Components/overlays/SearchFormOverlay.vue";

delete L.Icon.Default.prototype._getIconUrl;

L.Icon.Default.mergeOptions({
    iconRetinaUrl,
    iconUrl,
    shadowUrl,
});

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    borders: Array,
    balls: Object,
    zones: Array,
});
const { t } = useI18n();
const notif = useNotyf();
const zoom = ref(6);
const mapLoader = ref(false);
const isSearchFormOverlayOpen = ref(false);
const initialCenter = ref<LatLngExpression>([40.4111, 66.9]);
const center = ref(initialCenter.value);
const map = ref<Map | null>(null);
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
const ballLayers = ref([]);
const zoneLayers = ref([]);
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

const selectedSoatos = ref([]);
const pageHeaderHeight = ref("90vh");
const selectedLayerGroup = ref<LayerGroupTypes>("balls");
const selectedAccuracy = ref<number | null>(90);
const searchForm = reactive({
    latitude: null,
    longitude: null,
});
const isMarkerModalOpen = ref(false);

onMounted(async () => {
    // fetch geojson data
    mapLoader.value = true;
    await fetchStaticLayers();

    // init map
    initMap();
    await fetchLayerDataBySelectedArea();
    updateLayerGroup();
    mapLoader.value = false;
    const pageHeader = document.getElementById("page-header");
    pageHeaderHeight.value = `calc(100vh - ${pageHeader?.offsetHeight}px)`;
});

watch(
    () => selectedAccuracy.value,
    async (newVal: number | null) => {
        if (newVal) {
            selectedLayerGroup.value = "balls";
            clearLayers();
            await fetchLayerDataBySelectedArea();
            updateLayerGroup();
        }
    }
);

watch(
    () => selectedLayerGroup.value,
    async (newVal: LayerGroupTypes) => {
        if (newVal) {
            clearLayers();
            await fetchLayerDataBySelectedArea();
            updateLayerGroup();
        }
    }
    // { immediate: true }
);

async function onAreaUpdated(area: import("@/utils/interfaces").AreaData) {
    mapLoader.value = true;
    selectedLayerGroup.value = "balls";
    selectedAccuracy.value = null;

    if (area) {
        selectedSoatos.value = [];
        clearLayers();

        if (Number(area.soato)) {
            const foundArea =
                String(area.soato).length > 4
                    ? districtsGeojson.features?.find(
                          (feature) =>
                              feature.properties.soato === Number(area.soato)
                      )
                    : citiesGeojson.features?.find(
                          (feature) =>
                              feature.properties.soato === Number(area.soato)
                      );

            if (foundArea) {
                selectedSoatos.value = [Number(area.soato)];
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
                            fillOpacity: 0.0,
                        };
                    },
                }).addTo(map.value);
                const areaBounds = L.latLngBounds(districtPolygon.getBounds());
                map.value.flyTo(areaBounds.getCenter(), 10);
            } else {
                notif.error("Area not found!");
            }
        } else if (area.regions?.length) {
            const soatoArr = area.regions.map((region) => Number(region.soato));
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
                            fillOpacity: 0.0,
                        };
                    },
                }).addTo(map.value);
                const areaBounds = L.latLngBounds(
                    dsrSectionPolygon.getBounds()
                );
                map.value.flyTo(areaBounds.getCenter(), 7);
            } else {
                notif.error("Area not found!");
            }
        }
    }
    await fetchLayerDataBySelectedArea();
    updateLayerGroup();
    mapLoader.value = false;
}

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

function initMap() {
    map.value = L.map("map", {
        zoom: zoom.value,
        center: center.value,
        zoomControl: false,
        minZoom: 6,
    })
        .on("zoomend", function (e) {
            zoom.value = map.value.getZoom();
        })
        .on("moveend", function (e) {
            center.value = Object.values(
                map.value.getBounds().getCenter()
            ) as LatLngExpression;
        });

    tileProviders[t("Openstreet_map")].addTo(map.value);

    // add control layers to map
    L.control
        .zoom({
            position: "topright",
        })
        .addTo(map.value);

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

async function fetchLayerDataBySelectedArea() {
    try {
        mapLoader.value = true;
        let result;

        if (selectedAccuracy.value) {
            result = await axios.get("/admin/map/accuracy", {
                params: {
                    accuracy: selectedAccuracy.value,
                },
            });
        } else {
            result = await axios.get("/admin/map/layers-data", {
                params: {
                    soatos: selectedSoatos.value,
                    layer_group: selectedLayerGroup.value,
                },
            });
        }

        if (isEmpty(result.data))
            notif.warning("Tanlangan hududda ma'lumotlar topilmadi");
        if (selectedLayerGroup.value === "balls")
            ballLayers.value = result.data;
        if (selectedLayerGroup.value === "zones")
            zoneLayers.value = result.data;
    } catch (error) {
        notif.error(error.message);
    } finally {
        mapLoader.value = false;
    }
}

function updateLayerGroup() {
    if (selectedLayerGroup.value === "balls") {
        map.value.createPane("ballPane");
        map.value.getPane("ballPane").style.zIndex = 400;

        const geomArr = ballLayers.value.map((ball) => ({
            ...ball.geom,
            level: ball.level,
        }));

        const ballLayer = L.geoJSON(geomArr, {
            pane: "ballPane",
            style: function (geoJsonFeature) {
                const levelColor = findColor(geoJsonFeature.geometry.level);
                return {
                    stroke: true,
                    fill: true,
                    color: levelColor,
                    fillColor: levelColor,
                    fillOpacity: 1,
                    weight: 1,
                };
            },
        }).addTo(map.value);

        const areaBounds = L.latLngBounds(ballLayer.getBounds());
        const ballZoom = map.value.getBoundsZoom(areaBounds);
        map.value.flyTo(areaBounds.getCenter(), ballZoom);
    }

    if (selectedLayerGroup.value === "zones") {
        map.value.createPane("zonePane");
        map.value.getPane("zonePane").style.zIndex = 400;

        const geomArr = zoneLayers.value.map((zone) => ({
            ...zone.geom,
            level: zone.level,
        }));

        const zoneLayer = L.geoJSON(geomArr, {
            pane: "zonePane",
            style: function (geoJsonFeature) {
                const levelColor = findColor(
                    geoJsonFeature.geometry.level / 10
                );
                return {
                    stroke: true,
                    fill: true,
                    color: levelColor,
                    fillColor: levelColor,
                    fillOpacity: 1,
                    weight: 1,
                };
            },
        }).addTo(map.value);

        const areaBounds = L.latLngBounds(zoneLayer.getBounds());
        const zoneZoom = map.value.getBoundsZoom(areaBounds);
        map.value.flyTo(areaBounds.getCenter(), zoneZoom);
    }
}

async function onSearch() {
    try {
        mapLoader.value = true;
        map.value.eachLayer((layer) => {
            if (layer.options?.pane === "markerPane")
                layer.removeFrom(map.value);
        });

        L.marker([searchForm.latitude, searchForm.longitude])
            .on("click", function (e) {
                isMarkerModalOpen.value = true;
                const confirmModal = Modal.getOrCreateInstance("#marker-modal");
                confirmModal.show();
            })
            .addTo(map.value);

        map.value.flyTo(
            L.latLng([searchForm.latitude, searchForm.longitude]),
            10
        );

        // const res = await axios.get("/admin/map/search", {
        //     params: searchForm,
        // });
    } catch (error) {
        //
    } finally {
        mapLoader.value = false;
    }
}

function clearMarker() {
    map.value.eachLayer((layer) => {
        if (layer.options?.pane === "markerPane") layer.removeFrom(map.value);
    });

    searchForm.latitude = "";
    searchForm.longitude = "";
    map.value.flyTo(initialCenter.value, 6);
}

function findColor(index: number) {
    const color = colors.find((color) => color.index == index)?.value;
    return color ?? "black";
}

function clearLayers() {
    map.value?.eachLayer((layer) => {
        if (
            layer.options?.pane === "ballPane" ||
            layer.options?.pane === "zonePane"
        )
            layer.removeFrom(map.value);
    });

    ballLayers.value = [];
    zoneLayers.value = [];
}
</script>

<template>
    <div
        id="map-container"
        class="position-relative"
        :style="{ height: pageHeaderHeight }"
    >
        <Loader v-if="mapLoader" />
        <div id="map" style="height: inherit"></div>
        <div id="left_control_block">
            <div class="d-flex align-items-start">
                <BaseBlock
                    v-show="isSearchFormOverlayOpen"
                    :title="$t('Search_by_coordinates')"
                    :class="[
                        'animated',
                        isSearchFormOverlayOpen ? 'fadeInLeft' : 'fadeOutLeft',
                        'mb-3 pb-3',
                    ]"
                    btn-option-content
                >
                    <form @submit.prevent="onSearch">
                        <div class="d-flex gap-3">
                            <div class="small">
                                <InputLabel for="latitude-input">
                                    <span>{{ $t("Latitude") }}</span>
                                    <span class="text-danger">*</span>
                                </InputLabel>
                                <Input
                                    id="latitude-input"
                                    small
                                    type="number"
                                    :step="0.000000001"
                                    :min="37"
                                    :max="45.5"
                                    v-model="searchForm.latitude"
                                />
                                <InputError
                                    :message="searchForm.errors?.latitude"
                                />
                            </div>
                            <div class="small">
                                <InputLabel for="longitude-input">
                                    <span>{{ $t("Longitude") }}</span>
                                    <span class="text-danger">*</span>
                                </InputLabel>
                                <Input
                                    id="longitude-input"
                                    small
                                    type="number"
                                    :step="0.000000001"
                                    :min="56"
                                    :max="74"
                                    v-model="searchForm.longitude"
                                />
                                <InputError
                                    :message="searchForm.errors?.longitude"
                                />
                            </div>
                        </div>
                        <div class="d-flex mt-3">
                            <button
                                class="btn btn-warning"
                                type="button"
                                @click="clearMarker"
                            >
                                {{ $t("Clear") }}
                            </button>
                            <SubmitButton
                                class="ms-auto"
                                :disabled="
                                    !searchForm.latitude ||
                                    !searchForm.longitude
                                "
                                >{{ $t("Search") }}</SubmitButton
                            >
                        </div>
                    </form>
                </BaseBlock>
                <div
                    class="bg-white border rounded-end py-2 px-3"
                    @click="isSearchFormOverlayOpen = !isSearchFormOverlayOpen"
                >
                    <i class="si si-magnifier"></i>
                </div>
            </div>
            <BorderLayersControl
                v-model:accuracy="selectedAccuracy"
                @update-area="onAreaUpdated"
            />
            <LayersControl
                v-model:layer-group="selectedLayerGroup"
                :zone-disabled="!isNull(selectedAccuracy)"
            />
        </div>
        <div id="right_bottom_block" v-if="selectedLayerGroup">
            <BaseBlock
                :title="$t('Conventional_designation')"
                class="mb-3 pb-3"
                btn-option-content
            >
                <table class="table table-sm table-bordered border-secondary">
                    <template v-if="selectedLayerGroup === 'balls'">
                        <thead class="bg-light">
                            <tr>
                                <th colspan="2">{{ $t("Balls") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="ball in ballLayers">
                                <td>{{ ball.level }}</td>
                                <td>
                                    <div
                                        class="rectangle-layer"
                                        :style="{
                                            'background-color': findColor(
                                                ball.level
                                            ),
                                        }"
                                    ></div>
                                </td>
                            </tr>
                        </tbody>
                    </template>
                    <template v-if="selectedLayerGroup === 'zones'">
                        <thead class="bg-light">
                            <tr>
                                <th colspan="2">{{ $t("Zones") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="zone in zoneLayers">
                                <td>{{ zone.level }}</td>
                                <td>
                                    <div
                                        class="rectangle-layer"
                                        :style="{
                                            'background-color': findColor(
                                                zone.level / 10
                                            ),
                                        }"
                                    ></div>
                                </td>
                            </tr>
                        </tbody>
                    </template>
                </table>
            </BaseBlock>
        </div>

        <MarkerModal />
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
    top: 1rem;
    left: 1rem;
    z-index: 1000;
    // min-width: 100px;
    width: 100%;
    max-width: 20vw;
    max-height: 85vh;
    overflow-y: auto;
}

#right_control_block {
    // border: 2px solid lightgray;
    position: absolute;
    top: 4.25rem;
    right: 1rem;
    z-index: 800;
    width: 370px;
}

#right_top_block {
    position: absolute;
    right: 1rem;
    top: 4rem;
    z-index: 800;
    width: 370px;
}

#right_bottom_block {
    position: absolute;
    right: 1rem;
    bottom: 1rem;
    z-index: 800;
    width: 370px;
}

.rectangle-layer {
    width: 2rem;
    height: 1rem;
    // background-color: purple;
}
</style>
