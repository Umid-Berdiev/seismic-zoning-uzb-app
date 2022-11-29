<script setup>
import { computed, onMounted, reactive, ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Dataset, DatasetItem } from "vue-dataset";
import { Modal } from "bootstrap";
import { useNotyf } from "@/composable/useNotyf";
import Input from "@/Components/Input.vue";
import Button from "@/Components/Button.vue";
import helpers from "@/utils/helper.js";
// Vue Dataset, for more info and examples you can check out https://github.com/kouts/vue-dataset/tree/next
import BaseBlock from "@/Components/BaseBlock.vue";
import InputLabel from "@/Components/InputLabel.vue";
import ConfirmModal from "@/Components/Modals/ConfirmModal.vue";
import InputError from "@/Components/InputError.vue";
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";

const props = defineProps({
    users: {
        type: Array,
        default: () => [],
    },
    roles: {
        type: Array,
        default: () => [],
    },
});
const notif = useNotyf();
const modal = ref(null);
// const modal = computed(() => Modal.getOrCreateInstance("#userFormModal"));
const columns = reactive([
    {
        name: "Ismi",
        field: "first_name",
    },
    {
        name: "Familiyasi",
        field: "last_name",
    },
    {
        name: "Foydalanuvchi nomi (Login)",
        field: "username",
    },
    {
        name: "Elektron manzili",
        field: "email",
    },
    {
        name: "Roli",
        field: "roles",
    },
    {
        name: "Faollik statusi",
        field: "is_active",
    },
    // {
    //     name: "Updated at",
    //     field: "updated_at",
    // },
]);
const userObj = reactive({
    username: "",
    first_name: "",
    last_name: "",
    email: "",
    role_id: null,
    is_active: null,
});
const userForm = useForm({
    username: "",
    first_name: "",
    last_name: "",
    email: "",
    role_id: null,
    is_active: null,
});
const isEditing = ref(false);
const isLoading = ref(false);

