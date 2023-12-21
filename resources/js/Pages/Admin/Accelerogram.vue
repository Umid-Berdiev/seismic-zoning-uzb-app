<script setup lang="ts">
import { computed, onMounted, reactive, ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Dataset, DatasetItem } from "vue-dataset";
import { Modal } from "bootstrap";
import { useNotyf } from "@/composable/useNotyf";
import Input from "@/Components/Input.vue";
import Button from "@/Components/Button.vue";
import BaseBlock from "@/Components/BaseBlock.vue";
import InputLabel from "@/Components/InputLabel.vue";
import ConfirmModal from "@/Components/Modals/ConfirmModal.vue";
import InputError from "@/Components/InputError.vue";
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";
import VueSelect from "vue-select";

const props = withDefaults(
    defineProps<{
        list: string[];
        regions: any[];
    }>(),
    {
        list: () => [],
        regions: () => [],
    }
);

const notif = useNotyf();
const modal = ref(null);
const columns = reactive([
    {
        name: "Fayil nomi",
        field: "file_name",
    },
    {
        name: "Viloyat nomi",
        field: "region_name",
    },
]);
const selectedAccelerogramFileId = ref<number | null>(null);
const formFields = useForm({
    region_soato: "",
    excel_file: null,
});
const isEditing = ref(false);
const isLoading = ref(false);

onMounted(() => {
    modal.value = new Modal("#accelerogramFormModal");
    modal.value._element.addEventListener("hidden.bs.modal", () => {
        isEditing.value = false;
        formFields.reset();
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
    isLoading.value = true;

    try {
        formFields.clearErrors();
        formFields.post(route("accelerograms.import"), {
            onSuccess: () => {
                notif.success("Ma'lumotlar muvaffaqiyatli saqlandi!");
                formFields.reset();
                modal.value?.hide();
            },
        });
    } catch (error) {
        notif.error("Ma'lumotlarni saqlashda hatolik!");
    } finally {
        isLoading.value = false;
    }
}

function onRemove(id) {
    selectedAccelerogramFileId.value = id;
}

function deleteAction() {
    const confirmModal = Modal.getInstance("#modal-confirm");
    formFields.delete(
        route("accelerograms.file", selectedAccelerogramFileId.value),
        {
            onSuccess: () => {
                notif.success("Akselerogramma muvaffaqiyatli o'chirildi!");
                // modal.value?.hide();
            },
            onError: (errorObj) => {
                notif.error("O'chirish jarayonida hatolik!");
            },
        }
    );

    confirmModal?.hide();
}

function onFileChange(e: any) {
    formFields.excel_file = e.target.files[0];
}
</script>

<template>
    <div class="content">
        <div class="d-flex justify-content-end">
            <button
                type="button"
                class="btn btn-sm btn-alt-primary push"
                data-bs-toggle="modal"
                data-bs-target="#accelerogramFormModal"
            >
                <i class="si si-plus me-1"></i>
                <span>Yangi ma'lumot qo'shish</span>
            </button>
        </div>

        <BaseBlock title="Akselerogramma fayllari ro'yhati" content-full>
            <div v-if="props.list?.length == 0" class="text-center">
                {{ $t("No_data") }}
            </div>
            <Dataset v-else :ds-data="list">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th
                                            class="text-capitalize"
                                            v-for="th in columns"
                                            :key="th.field"
                                        >
                                            {{ th.name }}
                                        </th>
                                        <th class="text-center text-capitalize">
                                            {{ $t("Actions") }}
                                        </th>
                                    </tr>
                                </thead>
                                <DatasetItem tag="tbody" class="fs-sm">
                                    <template #default="{ row, rowIndex }">
                                        <tr class="">
                                            <th scope="row">
                                                {{ rowIndex + 1 }}
                                            </th>
                                            <td>{{ row.name }}</td>
                                            <td>{{ row.region?.name_uz }}</td>
                                            <td
                                                class="d-flex gap-2 justify-content-center"
                                            >
                                                <!-- <button
                                                    type="button"
                                                    class="btn btn-secondary w-auto"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#accelerogramFormModal"
                                                    @click="onEdit(row.id)"
                                                >
                                                    <i class="si si-pencil"></i>
                                                </button> -->
                                                <a
                                                    href="javascript:;"
                                                    class="text-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-confirm"
                                                    @click="onRemove(row.id)"
                                                >
                                                    <i class="si si-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </template>
                                </DatasetItem>
                            </table>
                        </div>
                    </div>
                </div>
            </Dataset>
        </BaseBlock>

        <!-- Modal -->
        <div
            class="modal fade"
            id="accelerogramFormModal"
            tabindex="-1"
            aria-labelledby="userFormModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userFormModalLabel">
                            {{
                                isEditing
                                    ? "Akselerogramma ma'lumotlarini o'zgartirish"
                                    : "Yangi akselerogramma ma'lumotlarini qo'shish"
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
                                    <InputLabel value="Viloyatlar ro'yhati" />
                                    <VueSelect
                                        v-model="formFields.region_soato"
                                        :options="regions"
                                        label="name_uz"
                                        :reduce="
                                            (region) => Number(region.soato)
                                        "
                                        placeholder="Viloyatni tanlang"
                                    />
                                    <InputError
                                        :message="
                                            formFields.errors?.region_soato
                                        "
                                    />
                                </div>
                                <div class="col-12 mb-3">
                                    <InputLabel
                                        value="Faylni tanlang"
                                        for="uploaded-file"
                                    />
                                    <Input
                                        id="uploaded-file"
                                        type="file"
                                        @change="onFileChange"
                                        accept=".xlsx,.xls"
                                    />
                                    <InputError
                                        :message="formFields.errors?.excel_file"
                                    />
                                </div>
                                <div class="col-auto ms-auto">
                                    <SubmitButton
                                        :loading="formFields.processing"
                                    />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <ConfirmModal @confirm="deleteAction" />
    </div>
</template>

<style lang="scss">
// Vue Select + Custom overrides
@import "vue-select/dist/vue-select.css";
@import "@/assets/scss/vendor/vue-select";
</style>
