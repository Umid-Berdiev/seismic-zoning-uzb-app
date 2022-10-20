<script setup>
import { computed, onMounted, reactive, ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Modal } from "bootstrap";
import { useNotyf } from "@/composable/useNotyf";
import Input from "@/Components/Input.vue";
import Button from "@/Components/Button.vue";
import helpers from "@/utils/helper.js";
// Vue Dataset, for more info and examples you can check out https://github.com/kouts/vue-dataset/tree/next
import { Dataset, DatasetItem } from "vue-dataset";
import BaseBlock from "@/Components/BaseBlock.vue";
import InputLabel from "@/Components/InputLabel.vue";
import ConfirmModal from "@/Components/Modals/ConfirmModal.vue";
import InputError from "@/Components/InputError.vue";
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";

const props = defineProps({
    list: {
        type: Array,
        default: () => [],
    },
    regions: {
        type: Array,
        default: () => [],
    },
});
const notyf = useNotyf();
const selectedRegions = ref([]);
const section = reactive({
    name: "",
    soatos: "",
    details: "",
});
const sectionForm = useForm(section);
const modal = computed(() => Modal.getOrCreateInstance("#dsrSectionFormModal"));
const columns = reactive([
    {
        name: "Nomi",
        field: "name",
    },
    {
        name: "Tegishli viloyatlar",
        field: "regions",
    },
    {
        name: "Tavsilotlar",
        field: "details",
    },
    {
        name: "Yangilangan vaqti",
        field: "updated_at",
    },
]);
const isEditing = ref(false);

onMounted(() => {
    modal.value?._element.addEventListener("hidden.bs.modal", (event) => {
        sectionForm.reset();
        sectionForm.clearErrors();
        isEditing.value = false;
    });
});

async function onModalFormSubmit() {
    sectionForm.soatos = selectedRegions.value.join(",");
    isEditing.value
        ? sectionForm.put(route("dsr-sections.update", section.id), {
              onSuccess: () => {
                  notyf.success("Section successfully updated!");
                  modal.value?.hide();
                  sectionForm.reset();
                  sectionForm.clearErrors();
                  isEditing.value = false;
              },
              onError: (errorObj) => {
                  notyf.error("Error while updating section!");
              },
          })
        : sectionForm.post(route("dsr-sections.store"), {
              onSuccess: () => {
                  notyf.success("Section successfully updated!");
                  modal.value?.hide();
                  sectionForm.reset();
                  sectionForm.clearErrors();
                  isEditing.value = false;
              },
              onError: (errorObj) => {
                  notyf.error("Error while creating section!");
              },
          });
}

function onEdit(id) {
    isEditing.value = true;
    const selectedSection = props.list.find((section) => section.id === id);
    selectedRegions.value = selectedSection.regions.map((region) => region.id);
    Object.assign(section, selectedSection);
    sectionForm.name = selectedSection.name;
    // sectionForm.soatos = selectedSection.soatos;
    sectionForm.details = selectedSection.details;

    modal.value?.toggle();
}

function onRemove(id) {
    section.id = id;
    const confirmModal = Modal.getOrCreateInstance("#modal-confirm");
    confirmModal.show();
}

function deleteAction() {
    sectionForm.delete(route("dsr-sections.destroy", section.id), {
        onSuccess: () => {
            notyf.success("Section successfully removed!");
            modal.value?.hide();
        },
        onError: (errorObj) => {
            notyf.error("Error while deleting section!");
        },
    });
}
</script>

<template>
    <div class="content">
        <div class="d-flex justify-content-end">
            <button
                type="button"
                class="btn btn-alt-primary push"
                data-bs-toggle="modal"
                data-bs-target="#dsrSectionFormModal"
                :disabled="regions.length === 0"
            >
                <i class="si si-plus me-1"></i>
                <span>Add</span>
            </button>
        </div>

        <BaseBlock title="Roles table" content-full>
            <div v-if="list?.length == 0" class="text-center">No data</div>
            <Dataset v-else :ds-data="list">
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
                                            <td>{{ row.name }}</td>
                                            <td>
                                                {{
                                                    row.regions
                                                        .map(
                                                            (region) =>
                                                                region.name_uz
                                                        )
                                                        .join(", ")
                                                }}
                                            </td>
                                            <td>{{ row.details }}</td>
                                            <td>
                                                {{
                                                    helpers.formatDate(
                                                        row.updated_at,
                                                        "DD-MM-YYYY"
                                                    )
                                                }}
                                            </td>
                                            <td class="d-flex gap-2">
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary w-auto"
                                                    @click="onEdit(row.id)"
                                                >
                                                    <i class="si si-pencil"></i>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-danger w-auto"
                                                    @click="onRemove(row.id)"
                                                >
                                                    <i class="si si-trash"></i>
                                                </button>
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

        <!-- Modals -->
        <div
            class="modal fade"
            id="dsrSectionFormModal"
            tabindex="-1"
            aria-labelledby="roleFormModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="roleFormModalLabel">
                            {{
                                isEditing
                                    ? "Edit section data"
                                    : "Add section data"
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
                                    <InputLabel for="name-input">
                                        <span>Name</span>
                                        <span class="text-danger">*</span>
                                    </InputLabel>
                                    <Input
                                        id="name-input"
                                        type="text"
                                        v-model="sectionForm.name"
                                    />
                                    <InputError
                                        :message="sectionForm.errors?.name"
                                    />
                                </div>
                                <div class="col-12 mb-3">
                                    <InputLabel for="soatos-input">
                                        <span>Select regions</span>
                                        <span class="text-danger">*</span>
                                    </InputLabel>
                                    <Multiselect
                                        v-model="selectedRegions"
                                        mode="tags"
                                        value-prop="id"
                                        label="name_uz"
                                        :options="regions"
                                        :close-on-select="false"
                                        :searchable="true"
                                        :suspensible="false"
                                    />
                                    <InputError
                                        :message="sectionForm.errors?.soatos"
                                    />
                                </div>
                                <div class="col-12 mb-3">
                                    <InputLabel
                                        for="details-input"
                                        value="Details"
                                    />
                                    <textarea
                                        id="details-input"
                                        class="form-control"
                                        v-model="sectionForm.details"
                                    />
                                    <InputError
                                        :message="sectionForm.errors?.details"
                                    />
                                </div>

                                <div class="col-auto ms-auto">
                                    <Button>Submit</Button>
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

<!-- <style src="@vueform/multiselect/themes/default.css"></style> -->
<style lang="scss" scoped>
button:disabled {
    cursor: not-allowed !important;
}
</style>
