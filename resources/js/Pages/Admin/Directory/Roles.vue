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

const props = defineProps({
    roles: {
        type: Array,
        default: () => [],
    },
});
const notyf = useNotyf();
const role = reactive({
    name: "",
    // slug: "",
    details: "",
});
const roleForm = useForm(role);
const modal = computed(() => Modal.getOrCreateInstance("#roleFormModal"));
const columns = reactive([
    {
        name: "Name",
        field: "name",
    },
    {
        name: "Slug",
        field: "slug",
    },
    {
        name: "Details",
        field: "details",
    },
    {
        name: "Updated at",
        field: "updated_at",
    },
]);
const isEditing = ref(false);

onMounted(() => {
    modal.value?._element.addEventListener("hidden.bs.modal", (event) => {
        roleForm.reset();
        roleForm.clearErrors();
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
    isEditing.value
        ? roleForm.put(route("roles.update", role.id), {
              onSuccess: () => {
                  notyf.success("Role successfully updated!");
                  modal.value?.hide();
                  roleForm.reset();
                  roleForm.clearErrors();
                  isEditing.value = false;
              },
              onError: (errorObj) => {
                  notyf.error("Error while updating role!");
              },
          })
        : roleForm.post(route("roles.store"), {
              onSuccess: () => {
                  notyf.success("Role successfully updated!");
                  modal.value?.hide();
                  roleForm.reset();
                  roleForm.clearErrors();
                  isEditing.value = false;
              },
              onError: (errorObj) => {
                  notyf.error("Error while creating role!");
              },
          });
}

function onEdit(id) {
    isEditing.value = true;
    const selectedRole = props.roles.find((role) => role.id === id);
    Object.assign(role, selectedRole);
    roleForm.name = selectedRole.name;
    // roleForm.slug = selectedRole.slug;
    roleForm.details = selectedRole.details;
    modal.value?.toggle();
}

function onRemove(id) {
    role.id = id;
    const confirmModal = Modal.getOrCreateInstance("#modal-confirm");
    confirmModal.show();
}

function deleteAction() {
    roleForm.delete(route("roles.destroy", role.id), {
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
        <!-- <div class="d-flex justify-content-end">
            <button
                type="button"
                class="btn btn-alt-primary push"
                data-bs-toggle="modal"
                data-bs-target="#roleFormModal"
            >
                <i class="si si-plus me-1"></i>
                <span>Add</span>
            </button>
        </div> -->

        <BaseBlock :title="$t('Roles_table')" content-full>
            <div v-if="roles?.length == 0" class="text-center">
                {{ $t("No_data") }}
            </div>
            <Dataset v-else :ds-data="roles">
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
                                            <td>{{ row.name }}</td>
                                            <td>{{ row.slug }}</td>
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
                                    <InputLabel for="name-input">
                                        <span>{{ $t("Name") }}</span>
                                        <span class="text-danger">*</span>
                                    </InputLabel>
                                    <Input
                                        id="name-input"
                                        type="text"
                                        v-model="roleForm.name"
                                    />
                                    <InputError
                                        :message="roleForm.errors?.name"
                                    />
                                </div>
                                <!-- <div class="col-12 mb-3">
                                    <InputLabel for="slug-input">
                                        <span>Slug</span>
                                        <span class="text-danger">*</span>
                                    </InputLabel>
                                    <Input
                                        id="slug-input"
                                        type="text"
                                        v-model="roleForm.slug"
                                    />
                                    <InputError
                                        :message="roleForm.errors?.slug"
                                    />
                                </div> -->
                                <div class="col-12 mb-3">
                                    <InputLabel
                                        for="details-input"
                                        value="Details"
                                    />
                                    <textarea
                                        id="details-input"
                                        class="form-control"
                                        v-model="roleForm.details"
                                    />
                                    <InputError
                                        :message="roleForm.errors?.details"
                                    />
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

        <ConfirmModal @confirm="deleteAction" />
    </div>
</template>

<style lang="scss" scoped>
//
</style>
