<script setup>
import { computed, onMounted, reactive, ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Modal } from "bootstrap";
import { useNotyf } from "@/composable/useNotyf";
import Input from "@/Components/Input.vue";
import Button from "@/Components/Button.vue";
import {
    Dataset,
    DatasetItem,
    DatasetShow,
    DatasetSearch,
    DatasetInfo,
    DatasetPager,
} from "vue-dataset";
import BaseBlock from "@/Components/BaseBlock.vue";
import InputLabel from "@/Components/InputLabel.vue";
import ConfirmModal from "@/Components/Modals/ConfirmModal.vue";

const props = defineProps({
    districts: {
        type: Array,
        default: () => [],
    },
});
const notyf = useNotyf();
const modal = computed(() => Modal.getOrCreateInstance("#districtFormModal"));
const columns = reactive([
    {
        name: "Soato",
        field: "soato",
    },
    {
        name: "Region soato",
        field: "region_soato",
    },
    {
        name: "Name uz",
        field: "name_uz",
    },
    // {
    //     name: "Name ru",
    //     field: "name_ru",
    // },
    // {
    //     name: "Admincenter uz",
    //     field: "admincenter_uz",
    // },
    // {
    //     name: "Admincenter ru",
    //     field: "admincenter_ru",
    // },
]);

const districtObj = reactive({
    name_uz: "",
    name_ru: "",
    admincenter_uz: "",
    admincenter_ru: "",
});
const districtForm = useForm(districtObj);
const isEditing = ref(false);

onMounted(() => {
    modal.value?._element.addEventListener("hidden.bs.modal", (event) => {
        districtForm.reset();
        districtForm.clearErrors();
        isEditing.value = false;
    });

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

async function onModalFormSubmit() {
    districtForm.put(route("districts.update", districtObj.id), {
        onSuccess: () => {
            notyf.success("District successfully updated!");
            districtForm.reset();
            districtForm.clearErrors();
            modal.value?.hide();
        },
        onError: (errorObj) => {
            notyf.error("Error while updating district!");
        },
    });
}

function onEdit(district) {
    isEditing.value = true;

    Object.assign(districtObj, district);
    districtForm.name_uz = district.name_uz;
    districtForm.name_ru = district.name_ru;
    districtForm.admincenter_uz = district.admincenter_uz;
    districtForm.admincenter_ru = district.admincenter_ru;
    modal.value?.toggle();
}

function exportToExcel() {
    // console.log(route().params.region);
    location.href = route("districts.export", route().params.region);
}
</script>

<template>
    <div class="content">
        <div class="d-flex">
            <button
                type="button"
                class="btn btn-alt-primary"
                @click.prevent="useForm().get(route('regions.index'))"
            >
                <i class="si si-arrow-left me-1"></i>
                <span>{{ $t("Back") }}</span>
            </button>
            <button
                type="button"
                class="btn btn-alt-primary ms-auto"
                data-bs-toggle="modal"
                data-bs-target="#modal-confirm"
            >
                <i class="fa fa-download me-1"></i>
                <span>{{ $t("Export_to_excel") }}</span>
            </button>
        </div>
        <br />

        <BaseBlock :title="$t('Districts_table')" content-full>
            <div v-if="districts?.length == 0" class="text-center">
                {{ $t("No_data") }}
            </div>
            <Dataset v-else v-slot="ds" :ds-data="districts">
                <div class="row" :data-page-count="ds.dsPagecount">
                    <div id="datasetLength" class="col-auto py-2">
                        <DatasetShow />
                    </div>
                    <div class="col-auto ms-auto py-2">
                        <DatasetSearch
                            :ds-search-placeholder="$t('Search') + '...'"
                        />
                    </div>
                </div>
                <hr />
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
                                        <th>{{ $t("Actions") }}</th>
                                    </tr>
                                </thead>
                                <DatasetItem tag="tbody" class="fs-sm">
                                    <template #default="{ row, rowIndex }">
                                        <tr>
                                            <th scope="row">
                                                {{ rowIndex + 1 }}
                                            </th>
                                            <td>{{ row.soato }}</td>
                                            <td>{{ row.region_soato }}</td>
                                            <td>{{ row.name_uz }}</td>
                                            <!-- <td>{{ row.name_ru }}</td>
                                            <td>{{ row.admincenter_uz }}</td>
                                            <td>{{ row.admincenter_ru }}</td> -->
                                            <td class="d-flex gap-2">
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary w-auto"
                                                    @click="onEdit(row)"
                                                >
                                                    <i class="si si-pencil"></i>
                                                </button>
                                                <!-- <button
                                                    type="button"
                                                    class="btn btn-danger w-auto"
                                                    @click="onRemove(row.id)"
                                                >
                                                    <i class="si si-trash"></i>
                                                </button> -->
                                            </td>
                                        </tr>
                                    </template>
                                </DatasetItem>
                            </table>
                        </div>
                    </div>
                </div>
                <div
                    class="d-flex flex-md-row flex-column justify-content-between align-items-center"
                >
                    <DatasetInfo class="py-3 fs-sm" />
                    <DatasetPager class="flex-wrap py-3 fs-sm" />
                </div>
            </Dataset>
        </BaseBlock>

        <!-- Modals -->
        <div
            class="modal fade"
            id="districtFormModal"
            tabindex="-1"
            aria-labelledby="districtFormModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-popout">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="districtFormModalLabel">
                            {{
                                isEditing
                                    ? "Edit district data"
                                    : "Add district data"
                            }}
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="onModalFormSubmit">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <InputLabel value="Name uz" />
                                    <Input
                                        type="text"
                                        v-model="districtForm.name_uz"
                                    />
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                    >
                                        {{ districtForm.errors?.name_uz }}
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <InputLabel value="Name ru" />
                                    <Input
                                        type="text"
                                        v-model="districtForm.name_ru"
                                    />
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                    >
                                        {{ districtForm.errors?.name_ru }}
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <InputLabel value="Admincenter uz" />
                                    <Input
                                        type="text"
                                        v-model="districtForm.admincenter_uz"
                                    />
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                    >
                                        {{
                                            districtForm.errors?.admincenter_uz
                                        }}
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <InputLabel value="Admincenter ru" />
                                    <Input
                                        type="text"
                                        v-model="districtForm.admincenter_ru"
                                    />
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                    >
                                        {{
                                            districtForm.errors?.admincenter_ru
                                        }}
                                    </div>
                                </div>

                                <div class="col-auto ms-auto">
                                    <Button>{{ $t("Submit") }}</Button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <ConfirmModal @confirm="exportToExcel" />
    </div>
</template>

<style lang="scss" scoped>
//
</style>
