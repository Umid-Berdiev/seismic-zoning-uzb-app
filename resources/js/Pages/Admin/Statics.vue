<script setup>
import { onMounted, reactive } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Modal } from "bootstrap";
import { useNotyf } from "@/composable/useNotyf";
import Input from "@/Components/Input.vue";
import Button from "@/Components/Button.vue";
import helpers from "@/utils/helper.js";
// Vue Dataset, for more info and examples you can check out https://github.com/kouts/vue-dataset/tree/next
import { Dataset, DatasetItem } from "vue-dataset";
import BaseBlock from "@/Components/BaseBlock.vue";
import Pagination from "@/Components/Pagination.vue";
import ImportButton from "@/Components/Buttons/ImportButton.vue";
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";

const props = defineProps({
    logs: {
        type: Object,
        default: () => ({
            current_page: 1,
            data: [],
            first_page_url: "",
            from: 1,
            last_page: 1,
            last_page_url: "",
            links: [],
            next_page_url: null,
            path: "",
            per_page: 10,
            prev_page_url: null,
            to: 2,
            total: 10,
        }),
    },
});
const notyf = useNotyf();
const columns = reactive([
    {
        name: "Data type",
        field: "type",
    },
    {
        name: "Comment",
        field: "comment",
    },
    {
        name: "Date",
        field: "created_at",
    },
]);
const layerTypeSelectState = reactive({
    options: [
        {
            label: "Zones",
            value: "zones.import.shape_file",
        },
        {
            label: "Balls",
            value: "balls.import.shape_file",
        },
        {
            label: "Borders",
            value: "borders.import.shape_file",
        },
    ],
    selectedOption: "balls.import.shape_file",
});
const importForm = useForm({
    zip: null,
});

// Apply a few Bootstrap 5 optimizations
onMounted(() => {
    // Remove labels from
    document.querySelectorAll("#datasetLength label").forEach((el) => {
        el.remove();
    });

    // Replace select classes
    let selectLength = document.querySelector("#datasetLength select");

    if (selectLength) {
        selectLength.classList = "";
        selectLength.classList.add("form-select");
    }
});

async function onModalSubmit() {
    importForm.post(route(layerTypeSelectState.selectedOption), {
        onSuccess: () => {
            notyf.success("Data successfully imported!");
            const modal = Modal.getInstance("#importStaticDataModal");
            modal?.hide();
        },
        onError: (errorObj) => {
            notyf.error(errorObj.zip);
            // notyf.error("Error while uploading shape file!");
        },
    });
}
</script>

<template>
    <div class="content">
        <div class="d-flex justify-content-end">
            <ImportButton modal-id="importStaticDataModal" />
        </div>

        <BaseBlock title="Imported shape files' logs" content-full>
            <div v-if="logs.data?.length == 0" class="text-center">No data</div>
            <Dataset v-else v-slot="{ ds }" :ds-data="logs.data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th
                                            v-for="(th, index) in columns"
                                            :key="th.field"
                                        >
                                            {{ th.name }}
                                        </th>
                                    </tr>
                                </thead>
                                <DatasetItem tag="tbody" class="fs-sm">
                                    <template #default="{ row, rowIndex }">
                                        <tr>
                                            <th scope="row">
                                                {{ rowIndex + 1 }}
                                            </th>
                                            <td>{{ row.type }}</td>
                                            <td>{{ row.comment }}</td>
                                            <td>
                                                {{
                                                    helpers.formatDate(
                                                        row.created_at,
                                                        "DD-MM-YYYY"
                                                    )
                                                }}
                                            </td>
                                        </tr>
                                    </template>
                                </DatasetItem>
                            </table>
                        </div>
                    </div>
                </div>
                <div
                    class="d-flex flex-md-row flex-column align-items-center mt-3"
                >
                    <!-- <DatasetInfo class="py-3 fs-sm" />
                            <DatasetPager class="flex-wrap py-3 fs-sm" /> -->
                    <Pagination :links="logs.links" />
                </div>
            </Dataset>
        </BaseBlock>

        <!-- Modal -->
        <div
            class="modal fade"
            id="importStaticDataModal"
            tabindex="-1"
            aria-labelledby="importStaticDataModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importStaticDataModalLabel">
                            {{ $t("Import_zipped_shapefile_data") }}
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="onModalSubmit">
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <select
                                        class="form-select"
                                        aria-label="Select layer type"
                                        v-model="
                                            layerTypeSelectState.selectedOption
                                        "
                                    >
                                        <option selected disabled :value="null">
                                            {{ $t("Select_layer_type") }}
                                        </option>
                                        <option
                                            v-for="item in layerTypeSelectState.options"
                                            :value="item.value"
                                        >
                                            {{ item.label }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-12 mb-4">
                                    <Input
                                        type="file"
                                        accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed"
                                        @change="
                                            importForm.zip =
                                                $event.target.files[0]
                                        "
                                        :class="{
                                            'is-invalid':
                                                importForm.errors?.zip?.length,
                                        }"
                                        placeholder="Select a shapefile"
                                    />
                                    <progress
                                        v-if="importForm.progress"
                                        :value="importForm.progress.percentage"
                                        max="100"
                                    >
                                        {{ importForm.progress.percentage }}%
                                    </progress>
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                    >
                                        {{ importForm.errors?.zip }}
                                    </div>
                                </div>

                                <div class="col-auto ms-auto">
                                    <SubmitButton />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
//
</style>
