<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { computed, reactive, ref } from "vue";
import { Dataset, DatasetItem, DatasetInfo, DatasetPager } from "vue-dataset";
import BaseBlock from "../BaseBlock.vue";
import Button from "../Button.vue";
import domtoimage from "dom-to-image-more";

const props = defineProps({
    data: {
        type: Array,
        default: () => [],
    },
    labelType: "",
});
const soilDataAreaTotal = computed(
    () =>
        props.data.length &&
        props.data.reduce((acc, cur) => acc + Number(cur.area), 0)
);
const exportForm = useForm();
const isLoading = ref(false);

function areaInPercent(rowAreaValue) {
    return ((rowAreaValue / soilDataAreaTotal.value) * 100).toFixed(2);
}

function exportTableData() {
    exportForm.get(route(`${props.labelType}.export`));
}

function filter(node) {
    return (
        // node.id !== "collapse-1" &&
        node.tagName !== "A" &&
        node.tagName !== "BUTTON" &&
        node.className !== "leaflet-control-zoom leaflet-bar leaflet-control" &&
        node.className !== "leaflet-control-layers leaflet-control" &&
        node.className !== "leaflet-control-attribution leaflet-control" &&
        node.className !== "leaflet-control-scale leaflet-control"
    );
}

async function getImage() {
    isLoading.value = true;

    try {
        let node = document.getElementById("map-container");

        const blob = await domtoimage.toBlob(node, {
            bgcolor: "#fff",
            filter: filter,
            quality: 1.0,
        });
        downloadBlob(blob, "map_screenshot.png");
    } catch (error) {
        notyf.error("Error while taking screenshot: " + error.message);
    } finally {
        isLoading.value = false;
    }
}

function downloadBlob(blob, name = "map-image.png") {
    // Convert your blob into a Blob URL (a special url that points to an object in the browser's memory)
    const blobUrl = URL.createObjectURL(blob);

    // Create a link element
    const link = document.createElement("a");
    // this.setMapLoader(true);

    // Set link's href to point to the Blob URL
    link.href = blobUrl;
    link.download = name;

    // Append link to the body
    document.body.appendChild(link);

    // Dispatch click event on the link
    // This is necessary as link.click() does not work on the latest firefox
    link.dispatchEvent(
        new MouseEvent("click", {
            bubbles: true,
            cancelable: true,
            view: window,
        })
    );

    // Remove link from body
    document.body.removeChild(link);
}
</script>

<template>
    <BaseBlock title="Table" class="mb-3">
        <div class="d-flex gap-2 mb-3">
            <!-- <form class="ms-auto" @submit.prevent="exportTableData">
                <Button class="w-auto" type="submit">
                    <i class="si si-cloud-download"></i>
                    <span class="ms-2">Export</span>
                </Button>
            </form> -->
            <a
                :href="route(`${labelType}.export`)"
                class="btn btn-sm btn-primary ms-auto"
                :disabled="isLoading"
            >
                <i class="si si-cloud-download"></i>
                <!-- <span class="ms-2">Export</span> -->
            </a>
            <Button
                class="btn btn-sm w-auto"
                @click="getImage"
                :disabled="isLoading"
            >
                <span
                    v-if="isLoading"
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true"
                ></span>
                <i v-else class="si si-camera"></i>
                <!-- <span class="ms-2">Take a screenshot</span> -->
            </Button>
        </div>
        <Dataset
            v-slot="{ ds }"
            :ds-data="data.sort((a, b) => a.value - b.value)"
        >
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-3">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">№</th>
                                    <th>
                                        {{ labelType.split("_").join(" ") }}
                                    </th>
                                    <th>Area</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <DatasetItem tag="tbody" class="fs-sm">
                                <template #default="{ row, rowIndex }">
                                    <tr>
                                        <th scope="row">
                                            {{ rowIndex + 1 }}
                                        </th>
                                        <!-- <td>{{ row.value }}</td> -->
                                        <td>{{ row[labelType] }}</td>
                                        <td class="text-end">
                                            {{ row.area }}
                                        </td>
                                        <td class="text-end">
                                            {{ areaInPercent(row.area) }}
                                        </td>
                                    </tr>
                                </template>
                            </DatasetItem>
                        </table>
                    </div>
                </div>
            </div>
            <!-- <div
                            class="d-flex flex-md-row flex-column justify-content-between align-items-center"
                        >
                            <DatasetInfo class="py-3 fs-sm" />
                            <DatasetPager class="flex-wrap py-3 fs-sm" />
                        </div> -->
        </Dataset>
    </BaseBlock>
</template>
