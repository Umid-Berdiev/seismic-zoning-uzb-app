<script setup lang="ts">
import { onMounted, reactive, ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";
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
import { useSwal } from "@/composable/useSwal";

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
const notif = useNotyf();
const columns = reactive([
    {
        name: "Ma'lumot turi",
        field: "type",
    },
    {
        name: "Izoh",
        field: "comment",
    },
    {
        name: "Yuklangan sanasi",
        field: "created_at",
    },
]);
const layerTypeSelectState = reactive({
    options: [
        {
            label: "Balls",
            value: "balls.import.shape_file",
        },
        {
            label: "Zones",
            value: "zones.import.shape_file",
        },
        // {
        //     label: "Borders",
        //     value: "borders.import.shape_file",
        // },
        // {
        //     label: "DSR",
        //     value: "segments.import.shape_file",
        // },
    ],
    selectedOption: "balls.import.shape_file",
});
const importForm = useForm({
    zip: null,
});
const swal = useSwal();
const fileInput = ref<HTMLInputElement>();

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

    const modalEl = document.getElementById("importStaticDataModal");
    modalEl?.addEventListener("hidden.bs.modal", (event) => {
        layerTypeSelectState.selectedOption = "balls.import.shape_file";
        importForm.reset();

        const file_input = document.getElementById("fileInput");
        if (file_input) file_input.value = null;
    });
});

async function onModalSubmit() {
    importForm.post(route(layerTypeSelectState.selectedOption), {
        onSuccess: () => {
            notif.success("Data successfully imported!");
            const modal = Modal.getInstance("#importStaticDataModal");
            modal?.hide();
        },
    });
}

async function onRemove(layer_id: number, layer_type: "ball" | "pga") {
    // Inertia.delete(`/layers/${layer_id}/${layer_type}`, {
    //     onBefore: () => confirm("Are you sure you want to delete this record?"),
    // });
    const result = await swal.fire({
        title: "Ishonchingiz komilmi?",
        text: "O'chirilgandan ma'lumotni qayta tiklab bo'lmaydi!",
        icon: "warning",
        showCancelButton: true,
        customClass: {
            confirmButton: "btn btn-danger m-1",
            cancelButton: "btn btn-secondary m-1",
        },
        confirmButtonText: "Ha, o'chiravering!",
        cancelButtonText: "Yo'q, o'chirmang!",
        // html: false,
        preConfirm: () => {
            return useForm().delete(
                route(`layers.remove`, { layer_id, layer_type })
            );
        },
    });

    if (result.value) {
        swal.fire(
            "O'chirildi!",
            "Ma'lumot muvoffaqiyatli o'chirildi.",
            "success"
        );
        // result.dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
    } else if (result.dismiss === "cancel") {
        swal.fire("Bekor qilindi", "Ma'lumot saqlab qolindi :)", "error");
    }
}
</script>

<template>
    <div class="content">
        <div class="d-flex justify-content-end">
            <ImportButton modal-id="importStaticDataModal" />
        </div>

        <BaseBlock :title="$t('Imported_shape_files_logs')" content-full>
            <div v-if="logs.data?.length == 0" class="text-center">
                {{ $t("No_data") }}
            </div>
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
                                        <th>Amallar</th>
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
                                            <td
                                                class="d-flex gap-1 align-items-center"
                                            >
                                                <a :href="row.zipfile_path">
                                                    <i
                                                        class="fa fa-download"
                                                    ></i>
                                                </a>
                                                <button
                                                    type="button"
                                                    class="btn text-danger btn-link"
                                                    @click="
                                                        onRemove(
                                                            row.layer_id,
                                                            row.type
                                                        )
                                                    "
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>
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
                                        ref="fileInput"
                                        id="fileInput"
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