onMounted(() => {
    modal.value = new Modal("#userFormModal");
    modal.value._element.addEventListener("hidden.bs.modal", () => {
        isEditing.value = false;
        userForm.reset();
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
        // const modal = document.querySelector("#userFormModal");

        isEditing.value
            ? userForm.put(route("users.update", userObj.id), {
                  onSuccess: () => {
                      notif.success("Ma'lumotlar muvaffaqiyatli saqlandi!");
                      userForm.reset();
                      modal.value?.hide();
                  },
                  //   onError: (errorObj) => {
                  //       console.log({ errorObj });
                  //       notif.error("Error while updating user!");
                  //   },
              })
            : userForm.post(route("users.store"), {
                  onSuccess: () => {
                      notif.success("Ma'lumotlar muvaffaqiyatli saqlandi!");
                      userForm.reset();
                      modal.value?.hide();
                      //   modal.hide();
                  },
                  //   onError: (errorObj) => {
                  //       notif.error("Error while creating user!");
                  //   },
              });
    } catch (error) {
        notif.error("Ma'lumotlarni saqlashda hatolik!");
    } finally {
        isLoading.value = false;
    }
}

function onEdit(id) {
    isEditing.value = true;
    const selectedUser = props.users.find((user) => user.id === id);
    Object.assign(userObj, selectedUser);
    userForm.role_id = userObj.role_id = selectedUser.roles[0].id;
    userForm.first_name = selectedUser.first_name;
    userForm.last_name = selectedUser.last_name;
    userForm.username = selectedUser.username;
    userForm.email = selectedUser.email;
    userForm.is_active = selectedUser.is_active;
    // modal.value?.show();
}

function onRemove(id) {
    userObj.id = id;
    // const confirmModal = Modal.getOrCreateInstance("#modal-confirm");
    // confirmModal.show();
}

function deleteAction() {
    const confirmModal = Modal.getInstance("#modal-confirm");
    roleForm.delete(route("users.destroy", userObj.id), {
        onSuccess: () => {
            notif.success("User successfully removed!");
            // modal.value?.hide();
        },
        onError: (errorObj) => {
            notif.error("Error while deleting user!");
        },
    });
    confirmModal.hide();
}
</script>

<template>
    <div class="content">
        <div class="d-flex justify-content-end">
            <button
                type="button"
                class="btn btn-alt-primary push"
                data-bs-toggle="modal"
                data-bs-target="#userFormModal"
            >
                <i class="si si-plus me-1"></i>
                <span>Yangi foydalanuvchi qo'shish</span>
            </button>
        </div>

        <BaseBlock title="Foydalanuvchilar jadvali" content-full>
            <div v-if="users?.length == 0" class="text-center">
                {{ $t("No_data") }}
            </div>
            <Dataset v-else :ds-data="users">
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
                                            <td>{{ row.first_name }}</td>
                                            <td>{{ row.last_name }}</td>
                                            <td>{{ row.username }}</td>
                                            <td>{{ row.email }}</td>
                                            <td>{{ row.roles[0].name }}</td>
                                            <td>
                                                {{
                                                    row.is_active
                                                        ? "Aktiv"
                                                        : "Aktiv emas"
                                                }}
                                            </td>
                                            <td class="d-flex gap-2">
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary w-auto"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#userFormModal"
                                                    @click="onEdit(row.id)"
                                                >
                                                    <i class="si si-pencil"></i>
                                                </button>
                                                <!-- <button
                                                    type="button"
                                                    class="btn btn-danger w-auto"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-confirm"
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

        <!-- Modal -->
        <div
            class="modal fade"
            id="userFormModal"
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
                                    ? "Foydalanuvchi ma'lumotlarini o'zgartirish"
                                    : "Yangi foydalanuvchi ma'lumotlarini yaratish"
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
                                    <InputLabel
                                        value="Foydalanuvchi nomi (login)"
                                        for="username"
                                    />
                                    <Input
                                        id="username"
                                        type="text"
                                        v-model="userForm.username"
                                    />
                                    <InputError
                                        :message="userForm.errors.username"
                                    />
                                </div>
                                <div class="col-12 mb-3">
                                    <InputLabel value="Ismi" for="first_name" />
                                    <Input
                                        id="first_name"
                                        type="text"
                                        v-model="userForm.first_name"
                                    />
                                    <InputError
                                        :message="userForm.errors.first_name"
                                    />
                                </div>
                                <div class="col-12 mb-3">
                                    <InputLabel
                                        value="Familiyasi"
                                        for="last_name"
                                    />
                                    <Input
                                        id="last_name"
                                        type="text"
                                        v-model="userForm.last_name"
                                    />
                                    <InputError
                                        :message="userForm.errors.last_name"
                                    />
                                </div>
                                <div v-if="!isEditing" class="col-12 mb-3">
                                    <InputLabel
                                        value="Elektron manzili"
                                        for="email"
                                    />
                                    <Input
                                        id="email"
                                        type="text"
                                        v-model="userForm.email"
                                    />
                                    <InputError
                                        :message="userForm.errors.email"
                                    />
                                </div>
                                <div class="col-12 mb-3">
                                    <InputLabel value="Roli" for="user_role" />
                                    <select
                                        id="user_role"
                                        class="form-select"
                                        aria-label="Role select"
                                        :disabled="userForm.role_id === 1"
                                        v-model="userForm.role_id"
                                    >
                                        <option selected disabled :value="null">
                                            Rol tanlang
                                        </option>
                                        <option
                                            v-for="item in roles"
                                            :value="item.id"
                                        >
                                            {{ item.name }}
                                        </option>
                                    </select>
                                    <InputError
                                        :message="userForm.errors.role_id"
                                    />
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-check form-switch">
                                        <input
                                            v-model="userForm.is_active"
                                            class="form-check-input"
                                            type="checkbox"
                                            id="user_status"
                                            checked
                                        />
                                        <label
                                            class="form-check-label"
                                            for="user_status"
                                            >Faolmi?</label
                                        >
                                    </div>
                                </div>

                                <div class="col-auto ms-auto">
                                    <SubmitButton
                                        :loading="userForm.processing"
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

<style lang="scss" scoped>
//
</style>
