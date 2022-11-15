<script setup>
import { computed, onMounted, reactive, ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Modal } from "bootstrap";
import { useNotyf } from "@/composable/useNotyf";
import Input from "@/Components/Input.vue";
import Button from "@/Components/Button.vue";
import BaseBlock from "@/Components/BaseBlock.vue";
import InputLabel from "@/Components/InputLabel.vue";
import ConfirmModal from "@/Components/Modals/ConfirmModal.vue";

const props = defineProps({
    regions: {
        type: Array,
        default: () => [],
    },
});
const notyf = useNotyf();
const modal = computed(() => Modal.getOrCreateInstance("#regionFormModal"));
const columns = reactive([
    {
        name: "Soato",
        field: "soato",
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

const regionObj = reactive({
    name_uz: "",
    name_ru: "",
    admincenter_uz: "",
    admincenter_ru: "",
});
const regionForm = useForm(regionObj);
const isEditing = ref(false);

onMounted(() => {
    modal.value?._element.addEventListener("hidden.bs.modal", (event) => {
        regionForm.reset();
        regionForm.clearErrors();
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
    regionForm.put(route("regions.update", regionObj.id), {
        onSuccess: () => {
            notyf.success("Region successfully updated!");
            regionForm.reset();
            regionForm.clearErrors();
            modal.value?.hide();
        },
        onError: (errorObj) => {
            notyf.error("Error while updating region!");
        },
    });
}

function onEdit(region) {
    isEditing.value = true;

    Object.assign(regionObj, region);
    regionForm.name_uz = region.name_uz;
    regionForm.name_ru = region.name_ru;
    regionForm.admincenter_uz = region.admincenter_uz;
    regionForm.admincenter_ru = region.admincenter_ru;
    modal.value?.toggle();
}

function onView(region_id) {
    useForm().get(route("districts.index", region_id));
}

function exportToExcel() {
    location.href = route("regions.export");
}
</script>

<template>
    <div class="content">
        <div class="d-flex justify-content-end">
            <button
                type="button"
                class="btn btn-alt-primary"
                data-bs-toggle="modal"
                data-bs-target="#modal-confirm"
            >
                <i class="fa fa-download me-1"></i>
                <span>{{ $t("Export_to_excel") }}</span>
            </button>
        </div>
        <br />
        <BaseBlock :title="$t('Regions_table')" content-full>
            <div v-if="regions?.length == 0" class="text-center">
                {{ $t("No_data") }}
            </div>
            <div v-else class="row">
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
                            <tbody>
                                <tr
                                    v-for="(row, rowIndex) in regions"
                                    :key="row.id"
                                >
                                    <th scope="row">
                                        {{ rowIndex + 1 }}
                                    </th>
                                    <td>{{ row.soato }}</td>
                                    <td>{{ row.name_uz }}</td>
                                    <!-- <td>{{ row.name_ru }}</td>
                                    <td>{{ row.admincenter_uz }}</td>
                                    <td>{{ row.admincenter_ru }}</td> -->
                                    <td class="d-flex gap-2">
                                        <button
                                            type="button"
                                            class="btn btn-secondary w-auto"
                                            @click="onView(row.id)"
                                        >
                                            <i class="si si-eye"></i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-secondary w-auto"
                                            @click="onEdit(row)"
                                        >
                                            <i class="si si-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </BaseBlock>

        <!-- Modals -->
        <div
            class="modal fade"
            id="regionFormModal"
            tabindex="-1"
            aria-labelledby="regionFormModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-popout">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="regionFormModalLabel">
                            {{
                                isEditing
                                    ? $t("Edit_region_data")
                                    : $t("Add_region_data")
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
                                        v-model="regionForm.name_uz"
                                    />
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                    >
                                        {{ regionForm.errors?.name_uz }}
                                    </div>
                                </div>
                                <!-- <div class="col-12 mb-3">
                                    <InputLabel value="Name ru" />
                                    <Input
                                        type="text"
                                        v-model="regionForm.name_ru"
                                    />
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                    >
                                        {{ regionForm.errors?.name_ru }}
                                    </div>
                                </div> -->
                                <div class="col-12 mb-3">
                                    <InputLabel value="Admincenter uz" />
                                    <Input
                                        type="text"
                                        v-model="regionForm.admincenter_uz"
                                    />
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                    >
                                        {{ regionForm.errors?.admincenter_uz }}
                                    </div>
                                </div>
                                <!-- <div class="col-12 mb-3">
                                    <InputLabel value="Admincenter ru" />
                                    <Input
                                        type="text"
                                        v-model="regionForm.admincenter_ru"
                                    />
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                    >
                                        {{ regionForm.errors?.admincenter_ru }}
                                    </div>
                                </div> -->

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
