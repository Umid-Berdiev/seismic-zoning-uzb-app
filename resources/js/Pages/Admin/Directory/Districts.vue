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

const props = defineProps({
    districts: {
        type: Array,
        default: () => [],
    },
});
const notyf = useNotyf();
const modal = computed(() => Modal.getOrCreateInstance("#roleFormModal"));
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
    {
        name: "Name ru",
        field: "name_ru",
    },
    {
        name: "Admincenter uz",
        field: "admincenter_uz",
    },
    {
        name: "Admincenter ru",
        field: "admincenter_ru",
    },
]);

const role = reactive({
    name: "",
    slug: "",
    details: "",
});
const roleForm = useForm(role);
const isEditing = ref(false);

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

async function onModalFormSubmit() {
    isEditing.value
        ? roleForm.put(route("districts.update", role.id), {
              onSuccess: () => {
                  notyf.success("Role successfully updated!");
                  modal.value?.hide();
              },
              onError: (errorObj) => {
                  notyf.error("Error while updating role!");
              },
          })
        : roleForm.post(route("districts.store"), {
              onSuccess: () => {
                  notyf.success("Role successfully updated!");
                  modal.value?.hide();
              },
              onError: (errorObj) => {
                  notyf.error("Error while creating role!");
              },
          });
}

function onEdit(id) {
    // isEditing.value = true;
    // const selectedRole = props.districts.find((role) => role.id === id);
    // Object.assign(role, selectedRole);
    // roleForm.name = selectedRole.name;
    // roleForm.slug = selectedRole.slug;
    // roleForm.details = selectedRole.details;
    // modal.value?.toggle();
}

function onRemove(id) {
    role.id = id;
    const confirmModal = Modal.getOrCreateInstance("#modal-confirm");
    confirmModal.show();
}

function deleteAction() {
    roleForm.delete(route("districts.destroy", role.id), {
        onSuccess: () => {
            notyf.success("Role successfully removed!");
            modal.value?.hide();
        },
        onError: (errorObj) => {
            notyf.error("Error while deleting role!");
        },
    });
}
</script>

<template>
    <div class="content">
        <div class="d-flex">
            <button
                type="button"
                class="btn btn-alt-primary push"
                @click="useForm().get(route('regions.index'))"
            >
                <i class="si si-arrow-left me-1"></i>
                <span>Back</span>
            </button>
            <button
                type="button"
                class="btn btn-alt-primary push ms-auto"
                data-bs-toggle="modal"
                data-bs-target="#modal-confirm"
            >
                <i class="si si-cloud-download me-1"></i>
                <span>Export to excel</span>
            </button>
        </div>

        <BaseBlock title="Districts table" content-full>
            <div v-if="districts?.length == 0" class="text-center">No data</div>
            <Dataset v-else :ds-data="districts">
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
                                        <th>Actions</th>
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
                                            <td>{{ row.name_ru }}</td>
                                            <td>{{ row.admincenter_uz }}</td>
                                            <td>{{ row.admincenter_ru }}</td>
                                            <td class="d-flex gap-2">
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary w-auto"
                                                    @click="onEdit(row.soato)"
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
            </Dataset>
        </BaseBlock>

        <!-- Modals -->
        <div
            class="modal fade"
            id="roleFormModal"
            tabindex="-1"
            aria-labelledby="roleFormModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="roleFormModalLabel">
                            {{ isEditing ? "Edit role data" : "Add role data" }}
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
                                    <InputLabel value="Name" />
                                    <Input
                                        type="text"
                                        v-model="roleForm.name"
                                    />
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                    >
                                        {{ roleForm.errors?.name }}
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <InputLabel value="Slug" />
                                    <Input
                                        type="text"
                                        v-model="roleForm.slug"
                                    />
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                    >
                                        {{ roleForm.errors?.slug }}
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <InputLabel value="Details" />
                                    <textarea
                                        class="form-control"
                                        v-model="roleForm.details"
                                    />
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                    >
                                        {{ roleForm.errors?.details }}
                                    </div>
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

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    layout: AdminLayout,
};
</script>

<style lang="scss" scoped>
//
</style>
